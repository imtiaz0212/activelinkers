<?php

namespace App\Http\Controllers;

use App\Mail\PaymentConfirmMail;
use App\Models\Customer;
use App\Models\CustomJobs;
use App\Models\EmailList;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentDetails;
use App\Models\PaymentMethod;
use App\Models\SiteList;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StripeController extends Controller
{
    protected $stripPk;
    protected $stripSk;
    protected $orderType = [1 => 'Link insertion', 2 => 'Guest posting'];

    public function __construct()
    {
        $methodInfo    = PaymentMethod::where('name', 'like', '%Strip%')->where('status', 1)->first();
        $this->stripPk = $methodInfo->public_key ?? '';
        $this->stripSk = $methodInfo->secret_key ?? '';
    }

    public function cartPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'country_id' => 'required|string',
            'address'    => 'required|string',
            'city'       => 'required|string',
            'state'      => 'required|string',
            'zip_code'   => 'required|string',
            'phone'      => 'required|regex:/^[0-9]{10,15}$/',
            'email'      => 'required|email',
        ]);

        if ($validator->fails()) {
            flash()->addError('Invalid credentials, Please check and submit again.');
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        // set cart form data
        session()->put('cart_form_data', $request->except('_token'));

        // check cart exist
        $cart        = session()->get('cart', []);
        $totalAmount = session('cart_total', 0);
        if (empty($cart) && empty($totalAmount)) {
            flash()->addError('Cart not found', 'Error');
            return redirect('/websites');
        }

        // generate reference code
        $refCode = strtolower(Str::random(14));

        /* generate line items */
        $lineItems = [];
        foreach ($cart as $pId => $row) {
            $row  = (object)$row;
            $item = [
                'price_data' => [
                    'currency'     => 'usd',
                    'product_data' => [
                        'name' => $this->orderType[$row->billing_type] . ', ' . $row->title
                    ],
                    'unit_amount'  => $row->price * 100,
                ],
                'quantity'   => round($row->quantity, 2),
            ];

            array_push($lineItems, $item);
        }

        $customerName = $request->first_name . ' ' . $request->last_name;
        $description  = "SEO Service - Ref.No#{$refCode} - {$customerName} - Total: $" . round($totalAmount, 2);

        /* initial stripe client */
        $provider     = new StripeClient($this->stripSk);
        $responseData = [
            'payment_intent_data' => ['description' => $description],
            'line_items'          => [$lineItems],
            'mode'                => 'payment',
            'success_url'         => route('cart.stripe.success') . '?session_id={CHECKOUT_SESSION_ID}&ref_code=' . $refCode,
            'cancel_url'          => route('stripe.cancel'),
        ];

        // Conditionally add the discount if a coupon is available
        $cartCoupon = session('cart_coupon');
        if (!empty($cartCoupon)) {

            // Discount applies once; you can use 'repeating' or 'forever'
            $couponData = ['duration' => 'once'];

            if ($cartCoupon['type'] === 'percentage') {
                $couponData['percent_off'] = round($cartCoupon['discount'], 2);
            } elseif ($cartCoupon['type'] === 'fixed') {
                $couponData['amount_off'] = round($cartCoupon['discount'], 2) * 100;
                $couponData['currency']   = 'usd';
            }

            $coupon = $provider->coupons->create($couponData);

            $responseData['discounts'] = [['coupon' => $coupon->id]];
        }

        // Create the session with the finalized response data
        $response = $provider->checkout->sessions->create($responseData);
        if (!empty($response->id) && $response->id != '') {
            return redirect()->away($response->url);
        }

        return redirect()->route('stripe.cancel');
    }

    public function cartSuccess(Request $request)
    {
        $refCode   = $request->query('ref_code');
        $sessionId = $request->query('session_id');
        if (!empty($sessionId) && !empty($refCode)) {

            $provider = new StripeClient($this->stripSk);
            $response = $provider->checkout->sessions->retrieve($sessionId);

            if ($response->status == 'complete') {

                // generate order and invoice
                $results     = $this->storeCartOrderAndInvoice($refCode);
                $orderInfo   = $results['orderInfo'];
                $invoiceInfo = $results['invoiceInfo'];

                // store payment details
                $paymentDetails             = PaymentDetails::firstOrNew(['invoice_id' => $invoiceInfo->id]);
                $paymentDetails->token      = $sessionId;
                $paymentDetails->payment_id = $response->payment_intent;
                $paymentDetails->currency   = $response->currency;
                $paymentDetails->name       = $invoiceInfo->customer->full_name;
                $paymentDetails->email      = $invoiceInfo->email;
                $paymentDetails->status     = $response->status;
                $paymentDetails->save();


                // send email
                try {
                    // Send confirmation email order
                    $emailFrom = $orderInfo[0]->emailFrom->email;
                    $emailTo   = $invoiceInfo->email;
                    $subject   = 'Order Confirmation for Your Invoice (' . $invoiceInfo->invoice_no . ')';
                    $mailData  = [
                        'invoiceInfo' => $invoiceInfo,
                        'orderInfo'   => $orderInfo,
                    ];
                    //sendMail()->send($emailFrom, $emailTo, $subject, $mailData, 'mail.order-invoice');
                    CustomJobs::create([
                        'from'     => $emailFrom,
                        'to'       => $emailTo,
                        'subject'  => $subject,
                        'details'  => json_encode($mailData),
                        'template' => 'mail.order-invoice',
                    ]);

                    // send payment confirm email
                    $subject = 'Payment Confirmation for Your Invoice (' . $invoiceInfo->invoice_no . ')';
                    //sendMail()->send($emailFrom, $emailTo, $subject, $mailData, 'mail.payment-confirm');
                    CustomJobs::create([
                        'from'     => $emailFrom,
                        'to'       => $emailTo,
                        'subject'  => $subject,
                        'details'  => json_encode($mailData),
                        'template' => 'mail.payment-confirm',
                    ]);

                    flash()->addSuccess('Stripe payment success.');
                } catch (\Exception $e) {
                    flash()->addError($e->getMessage());
                }

                // forget cart session
                session()->forget(['cart', 'cart_coupon', 'cart_subtotal', 'cart_discount', 'cart_total', 'cart_form_data']);

                return redirect(url('invoice/' . $invoiceInfo->ref_code));
            }
        }

        return redirect()->route('stripe.cancel');
    }

    // Stripe Payment
    public function payment(Request $request, $ref_code)
    {
        if (!empty($ref_code) && !empty($request->stripeToken)) {

            $invoiceInfo = Invoice::with('customer')->where('ref_code', $ref_code)->first();
            $orderInfo   = Order::with('billType')->whereIn('id', json_decode($invoiceInfo->order_id))->first();
            $billingType = (!empty($orderInfo->billType) ? $orderInfo->billType->name : '');

            if (empty($invoiceInfo) || $invoiceInfo->status == 'paid') {
                flash()->addError('Unauthorized payment?', 'Error');
                return redirect()->route('home');
            }

            $provider = new StripeClient($this->stripSk);

            $customer = $provider->customers->create([
                'source' => $request->stripeToken,
                'email'  => $invoiceInfo->email,
                'name'   => $invoiceInfo->customer->full_name
            ]);

            $description = "SEO Service - Ref.No#{$ref_code} - {$invoiceInfo->customer->full_name} - Total: $" . round($invoiceInfo->grand_total, 2);

            $response = $provider->charges->create([
                'amount'      => $invoiceInfo->grand_total * 100,
                'currency'    => 'usd',
                'description' => $description,
                'customer'    => $customer->id,
                'metadata'    => [
                    'Order No'     => $invoiceInfo->invoice_no,
                    'Billing Type' => $billingType
                ]
            ]);

            if ($response->status == 'succeeded') {

                // store payment details
                $paymentDetails             = PaymentDetails::firstOrNew(['invoice_id' => $invoiceInfo->id]);
                $paymentDetails->token      = $request->stripeToken;
                $paymentDetails->payment_id = $response->id;
                $paymentDetails->currency   = $response->currency;
                $paymentDetails->name       = $invoiceInfo->customer->full_name;
                $paymentDetails->email      = $invoiceInfo->email;
                $paymentDetails->status     = $response->status;
                $paymentDetails->save();

                // update order
                Order::whereIn('id', json_decode($invoiceInfo->order_id))->update(['status' => 'paid']);

                // update invoice
                $invoiceInfo->is_payment   = 1;
                $invoiceInfo->status       = 'paid';
                $invoiceInfo->payment_date = date('Y-m-d');

                $invoiceInfo->update();

                // send mail
                if (!empty($invoiceInfo->email)) {
                    $orderInfo = Order::with('emailFrom')->whereIn('id', json_decode($invoiceInfo->order_id))->get();

                    $emailFrom = $orderInfo[0]->emailFrom->email;
                    $emailTo   = $invoiceInfo->email;
                    $subject   = 'Payment Confirmation for Your Invoice (' . $invoiceInfo->invoice_no . ')';
                    $mailData  = [
                        'invoiceInfo' => $invoiceInfo,
                        'orderInfo'   => $orderInfo,
                    ];

                    sendMail()->send($emailFrom, $emailTo, $subject, $mailData, 'mail.payment-confirm');
                    //Mail::to($emailTo)->send(new PaymentConfirmMail($invoiceInfo, $orderInfo, $emailFrom));
                }

                flash()->addSuccess('Stripe payment success.');
                return redirect(url('invoice/' . $invoiceInfo->ref_code));
            }
        }

        flash()->addError('Unauthorized payment?', 'Error');
        return redirect()->route('home');
    }

    // Stripe Checkout
    public function checkout($ref_code)
    {
        $invoiceInfo = Invoice::with('customer')->where('ref_code', $ref_code)->first();

        if (!empty($invoiceInfo)) {

            $provider = new StripeClient($this->stripSk);

            $description = "SEO Service - Ref.No#{$ref_code} - {$invoiceInfo->customer->full_name} - Total: $" . round($invoiceInfo->grand_total, 2);
            $response    = $provider->checkout->sessions->create([
                'payment_intent_data' => ['description' => $description],
                'line_items'          => [
                    [
                        'price_data' => [
                            'currency'     => 'usd',
                            'product_data' => [
                                'name' => 'Invoice no: ' . $invoiceInfo->invoice_no
                            ],
                            'unit_amount'  => $invoiceInfo->grand_total * 100,
                        ],
                        'quantity'   => 1,
                    ],
                ],
                'mode'                => 'payment',
                'success_url'         => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}&ref_code=' . $ref_code,
                'cancel_url'          => route('stripe.cancel'),
            ]);

            if (!empty($response->id) && $response->id != '') {
                return redirect()->away($response->url);
            }
        }

        return redirect()->route('stripe.cancel');
    }

    // Stripe Success
    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
        $refCode   = $request->query('ref_code');
        if (!empty($sessionId) && !empty($refCode)) {

            $provider = new StripeClient($this->stripSk);
            $response = $provider->checkout->sessions->retrieve($request->session_id);

            if ($response->status == 'complete') {

                $invoiceInfo = Invoice::with('customer')->where('ref_code', $refCode)->first();

                // store payment details
                $paymentDetails             = PaymentDetails::firstOrNew(['invoice_id' => $invoiceInfo->id]);
                $paymentDetails->token      = $sessionId;
                $paymentDetails->payment_id = $response->payment_intent;
                $paymentDetails->currency   = $response->currency;
                $paymentDetails->name       = $invoiceInfo->customer->full_name;
                $paymentDetails->email      = $invoiceInfo->email;
                $paymentDetails->status     = $response->status;
                $paymentDetails->save();

                $redirectUrl = '';
                if (!empty($paymentDetails)) {

                    Order::whereIn('id', json_decode($invoiceInfo->order_id))->update(['status' => 'paid']);

                    $invoiceInfo->is_payment   = 1;
                    $invoiceInfo->status       = 'paid';
                    $invoiceInfo->payment_date = date('Y-m-d');

                    $invoiceInfo->update();

                    $redirectUrl = url('invoice/' . $invoiceInfo->ref_code);
                }

                flash()->addSuccess('Stripe payment success.');

                if (empty($redirectUrl)) {
                    return redirect()->route('home');
                }

                return redirect($redirectUrl);
            }
        }

        return redirect()->route('stripe.cancel');
    }

    // Cancel
    public function cancel(Request $request)
    {
        flash()->addError('Something went wrong try again later!');

        return redirect()->route('home');
    }

    // store cart order and invoice
    private function storeCartOrderAndInvoice($refCode)
    {
        $cart        = session('cart', []);
        $subtotal    = round(session('cart_subtotal', 0), 2);
        $discount    = round(session('cart_discount', 0), 2);
        $totalAmount = round(session('cart_total', 0), 2);
        $productIds  = array_keys($cart);
        $firstItem   = (object)reset($cart);
        $request     = (object)session('cart_form_data');

        $user_id   = 1;
        $privilege = 'admin';

        // store custom info
        $customer               = new Customer();
        $customer->full_name    = $request->first_name;
        $customer->last_name    = $request->last_name;
        $customer->full_name    = $request->first_name . ' ' . $request->last_name;
        $customer->company_name = $request->company_name;
        $customer->country_id   = $request->country_id;
        $customer->address      = $request->address;
        $customer->city         = $request->city;
        $customer->state        = $request->state;
        $customer->zip_code     = $request->zip_code;
        $customer->phone        = $request->phone;
        $customer->email        = $request->email;
        $customer->save();


        // store order info
        $orderMaxId  = DB::table('orders')->max('id');
        $orderSerial = (!empty($orderMaxId) ? $orderMaxId : 0) + 1;
        $orderNo     = str_pad($orderSerial, 6, '0', STR_PAD_LEFT);

        $order                = new Order();
        $order->created       = date('Y-m-d');
        $order->updated       = date('Y-m-d');
        $order->order_no      = $orderNo;
        $order->privilege     = $privilege;
        $order->user_id       = $user_id;
        $order->email         = $request->email;
        $order->delivery_date = date('Y-m-d', strtotime('+1 day'));
        $order->billing_type  = $firstItem->billing_type;
        $order->subtotal      = $subtotal;
        $order->grand_total   = $subtotal;
        $order->email_from_id = 1;
        $order->status        = 'paid';
        $order->order_type    = 'customer';
        $order->save();

        // store order items
        $websiteList = SiteList::whereIn('id', $productIds)->get();
        foreach ($cart as $pId => $row) {
            $row         = (object)$row;
            $websiteInfo = $websiteList->where('id', $pId)->first();
            $anchorList  = [['anchor_text' => '', 'link' => '']];

            $orderItem                 = new OrderItem;
            $orderItem->created        = date('Y-m-d');
            $orderItem->order_id       = $order->id;
            $orderItem->url            = $websiteInfo->url;
            $orderItem->live_url       = $websiteInfo->url;
            $orderItem->anchor         = json_encode($anchorList);
            $orderItem->is_other_price = ($row->niche == 'others' ? 'yes' : 'no');
            $orderItem->link_insert    = 'yes';
            $orderItem->url_price      = $websiteInfo->general_price;
            $orderItem->other_price    = ($row->niche == 'others' ? $websiteInfo->other_price : 0);
            $orderItem->total          = $row->price;
            $orderItem->save();
        }

        // store invoice data
        $invoiceMaxId  = DB::table('invoices')->max('id');
        $invoiceSerial = (!empty($invoiceMaxId) ? $invoiceMaxId : 0) + 1;
        $invoiceNo     = str_pad($invoiceSerial, 6, '0', STR_PAD_LEFT);

        $invoice               = new Invoice;
        $invoice->customer_id  = $customer->id;
        $invoice->invoice_no   = $invoiceNo;
        $invoice->ref_code     = $refCode;
        $invoice->privilege    = $privilege;
        $invoice->user_id      = $user_id;
        $invoice->order_id     = json_encode([(string)$order->id]);
        $invoice->created      = date('Y-m-d');
        $invoice->email        = $request->email;
        $invoice->subtotal     = $subtotal;
        $invoice->discount     = $discount;
        $invoice->grand_total  = $totalAmount;
        $invoice->method_id    = 1;
        $invoice->is_send      = 1;
        $invoice->is_payment   = 1;
        $invoice->status       = 'paid';
        $invoice->payment_date = date('Y-m-d');
        $invoice->invoice_type = 'customer';
        $invoice->save();

        // store email
        if (!empty($request->email)) {
            $emailList                    = EmailList::firstOrNew(['email' => $request->email]);
            $emailList->email_category_id = 1;
            $emailList->from              = 'website';
            $emailList->save();
        }

        // get invoice and order
        $invoiceInfo = Invoice::with('customer')->find($invoice->id);
        $orderInfo   = Order::with('emailFrom')->whereIn('id', json_decode($invoiceInfo->order_id))->get();

        return [
            'invoiceInfo' => $invoiceInfo,
            'orderInfo'   => $orderInfo,
        ];
    }
}
