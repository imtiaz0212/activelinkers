<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use App\Models\SiteList;
use App\Models\EmailFrom;
use App\Models\Admin;
use App\Models\Order;
use App\Models\orderItem;
use App\Models\Niche;
use App\Models\Invoice;
use App\Models\BillingType;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        $this->data['activeMenu'] = 'order';
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->data['orderInfo']   = Order::all();
        $this->data['admin']       = Admin::all();
        $this->data['emailList']   = EmailFrom::all();
        $this->data['billingType'] = BillingType::all();

        $where = ['user_id' => Auth::user()->id];
        if (!empty($request->_token)) {
            if (!empty($request->date_from)) {
                $where[] = ['created', '>=', $request->date_from];
            }

            if (!empty($request->date_to)) {
                $where[] = ['created', '<=', $request->date_to];
            }

            if (!empty($request->search)) {
                foreach ($request->search as $key => $value) {
                    if (!empty($value)) {
                        $where[] = [$key, $value];
                    }
                }
            }
        } else {
            $where[] = ['created', date('Y-m-d')];
        }

        $this->data['results'] = Order::with('admin', 'orderItem', 'emailFrom')->where($where)->get();

        return view('userpanel.order', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function checkout($pid)
    {
        $this->data['menu']       = 'service';
        $this->data['siteTitle']  = 'Service Checkout';
        $this->data['breadcrumb'] = ['checkout' => 'Service Checkout'];

        return view('userpanel.checkout', $this->data);
    }
    /**
    * Show the form for creating a new resource.
    */
    public function invoice(string $id)
    {
        $this->data['menu']       = 'invoice';
        $this->data['siteTitle']  = 'Order Invoice';

        $this->data['orderInfo'] = Order::with('admin', 'orderItem')->where('id', $id)->first();

        return view('userpanel.invoice', $this->data);
    }
}
