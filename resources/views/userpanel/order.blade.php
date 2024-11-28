@extends('layouts.app')

@section('content')

<div>
    <!-- Pages Header -->
    <div class="flex items-center justify-between bg-gray-50 p-5 border-b rounded">
        <h3 class="text-3xl font-semibold">All Order</h3>
    </div>

    <div class="mb-4 px-4">

        {{-- <div class="flex items-center justify-between bg-gray-50 p-4 border-b rounded">
            <h3 class="text-xl font-semibold">Search Order</h3>
        </div> --}}
        <div class="relative  shadow-sm border rounded mt-5 p-5">
            <form action="{{ route('user.order') }}" method="POST">
                @csrf
                <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-3">

                    <div class="md:col-span-2">
                        <select name="search[id]" class="inputField">
                            <option value="">Select Order</option>
                            @if (!empty($orderInfo))
                            @foreach ($orderInfo as $key => $order)
                            <option value="{{ $order->id }}">{{ '#' . $order->order_no . ' | ' . $order->name . ' | ' .
                                $order->email }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="md:col-span-1">
                        <input type="date" name="date_from" placeholder="Date From" class="inputField" />
                    </div>

                    <div class="md:col-span-1">
                        <input type="date" name="date_to" placeholder="Date To" class="inputField" />
                    </div>

                    <div class="md:col-span-1">
                        <select name="search[billing_type]" class="inputField">
                            <option value="">Select Billing Type</option>
                            @if (!empty($billingType))
                            @foreach ($billingType as $row => $billing)
                            <option value="{{ $billing->id }}">{{ strFilter($billing->name) }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="md:col-span-1">
                        <select name="search[user_id]" class="inputField">
                            <option value="">Select Admin</option>
                            @if (!empty($admin))
                            @foreach ($admin as $row => $user)
                            <option value="{{ $user->id }}">{{ strFilter($user->name) }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="md:col-span-1">
                        <select name="search[status]" class="inputField">
                            <option value="">Select Status</option>
                            <option value="pending">Pending</option>
                            <option value="unpaid">Unpaid</option>
                            <option value="paid">Paid</option>
                        </select>
                    </div>

                    <div class="md:col-span-1">
                        <select name="search[email_from_id]" class="inputField">
                            <option value="">Select Mail From</option>
                            @if (!empty($emailList))
                            @foreach ($emailList as $row => $email)
                            <option value="{{ $email->id }}">{{ strFilter($email->name) }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="w-full flex justify-end mt-4">
                    <button type="submit" class="primary-btn text-center">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                            height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M337.509 305.372h-17.501l-6.571-5.486c20.791-25.232 33.922-57.054 33.922-93.257C347.358 127.632 283.896 64 205.135 64 127.452 64 64 127.632 64 206.629s63.452 142.628 142.225 142.628c35.011 0 67.831-13.167 92.991-34.008l6.561 5.487v17.551L415.18 448 448 415.086 337.509 305.372zm-131.284 0c-54.702 0-98.463-43.887-98.463-98.743 0-54.858 43.761-98.742 98.463-98.742 54.7 0 98.462 43.884 98.462 98.742 0 54.856-43.762 98.743-98.462 98.743z">
                            </path>
                        </svg>
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Blog Table -->
    <div class="custom-data-table">
        <table id="dataTable">
            <thead>
                <tr>
                    <th>Order No</th>

                    <th>Billing Type</th>

                    <th>Email</th>

                    <th>Amount</th>

                    <th>Status</th>

                    <th>Created At</th>

                    <th>Updated At</th>

                    <th>Paid Date</th>

                    <th>Order From</th>

                    <th>User</th>

                    <th>Is Invoice?</th>

                    <th>Is Prepaid?</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($results) && $results->isNotEmpty())
                @foreach ($results as $key => $row)
                <tr>
                    <td>#{{ $row->order_no }}</td>

                    <td class="whitespace-nowrap">
                        @php($billingInfo = $billingType->where('id', $row->billing_type)->first())
                        @if (!empty($billingInfo->name))
                        {{ strFilter($billingInfo->name) }}
                        @endif
                    </td>

                    <td>{{ $row->email }}</td>

                    <td class="text-center">${{ round($row->grand_total, 2) }}</td>

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
                        {{ !empty($row->created) ? date('M d, Y', strtotime($row->created)) : '' }}
                    </td>

                    <td class="whitespace-nowrap">
                        {{ !empty($row->updated) ? date('M d, Y', strtotime($row->updated)) : '' }}
                    </td>

                    <td class="whitespace-nowrap">
                        {{ !empty($row->payment_date) ? date('M d, Y', strtotime($row->payment_date)) : '' }}
                    </td>

                    <td>
                        <span class="badge badge-success mb-2">
                            {{ !empty($row->emailFrom->name) ? strFilter($row->emailFrom->name) : '' }}</span>
                    </td>

                    <td>
                        <span>{{ $row->admin->name }}</span>
                    </td>

                    <td>
                        @if ($row->is_invoice)
                        <span class="badge badge-success mb-2">Yes</span>
                        @else
                        <span class="badge badge-danger mb-2">No</span>
                        @endif
                    </td>

                    <td>
                        @if ($row->prepaid_status == 'completed')
                        <span class="badge badge-success mb-2">{{ $row->prepaid_status }}</span>
                        @elseif($row->prepaid_status == 'prepaid')
                        <span class="badge badge-warning mb-2">{{ $row->prepaid_status }}</span>
                        @else
                        &nbsp;
                        @endif
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection
@push('headerPartial')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.dataTables.css">
<link rel="stylesheet" href="{{ asset('public/css/custom-data-table.css') }}">
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
@endpush
@push('footerPartial')
<script>
    new DataTable('#dataTable', {
        scrollX: true,
        // Disable sorting
        "sort": false
    });
</script>
@endpush