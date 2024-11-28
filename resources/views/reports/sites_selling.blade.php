@extends('layouts.app')

@section('content')
<div>
    <!-- Pages Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Site Selling Reports</h3>
    </div>

    <div class="mb-4 px-4">
        <div class="relative overflow-hidden shadow-sm border rounded mt-5 p-5">
            <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-3">
                <div>
                    <select name="check_url" id="check_url" onchange="getFilterData()" class="inputField select2"
                        style="width: 100% !important">
                        <option value="">Select URL</option>
                        @if (!empty($siteList))
                        @foreach ($siteList as $key => $sites)
                        <option value="{{ $sites->url }}" {{ ($sites->url == $info->check_url) ? 'selected' : '' }}>
                            {{ $sites->check_url }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <div id="custom_date_range">
                    <input type="text" name="date_range" id="dateRange" value="{{ $info->date_range }}"
                        placeholder="Custom Date Range" class="inputField !bg-white" />
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
                        Site URL
                    </th>

                    <th>
                        Last Sold Date
                    </th>

                    <th class="w-[150px]">
                        Total Post
                    </th>
                </tr>

            </thead>
            <tbody>
                @if (!empty($info->results) && $info->results->isNotEmpty())
                @foreach ($info->results as $key => $row)
                <?php
                            $orderItems = DB::table('order_items')
                                ->where('url', $row->url)
                                ->orderBy('created_at', 'desc')
                                ->get();
                            ?>

                <tr>
                    <td class="whitespace-nowrap">
                        {{ !empty($row->url) ? $row->url : '' }}
                    </td>

                    <td class="whitespace-nowrap">
                        <span>{{ \Carbon\Carbon::parse($orderItems[0]->created_at)->diffForhumans() }}</span>
                    </td>

                    <td class="text-center">
                        {{ $orderItems->count() }}
                    </td>

                </tr>
                @endforeach
                @endif
            </tbody>
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

        function getFilterData(reset = '') {
            let mainUrl = "{{ route('admin.reports.sites-selling') }}";
            let getUrl = window.location.href;
            const [url, data] = getUrl.split('?');

            const check_url = document.getElementById('check_url').value;
            const dateRange = document.getElementById('dateRange').value;

            const filters = [{
                    value: check_url,
                    paramName: 'check_url'
                },
                {
                    value: dateRange,
                    paramName: 'date_range'
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
                location.href = "{{ route('admin.reports.sites-selling') }}";
            } else {
                location.href = mainUrl;
            }
        }
</script>
@endpush