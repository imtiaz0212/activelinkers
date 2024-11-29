@extends('layouts.app')

@section('content')


<div>
    <!-- Pages Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Package</h3>

        @if (canAccess(['package create']))
        <a href="{{ route('admin.package.create') }}" class="button">
            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            Create Package
        </a>
        @endif
    </div>

    <div class="mb-4 px-4">
        {{-- <div class="flex items-center justify-between bg-gray-50 p-4 border-b rounded">
            <h3 class="text-xl font-semibold">Search Order</h3>
        </div> --}}
        <div class="relative overflow-x-auto shadow-sm border rounded mt-5 p-5">
            <div class="grid sm:grid-cols-2 md:grid-cols-5 gap-3">

                <div class="md:col-span-2">
                    <select name="service_id" id="serviceId" onchange="getFilterData()" class="inputField select2">
                        <option value="">Select Service</option>
                        @if (!empty($servicelist) && $servicelist->isNotEmpty())
                        @foreach ($servicelist as $service)
                        <option value="{{ $service->id }}" {{ $info->serviceId == $service->id ? 'selected' : '' }}>
                            {{ strFilter($service->title) }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <div class="md:col-span-1">
                    <select name="type" id="serviceType" onchange="getFilterData()" class="inputField select2">
                        <option value="">Select Package Type</option>
                        <option value="starter" {{ $info->serviceType == 'starter' ? 'selected' : '' }}>Starter
                        </option>
                        <option value="professional" {{ $info->serviceType == 'professional' ? 'selected' : '' }}>
                            Professional</option>
                        <option value="enterprise" {{ $info->serviceType == 'enterprise' ? 'selected' : '' }}>
                            Enterprise</option>
                    </select>
                </div>

                <div class="md:col-span-1">
                    <button type="button" onclick="getFilterData(true)"
                        class="px-3 py-2 md:px-5 md:py-[11px] text-sm bg-red-600 duration-500 hover:bg-red-700 text-white rounded">Reset</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Blog Table -->
    <div class="custom-data-table">
        <table id="dataTable">
            <thead>
                <tr>
                    <th>SL</th>

                    <th>Date</th>

                    <th>Service</th>

                    <th>Title</th>

                    <th>Type</th>

                    <th>Amount</th>

                    <th>Status</th>

                    <th class="!text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($info->results) && $info->results->isNotEmpty())
                @foreach ($info->results as $key => $row)
                <tr>
                    <th>{{ $info->results->firstItem() + $key }}</th>

                    <td>{{ $row->created }}</td>

                    <td>{{ $row->service->title }}</td>

                    <td>{{ $row->title }}</td>

                    <td>{{ strFilter($row->type) }}</td>

                    @if ($row->yearly > 0)
                    <td>{{ sprintf("$%0.2f", $row->yearly) }}</td>
                    @else
                    <td>{{ sprintf("$%0.2f", $row->monthly) }}</td>
                    @endif

                    <td>{{ $row->is_recommended == 1 ? 'Recommended' : '' }}</td>

                    <td>
                        <div class="flex items-center justify-end gap-1">
                            @if (canAccess(['package edit']))
                            <a href="{{ route('admin.package.edit', $row->id) }}" class="edit-action-btn">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                            @endif

                            @if (canAccess(['package destroy']))
                            <a href="{{ route('admin.package.destroy', $row->id) }}"
                                onclick="return confirm('Do you want to delete this data?')" class="delete-action-btn">
                                <i class="fa-regular fa-trash-can"></i>
                            </a>
                            @endif
                        </div>
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
    .custom-data-table .dt-scroll-body {
        min-height: 350px;
    }
</style>
@endpush

@push('footerPartial')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
<script>
    $(document).ready(function() {
            $('.select2').select2();

            $('#dataTable').DataTable({
                searching: false, // Disable searching
                ordering: false, // Disable ordering (sorting)
                paging: false, // Disable pagination
                info: false, // Hide "Showing 1 to 5 of 5 entries"
                scrollX: true // Enable horizontal scrolling if needed
            });
        });

        function getFilterData(reset = '') {
            let mainUrl = "{{ route('admin.package') }}";
            let getUrl = window.location.href;
            const [url, data] = getUrl.split('?');

            const serviceId = document.getElementById('serviceId').value;
            const serviceType = document.getElementById('serviceType').value;

            const filters = [{
                    value: serviceId,
                    paramName: 'service_id'
                },
                {
                    value: serviceType,
                    paramName: 'type'
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
                location.href = "{{ route('admin.package') }}";
            } else {
                location.href = mainUrl;
            }
        }
</script>
@endpush
