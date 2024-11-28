<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\PaymentDetails;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    // Payment
    public function checkout($ref_code)
    {
        $invoiceInfo = Invoice::where('ref_code', $ref_code)->first();

        if (!empty($invoiceInfo)) {

            $provider = new PayPalClient($this->config());

            $provider->getAccessToken();

            $response = $provider->createOrder([
                'intent'              => 'CAPTURE',
                'application_context' => [
                    'return_url' => route('paypal.success'),
                    'cancel_url' => route('paypal.cancel'),
                ],
                'purchase_units'      => [
                    [
                        'reference_id' => 'Invoice No: ' . $invoiceInfo->invoice_no,
                        'amount'       => [
                            'currency_code' => 'USD',
                            'value'         => $invoiceInfo->grand_total
                        ],
                    ]
                ]
            ]);

            if (!empty($response['id'])) {
                foreach ($response['links'] as $link) {
                    if ($link['rel'] == 'approve') {

                        $paymentDetails = PaymentDetails::firstOrNew(['invoice_id' => $invoiceInfo->id]);

                        $paymentDetails->invoice_id = $invoiceInfo->id;
                        $paymentDetails->token      = $response['id'];

                        $paymentDetails->save();

                        return redirect()->away($link['href']);
                    }
                }
            }
        }

        return redirect()->route('paypal.cancel');
    }

    // Success
    public function success(Request $request)
    {
        $provider = new PayPalClient($this->config());

        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);

        if (!empty($response['status']) && $response['status'] == 'COMPLETED') {

            $paymentDetails = PaymentDetails::where('token', $request->token)->first();

            $paymentDetails->payment_id = $response['id'];
            $paymentDetails->name       = $response['payment_source']['paypal']['name']['given_name'] . ' ' . $response['payment_source']['paypal']['name']['surname'];
            $paymentDetails->email      = $response['payment_source']['paypal']['email_address'];
            $paymentDetails->currency   = $response['payment_source']['paypal']['address']['country_code'];
            $paymentDetails->status     = $response['status'];

            $paymentDetails->save();

            if (!empty($paymentDetails)) {
                $invoiceInfo = Invoice::find($paymentDetails->invoice_id);
                Order::whereIn('id', json_decode($invoiceInfo->order_id))->update(['status' => 'paid']);

                $invoiceInfo->is_payment   = 1;
                $invoiceInfo->status       = 'paid';
                $invoiceInfo->payment_date = date('Y-m-d');

                $invoiceInfo->update();
            }

            flash()->addSuccess('PayPal payment success.');

            return redirect()->route('home');
        }

        return redirect()->route('paypal.cancel');
    }

    // Cancel
    public function cancel(Request $request)
    {
        flash()->addError('Something went wrong try again later!');

        return redirect()->route('home');
    }

    // Config
    public function config()
    {
        $info = PaymentMethod::where('name', 'like', '%PayPal%')->first();

        $mode          = (!empty($info) && $info->mode == 1 ? 'live' : 'sandbox');
        $client_id     = (!empty($info->public_key) ? $info->public_key : '');
        $client_secret = (!empty($info->secret_key) ? $info->secret_key : '');


        return [
            'mode'    => $mode,
            'sandbox' => [
                'client_id'     => $client_id,
                'client_secret' => $client_secret,
                'app_id'        => 'APP-80W284485P519543T',
            ],

            'live' => [
                'client_id'     => $client_id,
                'client_secret' => $client_secret,
                'app_id'        => '',
            ],

            'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'),
            'currency'       => env('PAYPAL_CURRENCY', 'USD'),
            'notify_url'     => env('PAYPAL_NOTIFY_URL', ''),
            'locale'         => env('PAYPAL_LOCALE', 'en_US'),
            'validate_ssl'   => env('PAYPAL_VALIDATE_SSL', true),
        ];
    }
}
