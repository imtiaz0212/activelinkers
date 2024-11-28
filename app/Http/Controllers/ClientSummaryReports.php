<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\BillingType;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientSummaryReports extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->middleware(['permission:reports client summary report,admin'])->only('index');

        $this->data['activeMenu']    = 'reports';
        $this->data['activeSubMenu'] = 'client_summary';
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->data['orderInfo']   = Order::emailList();
        $this->data['admin']       = Admin::get();
        $this->data['invoiceInfo'] = Invoice::emailList();
        $this->data['billingType'] = BillingType::get();

        $this->data['info'] = $this->searchData($request);

        return view('reports.client_summary', $this->data);
    }

    public function searchData($request)
    {
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);

        $data = [];

        $today = Carbon::now()->format('Y-m-d');

        $yesterday = Carbon::yesterday()->format('Y-m-d');

        $first_this_week = Carbon::now()->startOfWeek()->format('Y-m-d');
        $last_this_week  = Carbon::now()->endOfWeek()->format('Y-m-d');

        $first_last_week = Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d');
        $last_last_week  = Carbon::now()->subWeek()->endOfWeek()->format('Y-m-d');

        $first_last_7_days = Carbon::now()->subDays(8)->format('Y-m-d');
        $last_last_7_days  = Carbon::yesterday()->format('Y-m-d');

        $first_this_month = Carbon::now()->startOfMonth()->format('Y-m-d');

        $first_last_month = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
        $last_last_month  = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');

        $first_last_3_month = Carbon::now()->subMonth(3)->startOfMonth()->format('Y-m-d');
        $last_last_3_month  = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');

        $first_this_3_month = Carbon::now()->subMonth(2)->startOfMonth()->format('Y-m-d');

        $first_this_year = Carbon::now()->startOfYear()->format('Y-m-d');

        $first_last_year = Carbon::now()->subYear()->startOfYear()->format('Y-m-d');
        $last_last_year  = Carbon::now()->subYear()->endOfYear()->format('Y-m-d');

        $where = [];

        if (!empty($request->filter)) {

            if ($request->filter == "today") {
                $where[] = ['created', $today];
            }

            if ($request->filter == "yesterday") {
                $where[] = ['created', $yesterday];
            }

            if ($request->filter == "this_week") {
                $where[] = ['created', '>=', $first_this_week];
                $where[] = ['created', '<=', $last_this_week];
            }

            if ($request->filter == "last_week") {
                $where[] = ['created', '>=', $first_last_week];
                $where[] = ['created', '<=', $last_last_week];
            }

            if ($request->filter == "last_7_days") {
                $where[] = ['created', '>=', $first_last_7_days];
                $where[] = ['created', '<=', $last_last_7_days];
            }

            if ($request->filter == "this_month") {
                $where[] = ['created', '>=', $first_this_month];
                $where[] = ['created', '<=', $today];
            }

            if ($request->filter == "last_month") {
                $where[] = ['created', '>=', $first_last_month];
                $where[] = ['created', '<=', $last_last_month];
            }

            if ($request->filter == "last_3_month") {
                $where[] = ['created', '>=', $first_last_3_month];
                $where[] = ['created', '<=', $last_last_3_month];
            }

            if ($request->filter == "this_3_month") {
                $where[] = ['created', '>=', $first_this_3_month];
                $where[] = ['created', '<=', $today];
            }

            if ($request->filter == "this_year") {
                $where[] = ['created', '>=', $first_this_year];
                $where[] = ['created', '<=', $today];
            }

            if ($request->filter == "last_year") {
                $where[] = ['created', '>=', $first_last_year];
                $where[] = ['created', '<=', $last_last_year];
            }
        }

        if (!empty($request->date_range)) {
            $dateRange = explode('to', $request->date_range);
            $where[]   = ['created', '>=', $dateRange[0]];
            if (!empty($dateRange[1])) {
                $where[] = ['created', '<=', $dateRange[1]];
            }
        }

        if (!empty($request->month_name)) {
            $month = getMonthnumber($request->month_name);

            $last_day_of_month = date('Y-m-t', strtotime('2024-' . $month));

            $where[] = ['created', '>=', '2024-' . $month . '-01'];
            $where[] = ['created', '<=', $last_day_of_month];
        }

        if (!empty($request->email)) {
            $where[] = ['email', $request->email];
        }

        if (!empty($request->user_id)) {
            $where[] = ['user_id', $request->user_id];
        }

        if (!empty($request->status)) {
            $where[] = ['status', $request->status];
        }

        /* get invoice list */
        $invoiceList = Invoice::where($where)->get();

        /* get client list */
        $clientList = DB::table('invoices')
            ->where($where)->whereNull('deleted_at')
            ->select('email')->groupBy('email')
            ->get()->toArray();

        /* custom pagination */
        $perPage      = 10;
        $currentPage  = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = array_slice($clientList, $perPage * ($currentPage - 1), $perPage);
        $paginator    = new LengthAwarePaginator($currentItems, count($clientList), $perPage, $currentPage, ['path' => $request->url()]);
        $results      = $paginator->appends(request()->query());

        /* set data */
        if (!empty($results)) {
            foreach ($results as $row) {

                $totalPaid   = $invoiceList->where('email', $row->email)->where('status', 'paid')->sum('grand_total');
                $totalUnpaid = $invoiceList->where('email', $row->email)->where('status', 'unpaid')->sum('grand_total');
                $totalDelete = $invoiceList->where('email', $row->email)->where('status', 'delete')->sum('grand_total');

                // get last order data
                $orderInfo     = Order::where('email', $row->email)->orderBy('id', 'desc')->first();
                $lastOrderDate = (!empty($orderInfo) ? Carbon::parse($orderInfo->created)->diffForhumans() : '');

                // get live links
                $totalLiveLink = 0;
                $orderIdList   = Invoice::where('email', $row->email)->where('status', 'paid')->pluck('order_id')->toArray();
                if (!empty($orderIdList)) {
                    foreach ($orderIdList as $value) {

                        $liveLink = DB::table('order_items')->join('orders', 'order_items.order_id', 'orders.id')
                            ->whereNull('order_items.deleted_at')->where('orders.status', 'paid')
                            ->whereIn('orders.id', json_decode($value))->count();

                        $totalLiveLink += $liveLink;
                    }
                }

                $row->paid            = $totalPaid;
                $row->unpaid          = $totalUnpaid;
                $row->delete          = $totalDelete;
                $row->live_links      = $totalLiveLink;
                $row->last_order_date = $lastOrderDate;
            }
        }


        $data['filter']     = $request->filter;
        $data['orderEmail'] = $request->email;
        $data['userId']     = $request->user_id;
        $data['status']     = $request->status;
        $data['filter']     = $request->filter;
        $data['date_range'] = $request->date_range;
        $data['month_name'] = $request->month_name;
        $data['results']    = $results;

        return (object)$data;
    }
}
