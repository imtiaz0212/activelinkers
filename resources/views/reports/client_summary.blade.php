@extends('layouts.app')

@section('content')
<div>
    <!-- Pages Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Client Summary Reports</h3>
    </div>

    <div class="mb-4 px-4">
        <div class="relative overflow-hidden shadow-sm border rounded mt-5 p-5">
            <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-3">

                <div>
                    <select name="filter" id="filter" onchange="getFilterData()" class="inputField select2"
                        style="width: 100% !important">
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
                        style="width: 100% !important">
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
                        style="width: 100% !important">
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
                        style="width: 100% !important">
                        <option value="">Select User</option>
                        @if (!empty($admin))
                        @foreach ($admin as $row => $user)
                        <option value="{{ $user->id }}" {{ $user->id == $info->userId ? 'selected' : '' }}>
                            {{ strFilter($user->name) }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <div>
                    <select name="status" id="status" onchange="getFilterData()" class="inputField select2"
                        style="width: 100% !important">
                        <option value="">Select Status</option>
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
                        Email
                    </th>

                    <th>
                        Total Paid
                    </th>

                    <th>
                        Total Unpaid
                    </th>

                    <th>
                        Total Deleted
                    </th>

                    <th>
                        Total Live Link
                    </th>

                    <th>
                        Last Date of Order
                    </th>
                </tr>

            </thead>

            <tbody>
                @php
                $totalPaid = 0;
                $totalUnpaid = 0;
                $totalDelete = 0;
                $totalLiveLink = 0;
                @endphp
                @if (!empty($info->results) && $info->results->isNotEmpty())
                @foreach ($info->results as $key => $row)
                @php
                $totalPaid += $row->paid;
                $totalUnpaid += $row->unpaid;
                $totalDelete += $row->delete;
                $totalLiveLink += $row->live_links;
                @endphp

                <tr>
                    <td class="whitespace-nowrap">
                        {{ $row->email }}
                    </td>

                    <td class="text-center">
                        {{ sprintf("$%0.2f", $row->paid) }}
                    </td>

                    <td class="text-center">
                        {{ sprintf("$%0.2f", $row->unpaid) }}
                    </td>

                    <td class="text-center">
                        {{ sprintf("$%0.2f", $row->delete) }}
                    </td>

                    <td class="text-center">
                        {{round($row->live_links, 2)}}
                    </td>

                    <td class="text-center">
                        <span>{{ $row->last_order_date }}</span>
                    </td>

                </tr>
                @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <th class="total text-right">Total</th>
                    <th class="amount text-center">
                        {{ sprintf("$%0.2f", $totalPaid) }}
                    </th>
                    <th class="amount text-center">
                        {{ sprintf("$%0.2f", $totalUnpaid) }}
                    </th>
                    <th class="amount text-center">
                        {{ sprintf("$%0.2f", $totalDelete) }}
                    </th>
                    <th class="amount text-center">
                        {{ $totalLiveLink }}
                    </th>
                    <th></th>
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

    .custom-data-table td,
    .custom-data-table tfoot tr th {
        text-align: left !important;
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
            let mainUrl = "{{ route('admin.reports.client-summary') }}";
            let getUrl = window.location.href;
            const [url, data] = getUrl.split('?');

            const filter = document.getElementById('filter').value;

            const dateRange = document.getElementById('dateRange').value;

            const month_name = document.getElementById('month_name').value;

            const orderEmail = document.getElementById('orderEmail').value;

            const userId = document.getElementById('userId').value;

            const status = document.getElementById('status').value;

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
                location.href = "{{ route('admin.reports.client-summary') }}";
            } else {
                location.href = mainUrl;
            }
        }
</script>
@endpush