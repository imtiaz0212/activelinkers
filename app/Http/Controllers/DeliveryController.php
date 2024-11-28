<?php

namespace App\Http\Controllers;

use App\Models\BillingType;
use App\Models\Customer;
use App\Models\CustomJobs;
use App\Models\EmailFrom;
use App\Models\EmailList;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DeliveryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->data['billingType'] = BillingType::where('status', 1)->get();
        $this->data['methods']     = PaymentMethod::where('status', 1)->get();

        $this->data['activeMenu'] = 'invoice';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->data['emailList'] = EmailFrom::all();

        return view('invoice.delivery-create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id   = Auth::user()->id;
        $privilege = Auth::user()->privilege;

        // store customer data
        $customer            = Customer::firstOrNew(['email' => $request->email]);
        $customer->full_name = $request->full_name;
        $customer->email     = $request->email;
        $customer->save();

        // store order data
        $orderMaxId  = DB::table('orders')->max('id');
        $orderSerial = (!empty($orderMaxId) ? $orderMaxId : 0) + 1;
        $orderNo     = str_pad($orderSerial, 6, '0', STR_PAD_LEFT);
        $subtotal    = is_numeric($request->subtotal) ? (float)$request->subtotal : 0;
        //$serviceCharge = is_numeric($request->service_charge) ? (float)$request->service_charge : 0;
        //$tax           = is_numeric($request->tax) ? (float)$request->tax : 0;
        $discount   = is_numeric($request->discount) ? (float)$request->discount : 0;
        $grandTotal = is_numeric($request->grand_total) ? (float)$request->grand_total : 0;

        $order                = new Order;
        $order->created       = date('Y-m-d');
        $order->order_no      = $orderNo;
        $order->privilege     = $privilege;
        $order->user_id       = $user_id;
        $order->email         = $request->email;
        $order->delivery_date = $request->delivery_date;
        $order->billing_type  = $request->billing_type;
        $order->status        = 'pending';
        $order->order_type    = 'delivery';
        $order->subtotal      = $subtotal;
        //$order->service_charge = $serviceCharge;
        //$order->tax            = $tax;
        $order->discount      = $discount;
        $order->grand_total   = $grandTotal;
        $order->email_from_id = $request->email_from_id;
        $order->save();

        // store order items
        foreach ($request->url as $key => $url) {
            $orderItem                 = new OrderItem;
            $orderItem->created        = date('Y-m-d');
            $orderItem->order_id       = $order->id;
            $orderItem->url            = $url;
            $orderItem->entity_name    = $request->entity_name[$key];
            $orderItem->live_url       = $request->live_link[$key];
            $orderItem->url_price      = $request->url_price[$key];
            $orderItem->anchor         = $request->anchor[$key];
            $orderItem->is_other_price = $request->other_link_price[$key];
            $orderItem->link_insert    = $request->link_insert[$key];
            $orderItem->other_price    = $request->other_price[$key];
            $orderItem->total          = $request->total[$key];
            $orderItem->artical        = $request->article_amount[$key];
            $orderItem->save();
        }

        // store invoice data
        $invoiceMaxId  = DB::table('invoices')->max('id');
        $invoiceSerial = (!empty($invoiceMaxId) ? $invoiceMaxId : 0) + 1;
        $invoiceNo     = str_pad($invoiceSerial, 6, '0', STR_PAD_LEFT);
        $refCode       = strtolower(Str::random(14));

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
        $invoice->grand_total  = $grandTotal;
        $invoice->method_id    = $request->method_id;
        $invoice->is_send      = isset($request->send_mail) ? 1 : 0;
        $invoice->status       = 'unpaid';
        $invoice->invoice_type = 'delivery';
        $invoice->save();

        // store email
        if (!empty($request->email)) {
            $emailList                    = EmailList::firstOrNew(['email' => $request->email]);
            $emailList->email_category_id = 1;
            $emailList->from              = 'delivery';
            $emailList->save();
        }

        // send email
        if (isset($request->send_mail)) {
            $invoiceInfo = Invoice::with('customer')->find($invoice->id);
            $orderInfo   = Order::with('emailFrom')->whereIn('id', json_decode($invoice->order_id))->get();

            $emailFrom = $orderInfo[0]->emailFrom->email;
            $emailTo   = $invoiceInfo->email;
            $subject   = 'Order Confirmation for Your Invoice (' . $invoiceInfo->invoice_no . ')';
            $mailData  = ['invoiceInfo' => $invoiceInfo, 'orderInfo' => $orderInfo];

            //sendMail()->send($emailFrom, $emailTo, $subject, $mailData, 'mail.order-invoice');
            CustomJobs::create([
                'from'     => $emailFrom,
                'to'       => $emailTo,
                'subject'  => $subject,
                'details'  => json_encode($mailData),
                'template' => 'mail.order-invoice',
            ]);
            //Mail::to($invoiceInfo->customer->email)->send(new OrderInvocie($invoiceInfo, $orderInfo, $emailFrom));
        }

        flash()->addSuccess('Invoice delivered successfully.');
        return redirect()->route('admin.invoice');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
