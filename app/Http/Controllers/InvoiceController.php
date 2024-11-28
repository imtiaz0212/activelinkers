<?php

namespace App\Http\Controllers;

use App\Models\CustomJobs;
use App\Models\Order;
use App\Models\BillingType;
use App\Models\Admin;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\PaymentMethod;
use App\Models\Country;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->middleware(['permission:invoice,admin'])->only('index');
        $this->middleware(['permission:invoice create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:invoice edit,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:invoice show,admin'])->only('show');
        $this->middleware(['permission:invoice delete,admin'])->only('delete');
        $this->middleware(['permission:invoice destroy,admin'])->only('destroy');
        $this->middleware(['permission:invoice restore,admin'])->only('restore');
        $this->middleware(['permission:invoice send mail,admin'])->only('sendMail');
        $this->middleware(['permission:invoice warning mail,admin'])->only('warningMail');
        $this->middleware(['permission:invoice remove mail,admin'])->only('removeMail');

        $this->data['activeMenu'] = 'invoice';

        $this->data['countryList'] = DB::table('countries')->get();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->data['orderInfo']   = Order::get();
        $this->data['admin']       = Admin::get();
        $this->data['invoiceInfo'] = Invoice::emailList();
        $this->data['billingType'] = BillingType::get();

        $this->data['info'] = Invoice::realtimeSearch($request);

        $this->data['allInvoice'] = Invoice::all();

        return view('invoice.index', $this->data);
    }

    /**
     * Display a listing of the resource.
     */
    public function create()
    {
        $this->data['orderList'] = Order::pendingOrderList();

        $this->data['methods'] = PaymentMethod::where('status', 1)->get();

        return view('invoice.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id   = Auth::user()->id;
        $privilege = Auth::user()->privilege;

        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'email'     => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back();
        }

        // store customer info
        $customer            = new Customer();
        $customer->full_name = $request->full_name;
        $customer->phone     = $request->phone;
        $customer->email     = $request->email;
        $customer->address   = $request->address;
        $customer->save();

        // generate invoice no and reference code
        $invoiceMaxId  = DB::table('invoices')->max('id');
        $invoiceSerial = (!empty($invoiceMaxId) ? $invoiceMaxId : 0) + 1;
        $invoiceNo     = str_pad($invoiceSerial, 6, '0', STR_PAD_LEFT);
        $refCode       = strtolower(Str::random(14));

        $invoice              = new Invoice;
        $invoice->customer_id = $customer->id;
        $invoice->invoice_no  = $invoiceNo;
        $invoice->ref_code    = $refCode;
        $invoice->privilege   = $privilege;
        $invoice->user_id     = $user_id;
        $invoice->order_id    = json_encode($request->order_id);
        $invoice->created     = date('Y-m-d');

        if (!empty($request->order_id)) {
            if (is_array($request->order_id)) {
                $orderId = implode(', ', $request->order_id);
                DB::select("UPDATE orders SET status='pending', updated=CURDATE() WHERE id IN ($orderId)");
            }
        }

        if (!empty($request->email)) {
            $invoice->email = $request->email;
        }

        if (!empty($request->description)) {
            $invoice->description = $request->description;
        }

        if (!empty($request->subtotal)) {
            $invoice->subtotal = $request->subtotal;
        }

        if (!empty($request->discount)) {
            $invoice->discount = $request->discount;
        }

        if (!empty($request->grand_total)) {
            $invoice->grand_total = $request->grand_total;
        }

        if (!empty($request->method_id)) {
            $invoice->method_id = $request->method_id;
        }

        if (!empty($request->send_mail)) {
            $invoice->is_send = 1;
        }

        $invoice->save();

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
        flash()->addSuccess('Invoice Create Successful.');

        return redirect()->route('admin.invoice');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function show($refCode)
    {
        $this->data['countryList'] = Country::get();

        $this->data['invoiceInfo'] = $invoiceInfo = Invoice::with('customer', 'method', 'admin')->where('ref_code', $refCode)->first();

        $this->data['orderList'] = Order::with('admin', 'orderItem', 'emailFrom', 'billType')->whereIn('id', json_decode($invoiceInfo->order_id))->withTrashed()->get();

        return view('invoice.show', $this->data);
    }

    /**
     * Edit Order Page.
     */
    public function edit($id)
    {
        $this->data['orderList'] = Order::pendingOrderList();

        $this->data['method'] = PaymentMethod::where('status', 1)->get();

        $this->data['info'] = $info = Invoice::with('admin', 'customer', 'method')->where('id', $id)->first();

        $this->data['orderInfo'] = Order::with('admin', 'orderItem')->whereIn('id', json_decode($info->order_id))->get();

        return view('invoice.edit', $this->data);
    }

    //Update All Data
    public function update(Request $request, string $id)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'email'      => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back();
        }

        $customer = Customer::find($request->customer_id);

        $customer->full_name = $request->first_name;
        //$customer->last_name     = $request->last_name;
        //$customer->company_name = $request->business_name;
        //$customer->code          = $request->code;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        //$customer->country_id    = $request->country_id;
        // $customer->street_name   = $request->street_name;
        $customer->address = $request->address;
        //$customer->city          = $request->city;
        //$customer->postal_code   = $request->postal_code;
        $customer->tax_code = $request->tax_code;

        $customer->save();

        $data = Invoice::find($id);

        $orderId = json_decode($data->order_id);
        if (is_array($orderId)) {
            $orderId = implode(', ', $orderId);
            DB::select("UPDATE orders SET status='unpaid' WHERE id IN($orderId)");
        }

        $data->updated = date('Y-m-d');

        $data->order_id = json_encode($request->order_id);

        if (!empty($request->order_id)) {
            if (is_array($request->order_id)) {
                $orderId = implode(', ', $request->order_id);
                DB::select("UPDATE orders SET status='pending', updated=CURDATE() WHERE id IN ($orderId)");
            }
        }

        $data->customer_id = $request->customer_id;

        if (!empty($request->email)) {
            $data->email = $request->email;
        }

        if (!empty($request->description)) {
            $data->description = $request->description;
        }

        if (!empty($request->subtotal)) {
            $data->subtotal = $request->subtotal;
        }

        if (!empty($request->discount)) {
            $data->discount = $request->discount;
        }

        if (!empty($request->grand_total)) {
            $data->grand_total = $request->grand_total;
        }

        if (!empty($request->method_id)) {
            $data->method_id = $request->method_id;
        }

        if (!empty($request->send_mail)) {
            $data->is_send = 1;
        }

        $data->save();

        flash()->addSuccess('Invoice Update Successful.');

        return redirect()->route('admin.invoice');
    }

    public function restore(string $id)
    {
        $data = Invoice::find($id);

        if (!empty($data->order_id)) {
            $orderList = Order::whereIn('id', json_decode($data->order_id))->get();
            if (!empty($orderList)) {
                foreach ($orderList as $row) {
                    $order = Order::find($row->id);

                    $order->updated = date('Y-m-d');
                    $order->status  = 'pending';

                    $order->save();
                }
            }
        }
        $data->status = 'unpaid';

        $data->save();

        flash()->addSuccess('Order status update successful.', 'success');

        return redirect()->route('admin.invoice');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $invoice = Invoice::find($id);
        if (!empty($invoice->order_id)) {
            $orderIds = json_decode($invoice->order_id, true);
            if (!empty($orderIds) && is_array($orderIds)) {
                Order::whereIn('id', $orderIds)
                    ->update([
                        'updated' => date('Y-m-d'),
                        'status'  => 'unpaid',
                    ]);
            }
        }

        $invoice->status = 'delete';
        $invoice->save();


        flash()->addSuccess('Invoice delete successful.', 'Delete');

        return redirect()->route('admin.invoice');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $invoice = Invoice::find($id);

        if (!empty($invoice->order_id)) {
            $orderIds = json_decode($invoice->order_id, true);
            if (!empty($orderIds) && is_array($orderIds)) {
                Order::whereIn('id', $orderIds)
                    ->update([
                        'updated' => date('Y-m-d'),
                        'status'  => 'unpaid',
                    ]);
            }
        }

        $invoice->delete();

        flash()->addSuccess('Invoice delete successful.', 'Delete');

        return redirect()->back();
    }

    public function sendMail($id)
    {
        $invoiceInfo = Invoice::with('customer')->find($id);
        if (!empty($invoiceInfo)) {

            $orderInfo = Order::with('emailFrom')->whereIn('id', json_decode($invoiceInfo->order_id))->get();

            if (!empty($orderInfo)) {
                try {

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
                    //Mail::to($orderInfo[0]->email)->send(new OrderInvocie($invoiceInfo, $orderInfo, 'support@linksposting.com'));

                    flash()->addSuccess('Email send Successful.');

                    Invoice::find($id)->increment('is_send');
                } catch (\Exception $e) {
                    flash()->addError($e->getMessage());
                }
            } else {
                flash()->addError('Order info not found!');
            }
        } else {
            flash()->addError('Invoice not found!');
        }
        return redirect()->back();
    }

    public function warningMail($id)
    {
        $invoiceInfo = Invoice::with('customer')->find($id);
        if (!empty($invoiceInfo)) {

            $orderInfo = Order::with('emailFrom')->whereIn('id', json_decode($invoiceInfo->order_id))->get();

            if (!empty($orderInfo)) {
                try {

                    $emailFrom = $orderInfo[0]->emailFrom->email;
                    $emailTo   = $invoiceInfo->email;
                    $subject   = 'Order Confirmation for Your Invoice (' . $invoiceInfo->invoice_no . ')';
                    $mailData  = [
                        'invoiceInfo' => $invoiceInfo,
                        'orderInfo'   => $orderInfo,
                    ];
                    //sendMail()->send($emailFrom, $emailTo, $subject, $mailData, 'mail.warning-invoice');
                    CustomJobs::create([
                        'from'     => $emailFrom,
                        'to'       => $emailTo,
                        'subject'  => $subject,
                        'details'  => json_encode($mailData),
                        'template' => 'mail.warning-invoice',
                    ]);

                    //Mail::to($orderInfo[0]->email)->send(new OrderWarningMail($invoiceInfo, $orderInfo, 'support@linksposting.com'));
                    flash()->addSuccess('Email send Successful.');

                    Invoice::find($id)->increment('is_warning');
                } catch (\Exception $e) {
                    flash()->addError('Invalid email address.');
                }
            } else {
                flash()->addError('Order info not found!');
            }
        } else {
            flash()->addError('Invoice not found!');
        }
        return redirect()->back();
    }

    public function removeMail($id)
    {
        $invoiceInfo = Invoice::with('customer')->find($id);
        if (!empty($invoiceInfo)) {

            $orderInfo = Order::with('emailFrom')->whereIn('id', json_decode($invoiceInfo->order_id))->get();

            if (!empty($orderInfo)) {
                try {

                    $emailFrom = $orderInfo[0]->emailFrom->email;
                    $emailTo   = $invoiceInfo->email;
                    $subject   = 'Order Confirmation for Your Invoice (' . $invoiceInfo->invoice_no . ')';
                    $mailData  = [
                        'invoiceInfo' => $invoiceInfo,
                        'orderInfo'   => $orderInfo,
                    ];
                    //sendMail()->send($emailFrom, $emailTo, $subject, $mailData, 'mail.remove-invoice');
                    CustomJobs::create([
                        'from'     => $emailFrom,
                        'to'       => $emailTo,
                        'subject'  => $subject,
                        'details'  => json_encode($mailData),
                        'template' => 'mail.remove-invoice',
                    ]);

                    //Mail::to($orderInfo[0]->email)->send(new OrderRemoveMail($invoiceInfo, $orderInfo, 'support@linksposting.com'));
                    flash()->addSuccess('Email send Successful.');

                    Invoice::find($id)->increment('is_remove');
                } catch (\Exception $e) {
                    flash()->addError('Invalid email address.');
                }
            } else {
                flash()->addError('Order info not found!');
            }
        } else {
            flash()->addError('Invoice not found!');
        }
        return redirect()->back();
    }

    public function orderInfo(Request $request)
    {
        if (!empty($request->email)) {

            $data    = [];
            $results = Order::with('orderItem', 'billType')->where('email', 'like', "%{$request->email}%")->where('status', 'unpaid')->get();

            if (!empty($results)) {
                foreach ($results as $row) {

                    $publishPrice = 0;
                    $liveLinks    = '';
                    if (!empty($row->orderItem)) {
                        $countItem = count($row->orderItem) - 1;
                        foreach ($row->orderItem as $itemKey => $itemRow) {
                            $liveLinks    .= $itemRow->live_url . ($itemKey < $countItem ? ' || ' : '');
                            $publishPrice += $itemRow->url_price;
                        }
                    }
                    $item = [
                        'id'             => $row->id,
                        'created'        => $row->created,
                        'order_no'       => $row->order_no,
                        'billing_type'   => (!empty($row->billType) ? $row->billType->name : ''),
                        'name'           => (!empty($row->name) ? $row->name : ''),
                        'email'          => $row->email,
                        'live_links'     => $liveLinks,
                        'prepaid_status' => (!empty($row->prepaid_status) ? strFilter($row->prepaid_status) : ''),
                        'subtotal'       => $row->subtotal,
                        'publish_price'  => (!empty($publishPrice) ? round($publishPrice, 2) : 0),
                        'discount'       => $row->discount,
                        'grand_total'    => $row->grand_total,
                    ];
                    array_push($data, (object)$item);
                }
            }
            return $data;
        }
    }

    public function customerInfo(Request $request)
    {
        if (!empty($request->email)) {
            return Customer::with('country')->where('email', trim($request->email))->first();
        }
    }

    public function invoiceInfo(Request $request)
    {
        if (!empty($request->id)) {
            $data        = [];
            $invoiceInfo = Invoice::find($request->id);

            $newResults = Order::with('orderItem', 'billType')->where('email', 'like', "%{$invoiceInfo->email}%")->where('status', 'unpaid')->whereNotIn('id', json_decode($invoiceInfo->order_id))->get();

            $currentResults = Order::with('orderItem', 'billType')->whereIn('id', json_decode($invoiceInfo->order_id))->get();

            if (!empty($newResults)) {
                foreach ($newResults as $row) {
                    $publishPrice = 0;
                    $liveLinks    = '';
                    if (!empty($row->orderItem)) {
                        $countItem = count($row->orderItem) - 1;
                        foreach ($row->orderItem as $itemKey => $itemRow) {
                            $liveLinks    .= $itemRow->live_url . ($itemKey < $countItem ? ' || ' : '');
                            $publishPrice += $itemRow->url_price;
                        }
                    }
                    $item = [
                        'id'             => $row->id,
                        'created'        => $row->created,
                        'order_no'       => $row->order_no,
                        'billing_type'   => (!empty($row->billType) ? $row->billType->name : ''),
                        'name'           => (!empty($row->name) ? $row->name : ''),
                        'email'          => $row->email,
                        'live_links'     => $liveLinks,
                        'prepaid_status' => (!empty($row->prepaid_status) ? strFilter($row->prepaid_status) : ''),
                        'subtotal'       => $row->subtotal,
                        'publish_price'  => (!empty($publishPrice) ? round($publishPrice, 2) : 0),
                        'discount'       => $row->discount,
                        'grand_total'    => $row->grand_total,
                        'checked'        => false,
                    ];
                    array_push($data, (object)$item);
                }
            }
            if (!empty($currentResults)) {
                foreach ($currentResults as $row) {
                    $publishPrice = 0;
                    $liveLinks    = '';
                    if (!empty($row->orderItem)) {
                        $countItem = count($row->orderItem) - 1;
                        foreach ($row->orderItem as $itemKey => $itemRow) {
                            $liveLinks    .= $itemRow->live_url . ($itemKey < $countItem ? ' || ' : '');
                            $publishPrice += $itemRow->url_price;
                        }
                    }
                    $item = [
                        'id'             => $row->id,
                        'created'        => $row->created,
                        'order_no'       => $row->order_no,
                        'billing_type'   => (!empty($row->billType) ? $row->billType->name : ''),
                        'name'           => (!empty($row->name) ? $row->name : ''),
                        'email'          => $row->email,
                        'live_links'     => $liveLinks,
                        'prepaid_status' => (!empty($row->prepaid_status) ? strFilter($row->prepaid_status) : ''),
                        'subtotal'       => $row->subtotal,
                        'publish_price'  => (!empty($publishPrice) ? round($publishPrice, 2) : 0),
                        'discount'       => $row->discount,
                        'grand_total'    => $row->grand_total,
                        'checked'        => true,
                    ];
                    array_push($data, (object)$item);
                }
            }
            return $data;
        }
    }

    public function allPendingOrder()
    {
        return Order::where('status', 'pending')->get();
    }
}
