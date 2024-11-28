@extends('layouts.app')
@section('content')
<div class="grid gap-10">
    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-7">
        <div class="dashboardCard">
            <div class="flex items-center justify-between mb-5 pb-1">
                <div class="grid gap-1">
                    <h3 class="font-bold text-3xl text-darkblue">${{$totalAmount->paid}}</h3>
                    <span class="text-gray-700">Total Income</span>
                </div>
                <div class="dashboardCardIcon">
                    <i class="fa-solid fa-building-columns"></i>
                </div>
            </div>
            <div class="flex items-center">
                <div class="mr-2 {{$amountRatio->paid < 0 ? 'text-error' : 'text-success'}}">
                    @if ($amountRatio->paid < 0 ) <i class="fa-solid fa-arrow-trend-down"></i>
                        @else
                        <i class="fa-solid fa-arrow-trend-up"></i>
                        @endif
                </div>
                <p class="font-semibold text-gray-700">
                    <span
                        class="{{$amountRatio->paid < 0 ? 'text-error' : 'text-success'}}">{{$amountRatio->paid}}%</span>
                    Since last month
                </p>
            </div>
        </div>

        <div class="dashboardCard">
            <div class="flex items-center justify-between mb-5 pb-1">
                <div class="grid gap-1">
                    <h3 class="font-bold text-3xl text-darkblue">${{$currentMonthIncome}}</h3>
                    <span class="text-gray-700">Earning In This Month</span>
                </div>
                <div class="dashboardCardIcon">
                    <i class="fa-solid fa-wallet"></i>
                </div>
            </div>
            <div class="flex items-center">
                <div class="mr-2 {{$amountRatio->paid < 0 ? 'text-error' : 'text-success'}}">
                    @if ($amountRatio->paid < 0 ) <i class="fa-solid fa-arrow-trend-down"></i>
                        @else
                        <i class="fa-solid fa-arrow-trend-up"></i>
                        @endif
                </div>
                <p class="font-semibold text-gray-700">
                    <span
                        class="{{$amountRatio->paid < 0 ? 'text-error' : 'text-success'}}">{{$amountRatio->paid}}%</span>
                    Since last month
                </p>
            </div>
        </div>

        <div class="dashboardCard">
            <div class="flex items-center justify-between mb-5 pb-1">
                <div class="grid gap-1">
                    <h3 class="font-bold text-3xl text-darkblue">${{$todayIncome}}</h3>
                    <span class="text-gray-700">Earning Today</span>
                </div>
                <div class="dashboardCardIcon">
                    <i class="fa-solid fa-dollar-sign"></i>
                </div>
            </div>
            <div class="flex items-center">
                <div class="mr-2 {{$todayIncomeRatio < 0 ? 'text-error' : 'text-success'}}">
                    @if ($todayIncomeRatio < 0 ) <i class="fa-solid fa-arrow-trend-down"></i>
                        @else
                        <i class="fa-solid fa-arrow-trend-up"></i>
                        @endif
                </div>
                <p class="font-semibold text-gray-700">
                    <span
                        class="{{$todayIncomeRatio < 0 ? 'text-error' : 'text-success'}}">{{$todayIncomeRatio}}%</span>
                    Since last day
                </p>
            </div>
        </div>

        <div class="dashboardCard">
            <div class="flex items-center justify-between mb-5 pb-1">
                <div class="grid gap-1">
                    <h3 class="font-bold text-3xl text-darkblue">{{$totalQty->delete}}</h3>
                    <span class="text-gray-700">Total Cancel</span>
                </div>
                <div class="dashboardCardIcon">
                    <i class="fa-regular fa-rectangle-xmark"></i>
                </div>
            </div>
            <div class="flex items-center">
                <div class="mr-2 {{$qtyRatio->delete < 0 ? 'text-error' : 'text-success'}}">
                    @if ($qtyRatio->delete < 0 ) <i class="fa-solid fa-arrow-trend-down"></i>
                        @else
                        <i class="fa-solid fa-arrow-trend-up"></i>
                        @endif
                </div>
                <p class="font-semibold text-gray-700">
                    <span
                        class="{{$qtyRatio->delete < 0 ? 'text-error' : 'text-success'}}">{{$qtyRatio->delete}}%</span>
                    Since last day
                </p>
            </div>
        </div>

        <div class="dashboardCard">
            <div class="flex items-center justify-between mb-5 pb-1">
                <div class="grid gap-1">
                    <h3 class="font-bold text-3xl text-darkblue">{{$totalQty->unpaid}}</h3>
                    <span class="text-gray-700">Pending Order</span>
                </div>
                <div class="dashboardCardIcon">
                    <i class="fa-regular fa-hourglass-half"></i>
                </div>
            </div>
            <div class="flex items-center">
                <div class="mr-2 {{$qtyRatio->unpaid < 0 ? 'text-error' : 'text-success'}}">
                    @if ($qtyRatio->unpaid < 0 ) <i class="fa-solid fa-arrow-trend-down"></i>
                        @else
                        <i class="fa-solid fa-arrow-trend-up"></i>
                        @endif
                </div>
                <p class="font-semibold text-gray-700">
                    <span
                        class="{{$qtyRatio->unpaid < 0 ? 'text-error' : 'text-success'}}">{{$qtyRatio->unpaid}}%</span>
                    Since last month
                </p>
            </div>
        </div>

        <div class="dashboardCard">
            <div class="flex items-center justify-between mb-5 pb-1">
                <div class="grid gap-1">
                    <h3 class="font-bold text-3xl text-darkblue">{{$totalQty->paid}}</h3>
                    <span class="text-gray-700">Complete Order</span>
                </div>
                <div class="dashboardCardIcon">
                    <i class="fa-regular fa-square-check"></i>
                </div>
            </div>
            <div class="flex items-center">
                <div class="mr-2 {{$qtyRatio->paid < 0 ? 'text-error' : 'text-success'}}">
                    @if ($qtyRatio->paid < 0 ) <i class="fa-solid fa-arrow-trend-down"></i>
                        @else
                        <i class="fa-solid fa-arrow-trend-up"></i>
                        @endif
                </div>
                <p class="font-semibold text-gray-700">
                    <span class="{{$qtyRatio->paid < 0 ? 'text-error' : 'text-success'}}">{{$qtyRatio->paid}}%</span>
                    Since last month
                </p>
            </div>
        </div>

        <div class="dashboardCard">
            <div class="flex items-center justify-between mb-5 pb-1">
                <div class="grid gap-1">
                    <h3 class="font-bold text-3xl text-darkblue">${{$totalAmount->unpaid}}</h3>
                    <span class="text-gray-700">Unpaid Order</span>
                </div>
                <div class="dashboardCardIcon">
                    <i class="fa-solid fa-sack-dollar"></i>
                </div>
            </div>
            <div class="flex items-center">
                <div class="mr-2 {{$amountRatio->unpaid < 0 ? 'text-error' : 'text-success'}}">
                    @if ($amountRatio->unpaid < 0 ) <i class="fa-solid fa-arrow-trend-down"></i>
                        @else
                        <i class="fa-solid fa-arrow-trend-up"></i>
                        @endif
                </div>
                <p class="font-semibold text-gray-700">
                    <span
                        class="{{$amountRatio->unpaid < 0 ? 'text-error' : 'text-success'}}">{{$amountRatio->unpaid}}%</span>
                    Single last month
                </p>
            </div>
        </div>

        <div class="dashboardCard">
            <div class="flex items-center justify-between mb-5 pb-1">
                <div class="grid gap-1">
                    <h3 class="font-bold text-3xl text-darkblue">${{$totalAmount->delete}}</h3>
                    <span class="text-gray-700">Cancel Order</span>
                </div>
                <div class="dashboardCardIcon">
                    <i class="fa-regular fa-rectangle-xmark"></i>
                </div>
            </div>
            <div class="flex items-center">
                <div class="mr-2 {{$amountRatio->delete < 0 ? 'text-error' : 'text-success'}}">
                    @if ($amountRatio->delete < 0 ) <i class="fa-solid fa-arrow-trend-down"></i>
                        @else
                        <i class="fa-solid fa-arrow-trend-up"></i>
                        @endif
                </div>
                <p class="font-semibold text-gray-700">
                    <span
                        class="{{$amountRatio->delete < 0 ? 'text-error' : 'text-success'}}">{{$amountRatio->delete}}%</span>
                    Single last month
                </p>
            </div>
        </div>
    </div>

    <div class="rounded-lg border shadow-[0px_0px_35px_0px_rgba(104,134,177,0.15)]">
        <div class="panelHeader bg-white">
            <h3 class="panelHeaderTitle">Total Income Reports</h3>
        </div>
        <div class="p-5">
            <div id="incomeChart"></div>
        </div>
    </div>
