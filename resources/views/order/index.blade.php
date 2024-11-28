@extends('layouts.app')

@section('content')

<div>
    <!-- Pages Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">All Order</h3>
        @if (canAccess(['order create']))
        <a href="{{ route('admin.order.create') }}" class="panelHeaderBtn">
            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            Create Order
        </a>
        @endif
    </div>

    <div class="mb-4 px-4">
        @if (canAccess(['order grand total', 'order pending amount', 'order unpaid amount', 'order paid amount']))
        <div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-6 lg:gap-8 mt-5">
            @if (canAccess(['order grand total']))
            <div
                class="p-8  text-white flex flex-col gap-1 rounded overflow-hidden relative !bg-[#f0f9ff] dashboardCard">
                <span class="text-xl font-syne font-medium firstLetter before:!text-[#c4dae9] text-gray-700">Grand Total</span>
                <span class="text-3xl font-bold [letter-spacing:2px]  text-darkblue">{{ sprintf("$%0.2f",
                    $allOrder->sum('grand_total')) }}</span>
            </div>
            @endif

            @if (canAccess(['order pending amount']))
            <div
                class="p-8 text-white flex flex-col gap-1 rounded overflow-hidden relative !bg-[#f7fee7] dashboardCard">
                <span class="text-xl font-syne font-medium firstLetter before:!text-[#d9e3c0] text-gray-700">Pending Amount</span>
                <span class="text-3xl font-bold [letter-spacing:2px] text-darkblue">{{ sprintf("$%0.2f", $allOrder->where('status',
                    'pending')->sum('grand_total')) }}</span>
            </div>
            @endif

            @if (canAccess(['order unpaid amount']))
            <div
                class="p-8  text-white flex flex-col gap1  rounded overflow-hidden relative !bg-[#ecfeff] dashboardCard">
                <span class="text-xl font-syne font-medium firstLetter before:!text-[#c9e0e1] text-gray-700">Unpaid Amount</span>
                <span class="text-3xl font-bold [letter-spacing:2px] text-darkblue">{{ sprintf("$%0.2f", $allOrder->where('status',
                    'unpaid')->sum('grand_total')) }}</span>
            </div>
            @endif

            @if (canAccess(['order paid amount']))
            <div
                class="p-8  text-white flex flex-col gap1  rounded overflow-hidden relative !bg-[#ebf5ff] dashboardCard">
                <span class="text-xl font-syne font-medium firstLetter before:!text-[#c4d2e0]  text-gray-700">Paid Amount</span>
                <span class="text-3xl font-bold [letter-spacing:2px] text-darkblue">{{ sprintf("$%0.2f", $allOrder->where('status',
                    'paid')->sum('grand_total')) }}</span>
            </div>
            @endif
        </div>
        @endif

        <div class="relative shadow-sm border rounded mt-5 p-5">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-3">
                <select name="order_email" id="orderEmail" onchange="getFilterData()" class="inputField select2"
                    style="width: 100% !important">
                    <option value="">Select Order</option>
                    @if (!empty($orderInfo))
                    @foreach ($orderInfo as $key => $order)
                    <option value="{{ $order->email }}" {{ $info->orderEmail == $order->email ? 'selected' : '' }}>
                        {{ $order->email }}
                    </option>
                    @endforeach
                    @endif
                </select>

                <div class="md:col-span-1" id="custom_date_range">
                    <input type="text" name="date_range" id="dateRange" value="{{ $info->date_range }}"
                        placeholder="Custom Date Range" class="inputField !bg-white" />
                </div>

                <select name="billing_type" id="billingType" onchange="getFilterData()" class="inputField select2"
                    style="width: 100% !important">
                    <option value="">Select Billing Type</option>
                    @if (!empty($billingType))
                    @foreach ($billingType as $row => $billing)
                    <option value="{{ $billing->id }}" {{ $info->billingType == $billing->id ? 'selected' : '' }}>
                        {{ strFilter($billing->name) }}</option>
                    @endforeach
                    @endif
                </select>

                <select name="user_id" id="userId" onchange="getFilterData()" class="inputField select2"
                    style="width: 100% !important">
                    <option value="">Select User</option>
                    @if (!empty($admin))
                    @foreach ($admin as $row => $user)
                    <option value="{{ $user->id }}" {{ $info->userId == $user->id ? 'selected' : '' }}>
                        {{ strFilter($user->name) }}
                    </option>
                    @endforeach
                    @endif
                </select>

                <select name="status" id="status" onchange="getFilterData()" class="inputField select2"
                    style="width: 100% !important">
                    <option value="">Select Status</option>
                    <option value="pending" {{ $info->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="unpaid" {{ $info->status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    <option value="paid" {{ $info->status == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="delete" {{ $info->status == 'delete' ? 'selected' : '' }}>Delete</option>
                </select>

                <select name="email_from_id" id="emailFromId" onchange="getFilterData()" class="inputField select2"
                    style="width: 100% !important">
                    <option value="">Select Mail From</option>
                    @if (!empty($emailList))
                    @foreach ($emailList as $row => $email)
                    <option value="{{ $email->id }}" {{ $info->emailFromId == $email->id ? 'selected' : '' }}>
                        {{ strFilter($email->name) }}</option>
                    @endforeach
                    @endif
                </select>

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
                        Order No
                    </th>

                    <th>
                        Billing Type
                    </th>

                    <th>
                        Email
                    </th>

                    <th>
                        Amount
                    </th>

                    <th>
                        Status
                    </th>

                    <th>
                        Created At
                    </th>

                    <th>
                        Updated At
                    </th>

                    <th>
                        Paid Date
                    </th>

                    <th>
                        Order From
                    </th>

                    <th>
                        User
                    </th>

                    <th>
                        Is Prepaid?
                    </th>

                    <th class="text-right w-[60px]">
                        Action
                    </th>
                </tr>

            </thead>
            <tbody>
                @php($allAmount = 0)
                @if (!empty($info->results))
                @foreach ($info->results as $key => $row)
                @php($allAmount += $row->grand_total)
                <tr>
                    <td>#{{ $row->order_no }}</td>

                    <td>
                        <div class="w-[150px]">
                            @php($billingInfo = $billingType->where('id', $row->billing_type)->first())

                            @if (!empty($billingInfo->name))
                            {{ strFilter($billingInfo->name) }}
                            @endif
                        </div>
                    </td>

                    <td>
                        <div class="w-[150px] overflow-hidden [word-break:break-all]">
                            {{ $row->email }}
                        </div>
                    </td>

                    <td class="text-center">{{ sprintf("$%0.2f", $row->grand_total) }}</td>

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

                    <td class="whitespace-nowrap">
                        {{ !empty($row->created) ? date('d F, Y', strtotime($row->created)) : '' }}
                    </td>

                    <td class="whitespace-nowrap">
                        {{ !empty($row->updated) ? date('d F, Y', strtotime($row->updated)) : '' }}
                    </td>

                    <td class="whitespace-nowrap">
                        {{ !empty($row->payment_date) ? date('d F, Y', strtotime($row->payment_date)) : '' }}
                    </td>

                    <td>
                        <span class="badge badge-success mb-2">
                            {{ !empty($row->emailFrom->name) ? strFilter($row->emailFrom->name) : '' }}
                        </span>
                    </td>

                    <td>
                        <span> {{ $row->admin->name }}</span>
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
                        <div class="flex items-center justify-end gap-1">

                            <button id="dropdownLeftEndButton_{{ $row->id }}"
                                data-dropdown-toggle="dropdownLeftEnd_{{ $row->id }}"
                                data-dropdown-placement="left-start"
                                class="me-3 mb-3 md:mb-0 font-medium rounded-lg text-sm py-2.5 text-center inline-flex items-center"
                                type="button">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 4 15">
                                    <path
                                        d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div id="dropdownLeftEnd_{{ $row->id }}"
                                class="z-20 hidden bg-white divide-y p-2 divide-gray-100 rounded-lg shadow min-w-48 max-w-fit">

                                <ul class="text-md text-gray-700 flex flex-col gap-1"
                                    aria-labelledby="dropdownLeftEndButton_{{ $row->id }}">
                                    @if (canAccess(['order show']))
                                    <li class="whitespace-nowrap">
                                        <a href="{{ route('admin.order.invoice', $row->id) }}" target="_blank"
                                            class="py-2 px-3 duration-300 flex items-center hover:bg-blue-600 hover:text-white gap-3">
                                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"
                                                stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z">
                                                </path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                            Show Invoice
                                        </a>
                                    </li>
                                    @endif

                                    @if (canAccess(['order generate invoice']))
                                    <li class="whitespace-nowrap">
                                        <a href="{{ route('admin.invoice.create', 'email=' . $row->email) }}"
                                            target="_blank"
                                            class="py-2 px-3 duration-300 flex items-center hover:bg-indigo-600 hover:text-white gap-3">
                                            <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                viewBox="0 0 32 32" height="1em" width="1em"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M 6 3 L 6 29 L 26 29 L 26 9.5996094 L 25.699219 9.3007812 L 19.699219 3.3007812 L 19.400391 3 L 6 3 z M 8 5 L 18 5 L 18 11 L 24 11 L 24 27 L 8 27 L 8 5 z M 20 6.4003906 L 22.599609 9 L 20 9 L 20 6.4003906 z M 10 13 L 10 15 L 22 15 L 22 13 L 10 13 z M 10 18 L 10 20 L 17 20 L 17 18 L 10 18 z M 19 18 L 19 20 L 22 20 L 22 18 L 19 18 z M 10 22 L 10 24 L 17 24 L 17 22 L 10 22 z M 19 22 L 19 24 L 22 24 L 22 22 L 19 22 z">
                                                </path>
                                            </svg>
                                            Genarete Invoice
                                        </a>
                                    </li>
                                    @endif

                                    @if ($row->status != 'paid')
                                    @if (canAccess(['order edit']))
                                    <li class="whitespace-nowrap">
                                        <a href="{{ route('admin.order.edit', $row->id) }}"
                                            class="py-2 px-3 duration-300 flex items-center hover:bg-green-600 hover:text-white gap-3">
                                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"
                                                stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                </path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                </path>
                                            </svg>
                                            Edit Order
                                        </a>
                                    </li>
                                    @endif
                                    @endif

                                    @if ($row->prepaid_status == 'prepaid')
                                    @if (canAccess(['order change payment status']))
                                    <li class="whitespace-nowrap">
                                        <a href="{{ route('admin.order.change-prepaid', $row->id) }}"
                                            onclick="return confirm('Do you want to change prepayment status prepaid to Complete ?')"
                                            class="py-2 px-3 duration-300 flex items-center hover:bg-indigo-600 hover:text-white gap-3">
                                            <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                viewBox="0 0 32 32" height="1em" width="1em"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M 22.1875 2.28125 L 20.78125 3.71875 L 25.0625 8 L 4 8 L 4 10 L 25.0625 10 L 20.78125 14.28125 L 22.1875 15.71875 L 28.90625 9 Z M 9.8125 16.28125 L 3.09375 23 L 9.8125 29.71875 L 11.21875 28.28125 L 6.9375 24 L 28 24 L 28 22 L 6.9375 22 L 11.21875 17.71875 Z">
                                                </path>
                                            </svg>
                                            Change Prepayment Status
                                        </a>
                                    </li>
                                    @endif
                                    @endif

                                    @if ($row->status == 'unpaid')
                                    @if ($row->status != 'delete')
                                    @if (canAccess(['order delete']))
                                    <li class="whitespace-nowrap">
                                        <a href="{{ route('admin.order.delete', $row->id) }}"
                                            onclick="return confirm('Do you want to delete this data?')"
                                            class="py-2 px-3 duration-300 flex items-center bg-orange-600/20 text-orange-600 hover:bg-orange-600 hover:text-white gap-3">
                                            <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                viewBox="0 0 512 512" height="1em" width="1em"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="32"
                                                    d="m112 112 20 320c.95 18.49 14.4 32 32 32h184c17.67 0 30.87-13.51 32-32l20-320">
                                                </path>
                                                <path stroke-linecap="round" stroke-miterlimit="10" stroke-width="32"
                                                    d="M80 112h352"></path>
                                                <path fill="none" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="32"
                                                    d="M192 112V72h0a23.93 23.93 0 0 1 24-24h80a23.93 23.93 0 0 1 24 24h0v40m-64 64v224m-72-224 8 224m136-224-8 224">
                                                </path>
                                            </svg>
                                            Delete
                                        </a>
                                    </li>
                                    @endif
                                    @endif

                                    @if ($row->status == 'delete')
                                    @if (canAccess(['order restore']))
                                    <li class="whitespace-nowrap">
                                        <a href="{{ route('admin.order.restore', $row->id) }}"
                                            onclick="return confirm('Do you want to restore this data?')"
                                            class="py-2 px-3 duration-300 flex items-center bg-orange-600/20 text-orange-600 hover:bg-orange-600 hover:text-white gap-3">
                                            <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                viewBox="0 0 32 32" height="1em" width="1em"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M 14 4 C 13.477 4 12.9415 4.1835 12.5625 4.5625 C 12.1845 4.9405 12 5.477 12 6 L 12 7 L 5 7 L 5 9 L 6.09375 9 L 8 27.09375 L 8.09375 28 L 23.90625 28 L 24 27.09375 L 25.90625 9 L 27 9 L 27 7 L 20 7 L 20 6 C 20 5.477 19.8165 4.9415 19.4375 4.5625 C 19.0595 4.1845 18.523 4 18 4 L 14 4 z M 14 6 L 18 6 L 18 7 L 14 7 L 14 6 z M 8.125 9 L 23.875 9 L 22.09375 26 L 9.90625 26 L 8.125 9 z M 16 12 L 12 16 L 15 16 L 15 23 L 17 23 L 17 16 L 20 16 L 16 12 z">
                                                </path>
                                            </svg>
                                            Restore
                                        </a>
                                    </li>
                                    @endif

                                    @if (!$row->si_payment)
                                    @if (canAccess(['order republished']))
                                    <li class="whitespace-nowrap">
                                        <a href="{{ route('admin.order.published', $row->id) }}"
                                            class="py-2 px-3 duration-300 flex items-center hover:bg-blue-600 hover:text-white gap-3">
                                            <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                viewBox="0 0 24 24" height="1em" width="1em"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill="none" d="M0 0h24v24H0V0z"></path>
                                                <path
                                                    d="M5 4h14v2H5zm0 10h4v6h6v-6h4l-7-7-7 7zm8-2v6h-2v-6H9.83L12 9.83 14.17 12H13z">
                                                </path>
                                            </svg>
                                            Order Republished
                                        </a>
                                    </li>
                                    @endif
                                    @endif
                                    @endif


                                    @if (canAccess(['order destroy']))
                                    <li class="whitespace-nowrap">
                                        <a href="{{ route('admin.order.destroy', $row->id) }}"
                                            onclick="return confirm('Do you want to delete permanently this data?')"
                                            class="py-2 px-3 duration-300 flex items-center bg-red-600/20 text-red-600 hover:bg-red-600 hover:text-white gap-3">
                                            <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                viewBox="0 0 24 24" height="1em" width="1em"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill="none" d="M0 0h24v24H0z"></path>
                                                <path
                                                    d="M16.5 10V9h-2v1H12v1.5h1v4c0 .83.67 1.5 1.5 1.5h2c.83 0 1.5-.67 1.5-1.5v-4h1V10h-2.5zm0 5.5h-2v-4h2v4zM20 6h-8l-2-2H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm0 12H4V6h5.17l2 2H20v10z">
                                                </path>
                                            </svg>
                                            Delete Permanently
                                        </a>
                                    </li>
                                    @endif
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </td>

                </tr>
                @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="total"> Total </th>
                    <th class="amount">{{ sprintf("$%0.2f", $allAmount) }}</th>
                    <th colspan="8"> &nbsp; </th>
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
    .custom-data-table table tfoot tr th.total {
        text-align: right !important;
    }

    .custom-data-table table tfoot tr th.amount {
        text-align: center !important;
    }

    .firstLetter::before {
        content: attr(data-capitalized-text);
        font-weight: bold;
        color: #f788208a;
        position: absolute;
        right: 25px;
        bottom: 25px;
        font-size: 55px;
    }
</style>
@endpush
@push('footerPartial')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>

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
                //scrollX: true, // Enable horizontal scrolling if needed
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
            let mainUrl = "{{ route('admin.order') }}";
            let getUrl = window.location.href;
            const [url, data] = getUrl.split('?');

            const orderEmail = document.getElementById('orderEmail').value;

            const dateRange = document.getElementById('dateRange').value;

            const billingType = document.getElementById('billingType').value;

            const userId = document.getElementById('userId').value;

            const status = document.getElementById('status').value;

            const emailFromId = document.getElementById('emailFromId').value;

            const filters = [{
                    value: orderEmail,
                    paramName: 'email'
                },
                {
                    value: dateRange,
                    paramName: 'date_range'
                },
                {
                    value: billingType,
                    paramName: 'billing_type'
                },
                {
                    value: userId,
                    paramName: 'user_id'
                },
                {
                    value: status,
                    paramName: 'status'
                },
                {
                    value: emailFromId,
                    paramName: 'email_from_id'
                }
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
                location.href = "{{ route('admin.order') }}";
            } else {
                location.href = mainUrl;
            }
        }
        document.addEventListener('DOMContentLoaded', () => {
            const spanElements = document.querySelectorAll('.firstLetter');
            spanElements.forEach(spanElement => {
                let textContent = spanElement.textContent.trim();
                let firstLetter = textContent.charAt(0).toUpperCase();

                spanElement.setAttribute('data-capitalized-text', firstLetter);
            });
        });
</script>
@endpush