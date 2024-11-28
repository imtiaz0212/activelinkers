<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    public function method()
    {
        return $this->belongsTo(PaymentMethod::class, 'method_id')->select('id', 'name', 'mode', 'status');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'user_id')->select('id', 'name', 'email', 'mobile', 'avatar', 'privilege');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    static function emailList()
    {
        return DB::select("SELECT email FROM `invoices` WHERE deleted_at IS NULL GROUP BY email ORDER BY email ASC");
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

            $where[] = ['created', '>=', $dateRange[0]];
            if (!empty($dateRange[1])) {
                $where[] = ['created', '<=', $dateRange[1]];
            }
        }

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

        $results = Invoice::with('method', 'admin')->orderBy('id', 'asc')->where($where)->paginate(10)->withQueryString();

        $data['invoiceEmail'] = $request->email;

        $data['date_range'] = $request->date_range;

        $data['dateFrom'] = $request->date_from;

        $data['dateTo'] = $request->date_to;

        $data['userId'] = $request->user_id;

        $data['status'] = $request->status;

        $data['results'] = $results;

        return (object)$data;
    }

    static function clientSummary($request)
    {
        $where = [];

        if (!empty($request->email)) {
            $where[] = ['email', $request->email];
        }

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

        $results = Invoice::where($where)->orderBy('created', 'desc')->paginate(10)->withQueryString();

        $data['email'] = $request->email;

        $data['dateFrom'] = $request->date_from;

        $data['dateTo'] = $request->date_to;

        $data['userId'] = $request->user_id;

        $data['status'] = $request->status;

        $data['results'] = $results;

        return (object)$data;
    }
}
