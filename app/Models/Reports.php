<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Reports extends Model
{
    use HasFactory;

    static function allOrderReports($request)
    {
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);

        $data = [];

        // today Date
        $today = Carbon::now()->format('Y-m-d');

        // Yesterday Date
        $yesterday = Carbon::yesterday()->format('Y-m-d');

        // This Week Date Range
        $first_this_week = Carbon::now()->startOfWeek()->format('Y-m-d');
        $last_this_week  = Carbon::now()->endOfWeek()->format('Y-m-d');

        // Last Week Date Range
        $first_last_week = Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d');
        $last_last_week  = Carbon::now()->subWeek()->endOfWeek()->format('Y-m-d');

        // Last 7 Days Date Range
        $first_last_7_days = Carbon::now()->subDays(8)->format('Y-m-d');
        $last_last_7_days  = Carbon::yesterday()->format('Y-m-d');

        // This month Date
        $first_this_month = Carbon::now()->startOfMonth()->format('Y-m-d');

        // Last month Date Range
        $first_last_month = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
        $last_last_month  = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');

        // Last 3 month Date Range
        $first_last_3_month = Carbon::now()->subMonth(3)->startOfMonth()->format('Y-m-d');
        $last_last_3_month  = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');

        // This 3 Month Date
        $first_this_3_month = Carbon::now()->subMonth(2)->startOfMonth()->format('Y-m-d');

        // This Year Date
        $first_this_year = Carbon::now()->startOfYear()->format('Y-m-d');

        // Last Year Date Range
        $first_last_year = Carbon::now()->subYear()->startOfYear()->format('Y-m-d');
        $last_last_year  = Carbon::now()->subYear()->endOfYear()->format('Y-m-d');

        $where = [];
        if (!empty($request->filter)) {
            // today Date
            if ($request->filter == "today") {
                $where[] = ['created', $today];
            }

            // Yesterday Date
            if ($request->filter == "yesterday") {
                $where[] = ['created', $yesterday];
            }

            // This Week Date Range
            if ($request->filter == "this_week") {
                $where[] = ['created', '>=', $first_this_week];
                $where[] = ['created', '<=', $last_this_week];
            }

            // Last Week Date Range
            if ($request->filter == "last_week") {
                $where[] = ['created', '>=', $first_last_week];
                $where[] = ['created', '<=', $last_last_week];
            }

            // Last 7 Days Date Range
            if ($request->filter == "last_7_days") {
                $where[] = ['created', '>=', $first_last_7_days];
                $where[] = ['created', '<=', $last_last_7_days];
            }

            // This month Date Range
            if ($request->filter == "this_month") {
                $where[] = ['created', '>=', $first_this_month];
                $where[] = ['created', '<=', $today];
            }

            // Last month Date Range
            if ($request->filter == "last_month") {
                $where[] = ['created', '>=', $first_last_month];
                $where[] = ['created', '<=', $last_last_month];
            }

            // Last 3 month Date Range
            if ($request->filter == "last_3_month") {
                $where[] = ['created', '>=', $first_last_3_month];
                $where[] = ['created', '<=', $last_last_3_month];
            }

            // This 3 Month Date Range
            if ($request->filter == "this_3_month") {
                $where[] = ['created', '>=', $first_this_3_month];
                $where[] = ['created', '<=', $today];
            }

            // This Year Date Range
            if ($request->filter == "this_year") {
                $where[] = ['created', '>=', $first_this_year];
                $where[] = ['created', '<=', $today];
            }

            // Last Year Date Range
            if ($request->filter == "last_year") {
                $where[] = ['created', '>=', $first_last_year];
                $where[] = ['created', '<=', $last_last_year];
            }
        }

        // Custom Date Range
        if (!empty($request->date_range)) {
            $dateRange = explode('to', $request->date_range);

            $where[] = ['created', '>=', $dateRange[0]];
            if (!empty($dateRange[1])) {
                $where[] = ['created', '<=', $dateRange[1]];
            }
        }

        // Custom Month
        if (!empty($request->month_name)) {
            $month = getMonthnumber($request->month_name);

            $last_day_of_month = date('Y-m-t', strtotime('2024-' . $month));

            $where[] = ['created', '>=', '2024-' . $month . '-01'];
            $where[] = ['created', '<=', $last_day_of_month];
        }

        // Email
        if (!empty($request->email)) {
            $where[] = ['email', $request->email];
        }

        // Billing Type
        if (!empty($request->billing_type)) {
            $where[] = ['billing_type', $request->billing_type];
        }

        // Admin User ID
        if (!empty($request->user_id)) {
            $where[] = ['user_id', $request->user_id];
        }

        // Status
        if (!empty($request->status)) {
            $where[] = ['status', $request->status];
        }

        // Email From ID
        if (!empty($request->email_from_id)) {
            $where[] = ['email_from_id', $request->email_from_id];
        }

        // Get All Data
        $results = Order::with('admin', 'orderItem', 'emailFrom')->orderBy('created', 'desc')->where($where)->paginate(10)->withQueryString();

        // All Query String Data Send To View Page
        $data['orderEmail']  = $request->email;
        $data['billingType'] = $request->billing_type;
        $data['userId']      = $request->user_id;
        $data['status']      = $request->status;
        $data['emailFromId'] = $request->email_from_id;
        $data['filter']      = $request->filter;
        $data['date_range']  = $request->date_range;
        $data['month_name']  = $request->month_name;
        $data['results']     = $results;

        // return All Data
        return (object)$data;
    }

    static function allInvoiceReports($request)
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

        $results = Invoice::with('admin')->orderBy('created', 'desc')->where($where)->paginate(10)->withQueryString();

        $data['orderEmail'] = $request->email;
        $data['userId']     = $request->user_id;
        $data['status']     = $request->status;
        $data['filter']     = $request->filter;
        $data['date_range'] = $request->date_range;
        $data['month_name'] = $request->month_name;
        $data['results']    = $results;

        return (object)$data;
    }

    static function allSitesReports($request)
    {
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);

        $data = [];

        // today Date
        $today = Carbon::now()->format('Y-m-d');

        // Yesterday Date
        $yesterday = Carbon::yesterday()->format('Y-m-d');

        // This Week Date Range
        $first_this_week = Carbon::now()->startOfWeek()->format('Y-m-d');
        $last_this_week  = Carbon::now()->endOfWeek()->format('Y-m-d');

        // Last Week Date Range
        $first_last_week = Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d');
        $last_last_week  = Carbon::now()->subWeek()->endOfWeek()->format('Y-m-d');

        // Last 7 Days Date Range
        $first_last_7_days = Carbon::now()->subDays(8)->format('Y-m-d');
        $last_last_7_days  = Carbon::yesterday()->format('Y-m-d');

        // This month Date
        $first_this_month = Carbon::now()->startOfMonth()->format('Y-m-d');

        // Last month Date Range
        $first_last_month = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
        $last_last_month  = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');

        // Last 3 month Date Range
        $first_last_3_month = Carbon::now()->subMonth(3)->startOfMonth()->format('Y-m-d');
        $last_last_3_month  = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');

        // This 3 Month Date
        $first_this_3_month = Carbon::now()->subMonth(2)->startOfMonth()->format('Y-m-d');

        // This Year Date
        $first_this_year = Carbon::now()->startOfYear()->format('Y-m-d');

        // Last Year Date Range
        $first_last_year = Carbon::now()->subYear()->startOfYear()->format('Y-m-d');
        $last_last_year  = Carbon::now()->subYear()->endOfYear()->format('Y-m-d');

        $where = [];
        if (!empty($request->filter)) {
            // today Date
            if ($request->filter == "today") {
                $where[] = ['orders.created', $today];
            }

            // Yesterday Date
            if ($request->filter == "yesterday") {
                $where[] = ['orders.created', $yesterday];
            }

            // This Week Date Range
            if ($request->filter == "this_week") {
                $where[] = ['orders.created', '>=', $first_this_week];
                $where[] = ['orders.created', '<=', $last_this_week];
            }

            // Last Week Date Range
            if ($request->filter == "last_week") {
                $where[] = ['orders.created', '>=', $first_last_week];
                $where[] = ['orders.created', '<=', $last_last_week];
            }

            // Last 7 Days Date Range
            if ($request->filter == "last_7_days") {
                $where[] = ['orders.created', '>=', $first_last_7_days];
                $where[] = ['orders.created', '<=', $last_last_7_days];
            }

            // This month Date Range
            if ($request->filter == "this_month") {
                $where[] = ['orders.created', '>=', $first_this_month];
                $where[] = ['orders.created', '<=', $today];
            }

            // Last month Date Range
            if ($request->filter == "last_month") {
                $where[] = ['orders.created', '>=', $first_last_month];
                $where[] = ['orders.created', '<=', $last_last_month];
            }

            // Last 3 month Date Range
            if ($request->filter == "last_3_month") {
                $where[] = ['orders.created', '>=', $first_last_3_month];
                $where[] = ['orders.created', '<=', $last_last_3_month];
            }

            // This 3 Month Date Range
            if ($request->filter == "this_3_month") {
                $where[] = ['orders.created', '>=', $first_this_3_month];
                $where[] = ['orders.created', '<=', $today];
            }

            // This Year Date Range
            if ($request->filter == "this_year") {
                $where[] = ['orders.created', '>=', $first_this_year];
                $where[] = ['orders.created', '<=', $today];
            }

            // Last Year Date Range
            if ($request->filter == "last_year") {
                $where[] = ['orders.created', '>=', $first_last_year];
                $where[] = ['orders.created', '<=', $last_last_year];
            }
        }

        // Custom Date Range
        if (!empty($request->date_range)) {
            $dateRange = explode('to', $request->date_range);

            $where[] = ['orders.created', '>=', $dateRange[0]];
            if (!empty($dateRange[1])) {
                $where[] = ['orders.created', '<=', $dateRange[1]];
            }
        }

        // Custom Month
        if (!empty($request->month_name)) {
            $month = getMonthnumber($request->month_name);

            $last_day_of_month = date('Y-m-t', strtotime('2024-' . $month));

            $where[] = ['orders.created', '>=', '2024-' . $month . '-01'];
            $where[] = ['orders.created', '<=', $last_day_of_month];
        }

        // Check URL From Website
        if (!empty($request->check_url)) {
            $where[] = ['order_items.url', $request->check_url];
        }

        // Admin User ID
        if (!empty($request->user_id)) {
            $where[] = ['orders.user_id', $request->user_id];
        }

        // Status
        if (!empty($request->status)) {
            $where[] = ['orders.status', $request->status];
        }

        // Get All Data
        // $results = Order::with('admin', 'orderItem', 'emailFrom')->orderBy('created', 'desc')->where($where)->paginate(8)->withQueryString();
        $results =  DB::table('orders')->leftJoin('order_items', 'order_items.order_id', '=', 'orders.id')->leftJoin('admins', 'admins.id', '=', 'orders.user_id')
            ->select(
                'orders.*',
                'order_items.url',
                'order_items.entity_name',
                'order_items.live_url',
                'order_items.url_price',
                'order_items.artical',
                'order_items.anchor',
                'order_items.is_other_price',
                'order_items.link_insert',
                'order_items.other_price',
                'order_items.total',
                'admins.name as admin_name',
                'admins.email as admin_email'
            )->where($where)->whereNull('orders.deleted_at')->paginate(10)->withQueryString();

        // All Query String Data Send To View Page
        $data['check_url']   = $request->check_url;
        $data['userId']      = $request->user_id;
        $data['status']      = $request->status;
        $data['filter']      = $request->filter;
        $data['date_range']  = $request->date_range;
        $data['month_name']  = $request->month_name;
        $data['results']     = $results;

        // return All Data
        return (object)$data;
    }
}
