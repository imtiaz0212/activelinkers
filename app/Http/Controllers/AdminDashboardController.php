<?php

namespace App\Http\Controllers;

use App\Models\AdminDashboard;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\MockObject\object;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

        $this->middleware(['permission:dashboard,admin'])->only('index');

        $this->data['activeMenu'] = 'dashboard';
    }

    public function index()
    {
        $this->data['info'] = AdminDashboard::todayDetails();

        $this->getTotals();
        $this->getCurrentYearMonthlyTotals();

        return view('layouts.backend-partial.dashboard', $this->data);
    }

    // get totals
    private function getTotals()
    {
        // get total amount
        $status           = ['unpaid', 'paid', 'delete'];
        $totalQtyArray    = array_fill_keys($status, 0);
        $totalAmountArray = array_fill_keys($status, 0);

        $invoiceList = Invoice::selectRaw('status, SUM(grand_total) as amount, COUNT(*) as quantity')
            ->whereIn('status', $status)
            ->groupBy('status')->get();

        if (!empty($invoiceList)) {
            foreach ($invoiceList as $row) {
                $totalQtyArray[$row->status]    = (int)$row->quantity;
                $totalAmountArray[$row->status] = round($row->amount, 2);
            }
        }

        $this->data['totalQty']    = (object)$totalQtyArray;
        $this->data['totalAmount'] = (object)$totalAmountArray;

        // get current month income
        $startData                        = Carbon::now()->startOfMonth()->toDateString();
        $endData                          = Carbon::now()->endOfMonth()->toDateString();
        $currentMonthIncome               = Invoice::where('status', 'paid')->whereBetween('created', [$startData, $endData])->sum('grand_total');
        $this->data['currentMonthIncome'] = round($currentMonthIncome, 2);

        // get current month income
        $today                     = date('Y-m-d');
        $currentMonthIncome        = Invoice::where('status', 'paid')->where('created', $today)->sum('grand_total');
        $this->data['todayIncome'] = round($currentMonthIncome, 2);

        // get previous month invoice
        $startPreDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $endPreDate   = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        $invoiceList = Invoice::select('created', 'grand_total', 'status')
            ->whereBetween('created', [$startPreDate, $endData])
            ->whereIn('status', $status)->get();

        $qtyRatio    = array_fill_keys($status, 0);
        $amountRatio = array_fill_keys($status, 0);
        foreach ($status as $value) {
            // calculate monthly amount ratio
            $preInvoiceTotalAmount = $invoiceList->where('status', $value)->whereBetween('created', [$startPreDate, $endPreDate])->sum('grand_total');
            $invoiceTotalAmount    = $invoiceList->where('status', $value)->whereBetween('created', [$startData, $endData])->sum('grand_total');

            $percentageChange = 0;
            if ($preInvoiceTotalAmount != 0) {
                $percentageChange = (($invoiceTotalAmount - $preInvoiceTotalAmount) / $preInvoiceTotalAmount) * 100;
            }
            $amountRatio[$value] = round($percentageChange, 1);

            // calculate monthly quantity ratio
            $preInvoiceTotalQty = $invoiceList->where('status', $value)->whereBetween('created', [$startPreDate, $endPreDate])->count();
            $invoiceTotalQty    = $invoiceList->where('status', $value)->whereBetween('created', [$startData, $endData])->count();

            $percentageChange = 0;
            if ($preInvoiceTotalQty != 0) {
                $percentageChange = (($invoiceTotalQty - $preInvoiceTotalQty) / $preInvoiceTotalQty) * 100;
            }
            $qtyRatio[$value] = round($percentageChange, 1);
        }

        $this->data['qtyRatio']    = (object)$qtyRatio;
        $this->data['amountRatio'] = (object)$amountRatio;

        // get today income ration
        $previousDay  = Carbon::yesterday()->toDateString();
        $currentDate  = Carbon::now()->toDateString();
        $todayIncome  = $invoiceList->where('created', $currentDate)->where('status', 'paid')->sum('grand_total');
        $preDayIncome = $invoiceList->where('created', $previousDay)->where('status', 'paid')->sum('grand_total');

        $percentageChange = 0;
        if ($preDayIncome != 0) {
            $percentageChange = (($todayIncome - $preDayIncome) / $preDayIncome) * 100;
        }

        $this->data['todayIncomeRatio'] = round($percentageChange, 1);
    }

    // get current year monthly report
    private function getCurrentYearMonthlyTotals()
    {
        $currentYear      = Carbon::now()->year;
        $rawMonthlyTotals = DB::table('invoices')
            ->selectRaw('MONTH(created) as month, SUM(grand_total) as total_amount')
            ->where('status', 'paid')
            ->whereNull('deleted_at')
            ->whereYear('created', $currentYear)
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->pluck('total_amount', 'month');

        $monthlyTotals = collect();
        for ($month = 1; $month <= 12; $month++) {
            $monthTotal = (!empty($rawMonthlyTotals[$month]) ? $rawMonthlyTotals[$month] : 0);
            $monthlyTotals->put($month, $monthTotal);
        }

        $this->data['monthlyTotals'] = $monthlyTotals;
    }
}
