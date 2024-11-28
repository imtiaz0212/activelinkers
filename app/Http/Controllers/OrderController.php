<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use App\Models\SiteList;
use App\Models\EmailFrom;
use App\Models\Admin;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Niche;
use App\Models\Invoice;
use App\Models\BillingType;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->middleware(['permission:order,admin'])->only('index');
        $this->middleware(['permission:order create,admin'])->only(['create', 'store']);
        $this->middleware(['permission:order show,admin'])->only('invoice');
        $this->middleware(['permission:order edit,admin'])->only(['edit', 'update']);
        $this->middleware(['permission:order delete,admin'])->only(['delete']);
        $this->middleware(['permission:order destroy,admin'])->only('destroy');
        $this->middleware(['permission:order change payment status,admin'])->only(['changePrepaid']);
        $this->middleware(['permission:order restore,admin'])->only(['restore']);
        $this->middleware(['permission:order republished,admin'])->only(['published']);

        $this->data['billingType'] = BillingType::where('status', 1)->get();

        $this->data['activeMenu'] = 'order';
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->data['orderInfo'] = Order::emailList();
        $this->data['admin']     = Admin::all();
        $this->data['emailList'] = EmailFrom::all();

        $this->data['info'] = Order::realtimeSearch($request);

        $this->data['allOrder'] = Order::all();

        return view('order.index', $this->data);
    }

    /**
     * Display a listing of the resource.
     */
    public function create()
    {
        $this->data['siteList'] = SiteList::orderBy('created_at', 'desc')->get();

        $this->data['emailList'] = EmailFrom::all();
        $this->data['niche']     = Niche::all();

        return view('order.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id   = Auth::user()->id;
        $privilege = Auth::user()->privilege;

        $customer            = Customer::firstOrNew(['email' => $request->email]);
        $customer->full_name = $request->full_name;
        $customer->email     = $request->email;
        $customer->save();

        $orderMaxId  = DB::table('orders')->max('id');
        $orderSerial = (!empty($orderMaxId) ? $orderMaxId : 0) + 1;
        $orderNo     = str_pad($orderSerial, 6, '0', STR_PAD_LEFT);

        $data = new Order;
        if (Order::where('order_no', $orderNo)->count() < 1) {

            $data->created   = date('Y-m-d');
            $data->order_no  = $orderNo;
            $data->privilege = $privilege;
            $data->user_id   = $user_id;

            $data->email         = $request->email;
            $data->delivery_date = $request->delivery_date;
            $data->billing_type  = $request->billing_type;


            if (!empty($request->description)) {
                $data->description = $request->description;
            }

            if (!empty($request->subtotal)) {
                $data->subtotal = $request->subtotal;
            }

            if (!empty($request->service_charge)) {
                $data->service_charge = $request->service_charge;
            }

            if (!empty($request->tax)) {
                $data->tax = $request->tax;
            }

            if (!empty($request->discount)) {
                $data->discount = $request->discount;
            }

            if (!empty($request->grand_total)) {
                $data->grand_total = $request->grand_total;
            }

            if (!empty($request->email_from_id)) {
                $data->email_from_id = $request->email_from_id;
            }

            if (!empty($request->prepayment)) {
                $data->prepaid_status = 'prepaid';
            }

            $data->save();
            // Save All Order Data Here

            // order Add Item wise Here
            $order_id = $data->id;
            foreach ($request->url as $key => $url) {
                $item = new OrderItem;

                $item->created        = date('Y-m-d');
                $item->order_id       = $order_id;
                $item->url            = $url;
                $item->entity_name    = $request->entity_name[$key];
                $item->live_url       = $request->live_link[$key];
                $item->url_price      = $request->url_price[$key];
                $item->anchor         = $request->anchor[$key];
                $item->is_other_price = $request->other_link_price[$key];
                $item->link_insert    = $request->link_insert[$key];
                $item->other_price    = $request->other_price[$key];
                $item->total          = $request->total[$key];
                $item->artical        = $request->article_amount[$key];

                $item->save();
            }
            flash()->addSuccess('Order add successful.');

            // store email
            $emailData                    = EmailList::firstOrNew(['email' => $request->email]);
            $emailData->email_category_id = 1;
            $emailData->email             = $request->email;
            $emailData->from              = 'order';
            $emailData->save();
        }

        return redirect()->route('admin.order');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function invoice($id)
    {
        $this->data['orderInfo'] = Order::with('admin', 'orderItem', 'customer')->where('id', $id)->first();

        return view('order.invoice', $this->data);
    }

    /**
     * Edit Order Page.
     */
    public function edit($id)
    {
        $this->data['emailList'] = EmailFrom::all();

        $this->data['orderInfo'] = Order::with('admin', 'orderItem', 'customer')->where('id', $id)->first();

        return view('order.edit', $this->data);
    }

    public function update(Request $request)
    {
        $data = Order::find($request->id);

        $data->updated = date('Y-m-d');

        if (!empty($request->name)) {
            $data->name = $request->name;
        }

        if (!empty($request->company)) {
            $data->company = $request->company;
        }

        if (!empty($request->mobile)) {
            $data->mobile = $request->mobile;
        }

        if (!empty($request->email)) {
            $data->email = $request->email;
        }

        if (!empty($request->address)) {
            $data->address = $request->address;
        }

        if (!empty($request->delivery_date)) {
            $data->delivery_date = $request->delivery_date;
        }

        if (!empty($request->description)) {
            $data->description = $request->description;
        }

        if (!empty($request->subtotal)) {
            $data->subtotal = $request->subtotal;
        }

        if (!empty($request->service_charge)) {
            $data->service_charge = $request->service_charge;
        }

        if (!empty($request->tax)) {
            $data->tax = $request->tax;
        }

        if (!empty($request->discount)) {
            $data->discount = $request->discount;
        }

        if (!empty($request->grand_total)) {
            $data->grand_total = $request->grand_total;
        }

        if (!empty($request->billing_type)) {
            $data->billing_type = $request->billing_type;
        }

        if (!empty($request->status)) {
            $data->status = $request->status;
        }

        if (!empty($request->email_from_id)) {
            $data->email_from_id = $request->email_from_id;
        }

        if (!empty($request->prepayment)) {
            $data->prepaid_status = 'prepaid';
        }

        $data->save();
        // Save All Order Data Here

        // order Add Item wise Here
        $order_id = $data->id;
        if (!empty($request->item_id)) {
            $itemArray = array_filter($request->item_id, 'strlen');
            OrderItem::where('order_id', $order_id)->whereNotIn('id', $itemArray)->delete();
        }
        foreach ($request->url as $key => $url) {

            $item = OrderItem::firstOrNew(['id' => $request->item_id[$key]]);
            if (empty($item->created)) {
                $item->created = date('Y-m-d');
            }

            $item->order_id       = $order_id;
            $item->url            = $url;
            $item->entity_name    = $request->entity_name[$key];
            $item->live_url       = $request->live_link[$key];
            $item->url_price      = $request->url_price[$key];
            $item->anchor         = $request->anchor[$key];
            $item->is_other_price = $request->other_link_price[$key];
            $item->link_insert    = $request->link_insert[$key];
            $item->other_price    = $request->other_price[$key];
            $item->total          = $request->total[$key];
            $item->artical        = $request->article_amount[$key];

            $item->save();
        }

        flash()->addSuccess('Order Update successful.');
        return redirect()->route('admin.order');
    }

    public function changeLiveLink(Request $request)
    {
        dd($request->all());

        $data = Order::find($request->id);

        $data->live_link = $request->live_link;

        $data->save();

        flash()->addSuccess('Live Link Update successful.', 'success');

        return redirect()->route('admin.order');
    }

    public function changeAnchor(Request $request)
    {
        dd($request->all());

        $data = Order::find($request->id);

        $data->anchor = $request->anchor;

        $data->save();

        flash()->addSuccess('Anchor Data Update successful.', 'success');

        return redirect()->route('admin.order');
    }

    public function restore(string $id)
    {
        $data = Order::find($id);

        $data->status = 'unpaid';

        $data->save();

        flash()->addSuccess('Order status update successful.', 'success');

        return redirect()->route('admin.order');
    }

    public function published(string $id)
    {
        $data = Order::find($id);

        $data->status = 'paid';

        $data->save();

        flash()->addSuccess('Order status update successful.', 'success');

        return redirect()->route('admin.order');
    }

    public function changePrepaid(string $id)
    {
        $data = Order::find($id);

        $data->prepaid_status = 'completed';

        $data->save();

        flash()->addSuccess('Prepaid status update successful.', 'success');

        return redirect()->route('admin.order');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $data = Order::find($id);

        $data->status = 'delete';

        $data->save();

        flash()->addSuccess('Order delete successful.', 'Delete');

        return redirect()->route('admin.order');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Order::find($id)->delete();
        OrderItem::where('order_id', $id)->delete();
        Invoice::where('order_id', $id)->delete();

        flash()->addSuccess('Order Permanently delete successful. (Order, Order Items, Invoice)', 'Delete');

        return redirect()->route('admin.order');
    }


    //Get Site Info
    public function liveLink(Request $request)
    {
        if (!empty($request->check_url)) {
            $checkUrl = removeHttp($request->check_url);
            return SiteList::where('check_url', $checkUrl)->first();
        }
    }

    //Get Edit Order Info
    public function itemInfo(Request $request)
    {
        if (!empty($request->order_id)) {
            return OrderItem::where('order_id', $request->order_id)->get();
        }
    }
}