</div>


@endsection

@push('footerPartial')
<style>
    #dashboardMain {
        border: none
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    const monthlyTotals = @json($monthlyTotals);
        const monthlyTotalArray = Object.values(monthlyTotals);

        // Revenue Summary
        var options = {
            series: [{
                name: 'Total income reports',
                data: monthlyTotalArray
            }],
            chart: {
                height: 340,
                type: 'bar',
                offsetY: 0,
                toolbar: {
                    show: false,
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 10,
                    dataLabels: {
                        position: 'top',
                    },
                    dataLabels: {
                        enabled: true,
                    },
                }
            },
            colors: ['#0866FF'],

            dataLabels: {
                formatter: function (val) {
                    return "$" + val;
                },
                style: {
                    fontSize: '10px',
                    colors: ["#ffffff"],
                    fontWeight: 600
                },
            },

            grid: {
                borderColor: 'transparent',
                strokeDashArray: 5,
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
            },
            xaxis: {
                categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                position: 'top',
                labels: {
                    style: {
                        colors: ['#A9A9C8', '#A9A9C8', '#A9A9C8', '#A9A9C8', '#A9A9C8', '#A9A9C8', '#A9A9C8', '#A9A9C8', '#A9A9C8', '#A9A9C8', '#A9A9C8', '#A9A9C8',],
                    },
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                tooltip: {
                    enabled: false,
                }
            },
            yaxis: {
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false,
                },
                labels: {
                    show: false,
                    formatter: function (val) {
                        return "$" + val;
                    }
                }
            },
        };
        var chart = new ApexCharts(document.querySelector("#incomeChart"), options);
        chart.render();
</script>
@endpush