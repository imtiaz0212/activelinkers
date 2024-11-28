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

use App\Models\SitesSummaryReports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Mail\OrderInvocie;
use App\Models\Reports;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use function Spatie\Ignition\Solutions\OpenAi\deleteMultiple;


class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->middleware(['permission:reports order report,admin'])->only('index');
        $this->middleware(['permission:reports invoice report,admin'])->only('invoices');
        $this->middleware(['permission:reports sites report,admin'])->only('sites');
        $this->middleware(['permission:reports sites summary report,admin'])->only('sites_summary');
        $this->middleware(['permission:reports sites selling report,admin'])->only('sites_selling');
        $this->middleware(['permission:reports client summary report,admin'])->only('client_summary');

        $this->data['activeMenu'] = 'reports';
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->data['activeSubMenu'] = 'counters';

        $this->data['orderInfo']   = Order::emailList();
        $this->data['admin']       = Admin::get();
        $this->data['invoiceInfo'] = Invoice::emailList();
        $this->data['billingType'] = BillingType::get();

        // $this->data['info'] = Order::realtimeSearch($request);

        $this->data['info'] = Reports::allOrderReports($request);

        return view('reports.counter', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function invoices(Request $request)
    {
        $this->data['activeSubMenu'] = 'invoices';

        $this->data['orderInfo']   = Order::emailList();
        $this->data['admin']       = Admin::get();
        $this->data['invoiceInfo'] = Invoice::emailList();
        $this->data['billingType'] = BillingType::get();

        // $this->data['info'] = Invoice::realtimeSearch($request);

        $this->data['info'] = Reports::allInvoiceReports($request);

        return view('reports.invoices', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function sites(Request $request)
    {
        $this->data['activeSubMenu'] = 'sites';

        $this->data['orderInfo']   = Order::emailList();
        $this->data['admin']       = Admin::get();
        $this->data['invoiceInfo'] = Invoice::emailList();
        $this->data['billingType'] = BillingType::get();
        $this->data['siteList']    = SiteList::siteList();

        $this->data['info'] = Reports::allSitesReports($request);

        return view('reports.sites', $this->data);
    }

    /**
     * Display the specified resource.
     */
    public function sites_summary(Request $request)
    {
        $this->data['activeSubMenu'] = 'sites_summary';

        $this->data['orderInfo']   = Order::emailList();
        $this->data['admin']       = Admin::get();
        $this->data['invoiceInfo'] = Invoice::emailList();
        $this->data['billingType'] = BillingType::get();
        $this->data['siteList']    = SiteList::siteList();

        $this->data['info'] = SitesSummaryReports::allSitesReports($request);

        return view('reports.sites_summary', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function sites_selling(Request $request)
    {
        $this->data['activeSubMenu'] = 'sites_selling';

        $this->data['orderInfo']   = Order::emailList();
        $this->data['admin']       = Admin::get();
        $this->data['invoiceInfo'] = Invoice::emailList();
        $this->data['billingType'] = BillingType::get();
        $this->data['siteList']    = SiteList::siteList();

        $this->data['info'] = SiteList::realtimeSearch($request);

        return view('reports.sites_selling', $this->data);
    }
}
