<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->select('id', 'name', 'email', 'mobile', 'address', 'avatar', 'privilege');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'id', 'user_id')->select('id', 'name', 'email', 'mobile', 'address', 'avatar', 'privilege');
    }

    public function billType()
    {
        return $this->belongsTo(BillingType::class, 'billing_type')->select('id', 'name');
    }

    public function emailFrom()
    {
        return $this->belongsTo(EmailFrom::class, 'email_from_id')->select('id', 'name', 'email');
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class)->select('id', 'created', 'order_id', 'entity_name', 'live_url', 'url', 'anchor', 'is_other_price', 'link_insert', 'artical', 'url_price', 'other_price', 'total')->withTrashed();
    }

    static function pendingOrderList()
    {
        return DB::select("SELECT email FROM `orders` WHERE status='unpaid' AND deleted_at IS NULL GROUP BY email ORDER BY email ASC");
    }

    static function emailList()
    {
        return DB::select("SELECT email FROM `orders` WHERE deleted_at IS NULL GROUP BY email ORDER BY email ASC");
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'email', 'email');
    }

    static function realtimeSearch($request)
    {
        $where = [];

        if (!empty($request->email)) {
            $where[] = ['email', $request->email];
        }

        // Custom Date Range
        if (!empty($request->date_range)) {
            $dateRange = explode('to', $request->date_range);

            $where[] = ['orders.created', '>=', $dateRange[0]];
            if (!empty($dateRange[1])) {
                $where[] = ['orders.created', '<=', $dateRange[1]];
            }
        }

        if (!empty($request->date_from)) {
            $where[] = ['created', '>=', $request->date_from];
        }

        if (!empty($request->date_to)) {
            $where[] = ['created', '<=', $request->date_to];
        }

        if (!empty($request->billing_type)) {
            $where[] = ['billing_type', $request->billing_type];
        }

        if (!empty($request->user_id)) {
            $where[] = ['user_id', $request->user_id];
        }

        if (!empty($request->status)) {
            $where[] = ['status', $request->status];
        }

        if (!empty($request->email_from_id)) {
            $where[] = ['email_from_id', $request->email_from_id];
        }

        $results = Order::with('admin', 'orderItem', 'emailFrom')->orderBy('id', 'asc')->where($where)->paginate(10)->withQueryString();

        $data['orderEmail']  = $request->email;
        $data['date_range']  = $request->date_range;
        $data['dateFrom']    = $request->date_from;
        $data['dateTo']      = $request->date_to;
        $data['billingType'] = $request->billing_type;
        $data['userId']      = $request->user_id;
        $data['status']      = $request->status;
        $data['emailFromId'] = $request->email_from_id;

        $data['results']     = $results;

        return (object)$data;
    }

    static function sitesSearch($request)
    {
        $where = [];

        // if (!empty($request->check_url)) {
        //     $where[] = ['url', $request->check_url];
        // }

        if (!empty($request->date_from)) {
            $where[] = ['created', '>=', $request->date_from];
        }

        if (!empty($request->date_to)) {
            $where[] = ['created', '<=', $request->date_to];
        }

        if (!empty($request->user_id)) {
            $where[] = ['user_id', $request->user_id];
        }

        if (!empty($request->status)) {
            $where[] = ['status', $request->status];
        }

        $results = Order::with('admin', 'orderItem', 'emailFrom')->orderBy('created', 'desc')->where($where)->paginate(10)->withQueryString();

        //$data['check_url'] = $request->check_url;

        $data['dateFrom'] = $request->date_from;
        $data['dateTo']   = $request->date_to;
        $data['userId']   = $request->user_id;
        $data['status']   = $request->status;

        $data['results']  = $results;

        return (object)$data;
    }
}
