@extends('layouts.app')

@section('content')

<div>
    <!-- Pages Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">All Invoice</h3>

        @if (canAccess(['invoice create']))
        <a href="{{ route('admin.invoice.create') }}" class="panelHeaderBtn">
            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            Create Invoice
        </a>
        @endif
    </div>

    <!-- //new one  -->




    <div class="mb-4 px-4">
    @if (canAccess(['invoice grand total', 'invoice pending amount', 'invoice unpaid amount', 'invoice paid
    amount']))
        <div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-6 lg:gap-8 mt-5">
        @if (canAccess(['invoice grand total']))
        <div
                class="p-8  text-white flex flex-col gap-1 rounded overflow-hidden relative !bg-[#f0f9ff] dashboardCard">
                <span class="text-xl font-syne font-medium firstLetter before:!text-[#c4dae9] text-gray-700">Grand Total</span>
                <span class="text-3xl font-bold [letter-spacing:2px]  text-darkblue">{{ sprintf("$%0.2f",
                    $allInvoice->sum('grand_total')) }}</span>
            </div>
            @endif

            @if (canAccess(['invoice delete amount']))
            <div
                class="p-8 text-white flex flex-col gap-1 rounded overflow-hidden relative !bg-[#f7fee7] dashboardCard">
                <span class="text-xl font-syne font-medium firstLetter before:!text-[#d9e3c0] text-gray-700">Delete Amount</span>
                <span class="text-3xl font-bold [letter-spacing:2px] text-darkblue">{{ sprintf("$%0.2f",
                    $allInvoice->where('status', 'delete')->sum('grand_total')) }}</span>
            </div>
            @endif


            @if (canAccess(['invoice unpaid amount']))
            <div
                class="p-8  text-white flex flex-col gap1  rounded overflow-hidden relative !bg-[#ecfeff] dashboardCard">
                <span class="text-xl font-syne font-medium firstLetter before:!text-[#c9e0e1] text-gray-700">Unpaid Amount</span>
                <span class="text-3xl font-bold [letter-spacing:2px] text-darkblue">{{ sprintf("$%0.2f",
                    $allInvoice->where('status', 'unpaid')->sum('grand_total')) }}</span>
            </div>
            @endif

            @if (canAccess(['invoice paid amount']))
            <div
                class="p-8  text-white flex flex-col gap1  rounded overflow-hidden relative !bg-[#ebf5ff] dashboardCard">
                <span class="text-xl font-syne font-medium firstLetter before:!text-[#c4d2e0]  text-gray-700">Paid Amount</span>
                <span class="text-3xl font-bold [letter-spacing:2px] text-darkblue">{{ sprintf("$%0.2f",
                    $allInvoice->where('status', 'paid')->sum('grand_total')) }}</span>
            </div>
            @endif
        </div>
        @endif



        <div class="relative overflow-hidden shadow-sm border rounded mt-5 p-5">
            <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-3">
                <div>
                    <select name="invoice_email" id="invoiceEmail" onchange="getFilterData()" class="inputField select2"
                        style="width: 100% !important">
                        <option value="">Select Invoice Email</option>
                        @if (!empty($invoiceInfo))
                        @foreach ($invoiceInfo as $key => $invoice)
                        <option value="{{ $invoice->email }}" {{ $invoice->email == $info->invoiceEmail ? 'selected' :
                            '' }}>
                            {{ $invoice->email }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <div id="custom_date_range">
                    <input type="text" name="date_range" id="dateRange" value="{{ $info->date_range }}"
                        placeholder="Custom Date Range" class="inputField !bg-white" />
                </div>

                <div>
                    <select name="user_id" id="userId" onchange="getFilterData()" class="inputField select2"
                        style="width: 100% !important">
                        <option value="">Select Admin</option>
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
                        style="width: 100% !important">
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

    @if (!empty($info->results) && $info->results->isNotEmpty())
    <div class="custom-data-table">
        <table id="dataTable">
            <thead>
                <tr>
                    <th>Invoice No</th>

                    <th>Method</th>

                    <th>Email</th>

                    <th>Amount</th>

                    <th>Status</th>

                    <th>Created At</th>

                    <th>Updated At</th>

                    <th>Paid Date</th>

                    <th>User Info</th>

                    <th>Is Send?</th>

                    <th>Is Warning?</th>

                    <th>Is Remove?</th>

                    <th>Link</th>

                    <th class="text-right">Action</th>
                </tr>

            </thead>
            <tbody>
                @php($allAmount = 0)
                @foreach ($info->results as $key => $row)
                @php($allAmount += $row->grand_total)
                <tr>
                    <td>#{{ $row->invoice_no }}</td>

                    <td>{{ !empty($row->method->name) ? $row->method->name : '' }}</td>

                    <td>
                        <div class="w-[120px] overflow-hidden [word-break:break-all]">
                            {{ $row->email }}
                        </div>
                    </td>

                    <td>{{ sprintf("$%0.2f", $row->grand_total) }}</td>

                    <td>
                        @if ($row->status == 'pending')
                        <span class="badge badge-premium mb-2">{{ strFilter($row->status) }}</span>
                        @elseif($row->status == 'unpaid')
                        <span class="badge badge-warning mb-2">{{ strFilter($row->status) }}</span>
                        @elseif($row->status == 'delete')
                        <span class="badge badge-danger mb-2">{{ strFilter($row->status) }}</span>
                        @else
                        <span class="badge badge-success mb-2">{{ strFilter($row->status) }}</span>
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

                    <td>{{ !empty($row->admin->name) ? $row->admin->name : '' }}</td>

                    <td>
                        @if ($row->is_send > 0)
                        <span class="badge badge-success mb-2">{{ $row->is_send }}</span>
                        @else
                        <span class="badge badge-danger mb-2">No</span>
                        @endif
                    </td>

                    <td>
                        @if ($row->is_warning > 0)
                        <span class="badge badge-success mb-2">{{ $row->is_warning }}</span>
                        @else
                        <span class="badge badge-danger mb-2">No</span>
                        @endif
                    </td>

                    <td>
                        @if ($row->is_remove > 0)
                        <span class="badge badge-success mb-2">{{ $row->is_remove }}</span>
                        @else
                        <span class="badge badge-danger mb-2">No</span>
                        @endif
                    </td>

                    <td class="whitespace-nowrap">
                        <input type="hidden" value="{{ url('invoice', $row->ref_code) }}" id="copyUrl{{ $row->id }}">

                        <a onclick="copyText({{ $row->id }})" onmouseout="outFunc({{ $row->id }})"
                            data-id="{{ $row->id }}" tooltip tooltip-place="left" data-tooltip="Copy Link"
                            class="py-2 px-3 rounded duration-300  bg-green-600/20 text-green-600 cursor-pointer hover:bg-green-600 hover:text-white gap-4">
                            Copy
                        </a>
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

                                <div class="mb-2">
                                    <ul class="text-md text-gray-700 flex flex-col gap-1 border-gray-200"
                                        aria-labelledby="dropdownLeftEndButton_{{ $row->id }}">

                                        @if (canAccess(['invoice send mail']))
                                        <li>
                                            <a href="{{ route('admin.invoice.send-mail', $row->id) }}"
                                                class="py-2 px-3 duration-300 flex items-center hover:bg-green-600 hover:text-white gap-4">
                                                <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                    viewBox="0 0 24 24" height="1em" width="1em"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                                    <path
                                                        d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V8l8 5 8-5v10zm-8-7L4 6h16l-8 5z">
                                                    </path>
                                                </svg>
                                                Send Mail
                                            </a>
                                        </li>
                                        @endif

                                        @if (canAccess(['invoice warning mail']))
                                        <li>
                                            <a href="{{ route('admin.invoice.warning-mail', $row->id) }}"
                                                class="py-2 px-3 duration-300 flex items-center hover:bg-blue-600 hover:text-white gap-4">
                                                <svg stroke="currentColor" fill="none" stroke-width="2"
                                                    viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"
                                                    height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M22 10.5V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h12.5">
                                                    </path>
                                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7">
                                                    </path>
                                                    <path d="M20 14v4"></path>
                                                    <path d="M20 22v.01"></path>
                                                </svg>
                                                Warning Mail
                                            </a>
                                        </li>
                                        @endif

                                        @if (canAccess(['invoice remove mail']))
                                        <li>
                                            <a href="{{ route('admin.invoice.remove-mail', $row->id) }}"
                                                class="py-2 px-3 duration-300 flex items-center hover:bg-orange-600 hover:text-white gap-4">
                                                <svg stroke="currentColor" fill="none" stroke-width="2"
                                                    viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"
                                                    height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h9">
                                                    </path>
                                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7">
                                                    </path>
                                                    <path d="m17 17 4 4"></path>
                                                    <path d="m21 17-4 4"></path>
                                                </svg>
                                                Remove Mail
                                            </a>
                                        </li>
                                        @endif

                                    </ul>
                                </div>

                                <ul class="text-md text-gray-700 flex flex-col gap-1"
                                    aria-labelledby="dropdownLeftEndButton_{{ $row->id }}">
                                    @if (canAccess(['invoice show']))
                                    <li>
                                        <a href="{{ route('admin.invoice.show', $row->ref_code) }}" target="_blank"
                                            class="py-2 px-3 rounded duration-300 flex items-center hover:bg-blue-600 hover:text-white gap-4">
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

                                    @if ($row->status != 'paid')
                                    @if (canAccess(['invoice edit']))
                                    <li>
                                        <a href="{{ route('admin.invoice.edit', $row->id) }}" target="_blank"
                                            class="py-2 px-3 rounded duration-300 flex items-center hover:bg-purple-600 hover:text-white gap-4">
                                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"
                                                stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                </path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                </path>
                                            </svg>
                                            Edit Invoice
                                        </a>
                                    </li>
                                    @endif
                                    @endif

                                    @if (canAccess(['invoice download']))
                                    <li>
                                        <a href="{{ url('download-invoice', $row->ref_code) }}" target="_blank"
                                            class="py-2 px-3 rounded duration-300 flex items-center hover:bg-indigo-600 hover:text-white gap-4">
                                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"
                                                stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                <polyline points="7 10 12 15 17 10"></polyline>
                                                <line x1="12" y1="15" x2="12" y2="3"></line>
                                            </svg>
                                            Download PDF
                                        </a>
                                    </li>
                                    @endif

                                    @if ($row->status != 'delete')
                                    @if (canAccess(['invoice delete']))
                                    <li>
                                        <a href="{{ route('admin.invoice.delete', $row->id) }}"
                                            onclick="return confirm('Do you want to delete this data?')"
                                            class="py-2 px-3 rounded duration-300 flex items-center bg-orange-600/20 text-orange-600 hover:bg-orange-600 hover:text-white gap-4">
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
                                    @if (canAccess(['invoice restore']))
                                    <li class="whitespace-nowrap">
                                        <a href="{{ route('admin.invoice.restore', $row->id) }}"
                                            onclick="return confirm('Do you want to restore this data?')"
                                            class="py-2 px-3 duration-300 flex items-center bg-indigo-600/20 text-indigo-600 hover:bg-indigo-600 hover:text-white gap-3">
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
                                    @endif

                                    @if (canAccess(['invoice destroy']))
                                    <li>
                                        <a href="{{ route('admin.invoice.destroy', $row->id) }}"
                                            onclick="return confirm('Do you want to delete permanently this data?')"
                                            class="py-2 px-3 rounded duration-300 flex items-center bg-red-600/20 text-red-600 hover:bg-red-600 hover:text-white gap-4">
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
                                </ul>
                            </div>
                        </div>
                    </td>

                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="total"> Total </th>
                    <th class="amount">{{ sprintf("$%0.2f", $allAmount) }}</th>
                    <th colspan="10"> &nbsp; </th>
                </tr>
            </tfoot>
        </table>

        <!-- Display pagination links -->
        {{ $info->results->links() }}
    </div>
    @endif
</div>

@endsection

@push('headerPartial')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.dataTables.css">
<link rel="stylesheet" href="{{ asset('public/css/custom-data-table.css') }}">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .custom-data-table .dt-scroll-body {
        min-height: 350px
    }

    .custom-data-table table tfoot tr th.total {
        text-align: right !important;
    }

    .custom-data-table table tfoot tr th.amount {
        text-align: center !important;
    }

    .firstLetter::before {
        content: attr(data-capitalized-text);
        font-weight: bold;
        color: #eeeeee29;
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
                paging: false, // Disable pagination
                ordering: false, // Disable ordering (sorting)
                info: false, // Hide "Showing 1 to 5 of 5 entries"
                scrollX: true, // Enable horizontal scrolling if needed
                "aaSorting": []
            });
        });

        function copyText(rowId) {
            var linkElement = document.querySelector(`a[data-tooltip="Copy Link"][data-id="${rowId}"]`);
            linkElement.setAttribute('data-tooltip', 'Copying...');

            var copyText = document.getElementById("copyUrl" + rowId).value;
            if (navigator.clipboard) {
                navigator.clipboard.writeText(copyText)
                    .then(function() {
                        linkElement.setAttribute('data-tooltip', 'Copied');
                    })
                    .catch(function(err) {
                        console.error('Failed to copy text: ', err);
                        linkElement.setAttribute('data-tooltip', 'Copy failed');
                    });
            } else {
                var textarea = document.createElement('textarea');
                textarea.value = copyText;
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);
                linkElement.setAttribute('data-tooltip', 'Copied');
            }
        }

        function outFunc(rowId) {
            var linkElement = document.querySelector(`a[data-tooltip="Copied"][data-id="${rowId}"]`);
            if (linkElement) {
                linkElement.setAttribute('data-tooltip', 'Copy Link');
            }
        }

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
            let mainUrl = "{{ route('admin.invoice') }}";
            let getUrl = window.location.href;
            const [url, data] = getUrl.split('?');

            const invoiceEmail = document.getElementById('invoiceEmail').value;

            const dateRange = document.getElementById('dateRange').value;

            const userId = document.getElementById('userId').value;

            const status = document.getElementById('status').value;

            const filters = [{
                    value: invoiceEmail,
                    paramName: 'email'
                },
                {
                    value: dateRange,
                    paramName: 'date_range'
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

            let queryParams = filters
                .filter(filter => filter.value && filter.value !== 'all')
                .map(filter => filter.paramName + '=' + filter.value)
                .join('&');
            if (queryParams) {
                mainUrl += '?' + queryParams;
            }

            if (reset) {
                location.href = "{{ route('admin.invoice') }}";
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
