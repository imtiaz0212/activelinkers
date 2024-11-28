@extends('layouts.app')

@section('content')

<div>
    <!-- Pages Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Order Reports</h3>
    </div>

    <div class="mb-4 px-4">
        <div class="relative overflow-hidden shadow-sm border rounded mt-5 p-5">
            <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-3">

                <div>
                    <select name="filter" id="filter" onchange="getFilterData()" class="inputField select2"
                        style="width: 100%!important">
                        <option value="">Select Calendar</option>
                        <option value="today" {{ $info->filter == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="yesterday" {{ $info->filter == 'yesterday' ? 'selected' : '' }}>Yesterday
                        </option>
                        <option value="this_week" {{ $info->filter == 'this_week' ? 'selected' : '' }}>This Week
                        </option>
                        <option value="last_week" {{ $info->filter == 'last_week' ? 'selected' : '' }}>Last Week
                        </option>
                        <option value="last_7_days" {{ $info->filter == 'last_7_days' ? 'selected' : '' }}>Last 7 Days
                        </option>
                        <option value="this_month" {{ $info->filter == 'this_month' ? 'selected' : '' }}>This Month
                        </option>
                        <option value="last_month" {{ $info->filter == 'last_month' ? 'selected' : '' }}>Last Month
                        </option>
                        <option value="last_3_month" {{ $info->filter == 'last_3_month' ? 'selected' : '' }}>Last 3
                            Month</option>
                        <option value="this_3_month" {{ $info->filter == 'this_3_month' ? 'selected' : '' }}>This 3
                            Month</option>
                        <option value="this_year" {{ $info->filter == 'this_year' ? 'selected' : '' }}>This Year
                        </option>
                        <option value="last_year" {{ $info->filter == 'last_year' ? 'selected' : '' }}>Last Year
                        </option>
                        <option value="custom_date_range" {{ $info->filter == 'custom_date_range' ? 'selected' : '' }}>
                            Custom Date Range</option>
                        <option value="custom_month" {{ $info->filter == 'custom_month' ? 'selected' : '' }}>Custom
                            Month</option>
                    </select>
                </div>

                <div id="custom_month">
                    <select name="month_name" id="month_name" onchange="getFilterData()" class="inputField select2"
                        style="width: 100%!important">
                        <option value="">Select Month</option>
                        <option value="january" {{ $info->month_name == 'january' ? 'selected' : '' }}>January</option>
                        <option value="february" {{ $info->month_name == 'february' ? 'selected' : '' }}>February
                        </option>
                        <option value="march" {{ $info->month_name == 'march' ? 'selected' : '' }}>March</option>
                        <option value="april" {{ $info->month_name == 'april' ? 'selected' : '' }}>April</option>
                        <option value="may" {{ $info->month_name == 'may' ? 'selected' : '' }}>May</option>
                        <option value="june" {{ $info->month_name == 'june' ? 'selected' : '' }}>June</option>
                        <option value="july" {{ $info->month_name == 'july' ? 'selected' : '' }}>July</option>
                        <option value="august" {{ $info->month_name == 'august' ? 'selected' : '' }}>August</option>
                        <option value="september" {{ $info->month_name == 'september' ? 'selected' : '' }}>September
                        </option>
                        <option value="october" {{ $info->month_name == 'october' ? 'selected' : '' }}>October</option>
                        <option value="november" {{ $info->month_name == 'november' ? 'selected' : '' }}>November
                        </option>
                        <option value="december" {{ $info->month_name == 'december' ? 'selected' : '' }}>December
                        </option>
                    </select>
                </div>

                <div id="custom_date_range">
                    <input type="text" name="date_range" id="dateRange" value="{{ $info->date_range }}"
                        placeholder="Custom Date Range" class="inputField" />
                </div>

                <div>
                    <select name="order_email" id="orderEmail" onchange="getFilterData()" class="inputField select2"
                        style="width: 100%!important">
                        <option value="">Select Order Email</option>
                        @if (!empty($orderInfo))
                        @foreach ($orderInfo as $key => $order)
                        <option value="{{ $order->email }}" {{ $order->email == $info->orderEmail ? 'selected' : '' }}>
                            {{ $order->email }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <div>
                    <select name="user_id" id="userId" onchange="getFilterData()" class="inputField select2"
                        style="width: 100%!important">
                        <option value="">Select User</option>
                        @if (!empty($admin))
                        @foreach ($admin as $row => $user)
                        <option value="{{ $user->id }}" {{ $info->userId == $user->id ? 'selected' : '' }}>
                            {{ strFilter($user->name) }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <div>
                    <select name="status" id="status" onchange="getFilterData()" class="inputField select2"
                        style="width: 100%!important">
                        <option value="">Select Status</option>
                        <option value="pending" {{ $info->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="unpaid" {{ $info->status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        <option value="paid" {{ $info->status == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="delete" {{ $info->status == 'delete' ? 'selected' : '' }}>Delete</option>
                    </select>
                </div>

                <div>
                    <button type="button" onclick="getFilterData(true)"
                        class="button button--destructive">Reset</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Blog Table -->
    <div class="custom-data-table">
        <table id="dataTable">
            <thead>
                <tr>
                    <th>
                        Invoice No
                    </th>

                    <th>
                        Created At
                    </th>

                    <th>
                        Email
                    </th>

                    <th>
                        Status
                    </th>

                    <th>
                        Is Prepaid?
                    </th>

                    <th>
                        Order Details
                    </th>

                    <th>
                        Amount
                    </th>

                    <th>
                        Service Charge
                    </th>

                    <th>
                        Tax
                    </th>

                    <th>
                        Discount
                    </th>

                    <th>
                        Total Amount
                    </th>
                </tr>

            </thead>
            <tbody>
                @php($totalAmount = $totalSubtotal = $totalServiceCharge = $totalTax = $totalDiscount = 0)
                @if (!empty($info->results) && $info->results->isNotEmpty())
                @foreach ($info->results as $key => $row)
                @php($totalAmount += $row->grand_total)
                @php($totalSubtotal += $row->subtotal)
                @php($totalServiceCharge += $row->service_charge)
                @php($totalTax += $row->tax)
                @php($totalDiscount += $row->discount)
                <?php
                            $orderitems = DB::table('order_items')
                                ->where('order_id', $row->id)
                                ->whereNull('deleted_at')
                                ->get();
                            ?>


                <tr>
                    <td>
                        #{{ $row->order_no }}
                    </td>

                    <td class="whitespace-nowrap">
                        {{ !empty($row->created) ? date('d F, Y', strtotime($row->created)) : '' }}
                    </td>

                    <td>
                        {{ $row->email }}
                    </td>

                    <td>
                        @if ($row->status == 'pending')
                        <span class="badge badge-premium mb-2">
                            {{ strFilter($row->status) }}
                        </span>
                        @elseif($row->status == 'unpaid')
                        <span class="badge badge-warning mb-2">
                            {{ strFilter($row->status) }}
                        </span>
                        @elseif($row->status == 'delete')
                        <span class="badge badge-danger mb-2">
                            {{ strFilter($row->status) }}
                        </span>
                        @else
                        <span class="badge badge-success mb-2">
                            {{ strFilter($row->status) }}
                        </span>
                        @endif
                    </td>

                    <td>
                        @if ($row->prepaid_status == 'completed')
                        <span class="badge badge-success mb-2">
                            {{ $row->prepaid_status }}
                        </span>
                        @elseif($row->prepaid_status == 'prepaid')
                        <span class="badge badge-warning mb-2">
                            {{ $row->prepaid_status }}
                        </span>
                        @else
                        &nbsp;
                        @endif
                    </td>

                    <td>
                        @foreach ($orderitems as $itemkey => $items)
                        <a href="{{ $items->live_url }}" target="_blank"
                            class="px-1 py-[2px] inline-block rounded text-error bg-error/10 whitespace-nowrap">
                            {{ removeHttp($items->live_url) }}
                        </a> - Total: {{ sprintf("$%0.2f", $items->total) }} USD
                        <br />
                        @endforeach
                    </td>

                    <td class="text-center">
                        {{ sprintf("$%0.2f", $row->subtotal) }}
                    </td>

                    <td class="text-center">
                        {{ sprintf("$%0.2f", $row->service_charge) }}
                    </td>

                    <td class="text-center">
                        {{ sprintf("$%0.2f", $row->tax) }}
                    </td>

                    <td class="text-center">
                        {{ sprintf("$%0.2f", $row->discount) }}
                    </td>

                    <td class="text-center">
                        {{ sprintf("$%0.2f", $row->grand_total) }}
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="6" class="total text-right">
                        Total
                    </th>
                    <th class="amount text-center">
                        {{ sprintf("$%0.2f", $totalSubtotal) }}
                    </th>
                    <th class="amount text-center">
                        {{ sprintf("$%0.2f", $totalServiceCharge) }}
                    </th>
                    <th class="amount text-center">
                        {{ sprintf("$%0.2f", $totalTax) }}
                    </th>
                    <th class="amount text-center">
                        {{ sprintf("$%0.2f", $totalDiscount) }}
                    </th>
                    <th class="amount text-center">
                        {{ sprintf("$%0.2f", $totalAmount) }}
                    </th>
                </tr>
            </tfoot>
        </table>

        <!-- Display pagination links -->
        {{ $info->results->links() }}
    </div>
</div>
@endsection

@push('headerPartial')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.dataTables.css">
<link rel="stylesheet" href="{{ asset('public/css/custom-data-table.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .custom-data-table th.total {
        text-align: right !important;
    }

    .custom-data-table th.amount {
        text-align: center !important;
    }
</style>
@endpush

@push('footerPartial')
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
            $('.select2').select2();
        });
        $(document).ready(function() {
            $('#dataTable').DataTable({
                searching: false, // Disable searching
                ordering: false, // Disable ordering (sorting)
                paging: false, // Disable pagination
                info: false, // Hide "Showing 1 to 5 of 5 entries"
                scrollX: true, // Enable horizontal scrolling if needed
                "aaSorting": []
            });
        });

        flatpickr("#dateRange", {
            mode: "range",
            clickOpens: true,
            onChange: function(selectedDates, dateStr, instance) {
                const regex = /^\d{4}\-\d{2}\-\d{2} to \d{4}\-\d{2}\-\d{2}$/;
                if (regex.test(dateStr)) {
                    return getFilterData();
                }
            }
        });

        document.getElementById("custom_month").style.display = "none";

        document.getElementById("custom_date_range").style.display = "none";

        const defaultCustomDateRange = '{{ $info->filter }}';

        if (defaultCustomDateRange == 'custom_date_range') {
            document.getElementById("custom_date_range").style.display = "block";
        }
        if (defaultCustomDateRange == 'custom_month') {
            document.getElementById("custom_month").style.display = "block";
        }

        function getFilterData(reset = '') {
            let mainUrl = "{{ route('admin.reports') }}";
            let getUrl = window.location.href;
            const [url, data] = getUrl.split('?');

            const filter = document.getElementById('filter').value;

            const dateRange = document.getElementById('dateRange').value;

            const month_name = document.getElementById('month_name').value;

            const orderEmail = document.getElementById('orderEmail').value;

            const userId = document.getElementById('userId').value;

            const status = document.getElementById('status').value;

            if (filter == "custom_date_range") {
                document.getElementById("custom_date_range").style.display = "block";
            }
            const filters = [{
                    value: orderEmail,
                    paramName: 'email'
                },
                {
                    value: filter,
                    paramName: 'filter'
                },
                {
                    value: dateRange,
                    paramName: 'date_range'
                },
                {
                    value: month_name,
                    paramName: 'month_name'
                },
                {
                    value: userId,
                    paramName: 'user_id'
                },
                {
                    value: status,
                    paramName: 'status'
                },
            ];

            // Construct URL with selected filter values
            let queryParams = filters
                .filter(filter => filter.value && filter.value !== 'all')
                .map(filter => filter.paramName + '=' + filter.value)
                .join('&');
            if (queryParams) {
                mainUrl += '?' + queryParams;
            }
            // Redirect to the constructed URL
            if (reset) {
                location.href = "{{ route('admin.reports') }}";
            } else {
                location.href = mainUrl;
            }
        }
</script>
@endpush
