<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class SiteList extends Model
{
    use HasFactory, SoftDeletes;

    public function country()
    {
        return $this->belongsTo(Country::class)->select('id', 'name', 'code');
    }

    public function orderItem()
    {
        return $this->hasMany(orderItem::class, 'url', 'url');
    }

    static function siteList()
    {
        return DB::select("SELECT `check_url`, `url` FROM `site_lists` WHERE deleted_at IS NULL GROUP BY check_url ORDER BY check_url ASC");
    }

    static function realtimeSearch($request)
    {
        $where = [];

        if (!empty($request->email)) {
            $where[] = ['orders.email', $request->email];
        }

        if (!empty($request->check_url)) {
            $where[] = ['site_lists.url', $request->check_url];
        }

        if (!empty($request->date_from)) {
            $where[] = ['site_lists.created', '>=', $request->date_from];
        }

        if (!empty($request->date_to)) {
            $where[] = ['site_lists.created', '<=', $request->date_to];
        }

        // Custom Date Range
        if (!empty($request->date_range)) {
            $dateRange = explode('to', $request->date_range);

            $where[] = ['orders.created', '>=', $dateRange[0]];
            if (!empty($dateRange[1])) {
                $where[] = ['orders.created', '<=', $dateRange[1]];
            }
        }

        if (!empty($request->user_id)) {
            $where[] = ['orders.user_id', $request->user_id];
        }

        if (!empty($request->status)) {
            $where[] = ['orders.status', $request->status];
        }

        $results = DB::table('site_lists')
            ->join('order_items', 'order_items.url', '=', 'site_lists.url')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where($where)
            ->select(
                'site_lists.id',
                "site_lists.created",
                "site_lists.url",
                "site_lists.check_url",
                "order_items.order_id",
                "order_items.is_other_price",
                "order_items.link_insert",
                "order_items.artical",
                "orders.updated",
                "orders.user_id",
                "orders.billing_type",
                "orders.email",
                "orders.subtotal",
                "orders.service_charge",
                "orders.tax",
                "orders.discount",
                "orders.grand_total",
                "orders.status",
                DB::raw("SUM(site_lists.general_price) as general_price"),
                DB::raw("SUM(site_lists.other_price) as other_price")
            )
            ->whereNull('orders.deleted_at')->groupBy('site_lists.url')->orderBy('site_lists.id', 'desc')->paginate(10)->withQueryString();

        $data['email']      = $request->email;
        $data['check_url']  = $request->check_url;
        $data['dateFrom']   = $request->date_from;
        $data['dateTo']     = $request->date_to;
        $data['date_range'] = $request->date_range;
        $data['userId']     = $request->user_id;
        $data['status']     = $request->status;

        $data['results'] = $results;

        return (object)$data;
    }
}
