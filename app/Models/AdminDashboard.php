<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdminDashboard extends Model
{
    use HasFactory;

    static function todayDetails()
    {
        $data   = [];

        $orderList   = Order::get();

        $invoiceList = Invoice::get();

        $siteList    = SiteList::get();

        $data['today_sites']           = $siteList->count();

        $data['total_order']           = $orderList->count();

        $data['total_pending_order']   = $orderList->where('status', 'pending')->count();

        $data['total_invoice']         = $invoiceList->count();

        $data['total_pending_invoice'] = $invoiceList->where('status', 'pending')->count();

        $data['total_paid']            = $invoiceList->where('is_payment', 1)->sum('grand_total');

        // delete invoice
        $data['total_trash_invoice']   = $invoiceList->where('status', 'delete')->count();

        return (object)$data;
    }
}
