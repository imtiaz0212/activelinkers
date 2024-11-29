@extends('layouts.app')

@section('content')

<div>
    <div class="panelHeader">
        <h3 class=" panelHeaderTitle">Coupon List</h3>

        @if (canAccess(['coupon create']))
        <a data-modal-target="default-modal" data-modal-toggle="default-modal" href="#" class="button">
            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            Create Coupon
        </a>
        @endif
    </div>

    <!-- Coupon Table -->
    <div class="custom-data-table">
        <table id="dataTable">
            <thead>
                <tr>
                    <th class="w-[100px]">SL</th>
                    <th>Code</th>
                    <th>Type</th>
                    <th>Discount</th>
                    <th>Status</th>
                    @if (canAccess(['coupon delete', 'coupon edit']))
                    <th class="!text-right w-[200px]">Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if (!empty($results))
                @foreach ($results as $key => $row)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $row->code }}</td>
                    <td>{{ strFilter($row->type) }}</td>
                    <td>
                        {{$row->type == 'fixed' ? '$' : ''}}{{ $row->discount }}{{$row->type == 'percentage' ? '%' :
                        ''}}
                    </td>
                    <td>
                        <span
                            class="px-2.5 text-sm py-0.5 font-semibold rounded-full inline-block {{$row->status == 'disable' ? 'bg-error/20 text-error' : 'bg-success/20 text-success'}}">
                            {{ strFilter($row->status) }}
                        </span>
                    </td>

                    @if (canAccess(['coupon delete', 'coupon edit']))
                    <td>
                        <div class="flex items-center justify-end gap-1">
                            @if (canAccess(['coupon edit']))
                            <a data-modal-target="edit-modal" onclick="editModal('{{ $row->id }}');"
                                data-modal-toggle="edit-modal" class="edit-action-btn">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                            @endif

                            @if (canAccess(['coupon delete']))
                            <a href="{{ route('admin.coupon.destroy', $row->id) }}"
                                onclick="return confirm('Do you want to delete this coupon?')"
                                class="delete-action-btn">
                                <i class="fa-regular fa-trash-can"></i>
                            </a>
                            @endif
                        </div>
                    </td>
                    @endif
                </tr>
                @endforeach
                @endif

            </tbody>
        </table>
    </div>
</div>



<!-- Main modal -->
<div id="default-modal" tabindex="-1" aria-hidden="true"
    class="hidden bg-black/70 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[99999999999] justify-center items-center w-full md:inset-0 h-full max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <form action="{{ route('admin.coupon.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Create Coupon
                    </h3>

                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="default-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="grid grid-cols-2 gap-4 p-4 md:p-5">
                    <div class="flex flex-col gap-1.5">
                        <label for="code" class="inputLabel">Code</label>
                        <input type="text" id="code" name="code" placeholder="Code" class="inputField" required />
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label for="discount" class="inputLabel">Discount</label>
                        <input type="number" step="0.01" id="discount" name="discount" placeholder="Discount amount"
                            class="inputField" required />
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label for="type" class="inputLabel">Type</label>
                        <select name="type" id="type" class="inputField" required>
                            <option value="percentage">Percentage</option>
                            <option value="fixed">Fixed</option>
                        </select>
                    </div>
                </div>

                <!-- Modal footer -->
                <div
                    class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit" class="button">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Edit modal -->
<div id="edit-modal" tabindex="-1" aria-hidden="true"
    class="hidden bg-black/70 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[99999999999] justify-center items-center w-full md:inset-0 h-full max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <form action="{{ route('admin.coupon.update') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Edit Coupon
                    </h3>

                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="edit-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="grid grid-cols-2 gap-4 p-4 md:p-5">
                    <input type="hidden" id="couponId" name="id" />
                    <div class="flex flex-col gap-1.5">
                        <label for="codeId" class="inputLabel">Code</label>
                        <input type="text" id="codeId" name="code" placeholder="Code" class="inputField" required />
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="discountId" class="inputLabel">Discount</label>
                        <input type="number" step="0.01" id="discountId" name="discount" placeholder="Discount amount"
                            class="inputField" required />
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label for="typeId" class="inputLabel">Type</label>
                        <select name="type" id="typeId" class="inputField" required>
                            <option value="percentage">Percentage</option>
                            <option value="fixed">Fixed</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label for="statusId" class="inputLabel">Status</label>
                        <select name="status" id="statusId" class="inputField" required>
                            <option value="enable">Enable</option>
                            <option value="disable">Disable</option>
                        </select>
                    </div>
                </div>

                <!-- Modal footer -->
                <div
                    class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit" class="button">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('headerPartial')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.dataTables.css">
<link rel="stylesheet" href="{{ asset('public/css/custom-data-table.css') }}">
@endpush

@push('footerPartial')
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
<script>
    new DataTable('#dataTable', {
            scrollX: true,
            // Disable sorting
            "sort": false
        });

        function editModal(id) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route('admin.coupon.edit') }}');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        document.getElementById('couponId').value = response.id;
                        document.getElementById('codeId').value = response.code;
                        document.getElementById('discountId').value = response.discount;
                        document.getElementById('typeId').value = response.type;
                        document.getElementById('statusId').value = response.status;
                    } else {
                        // Handle error
                        console.error('Error occurred: ' + xhr.status);
                    }
                }
            };
            xhr.send('_token=' + encodeURIComponent('{{ csrf_token() }}') + '&id=' + encodeURIComponent(id));
        }
</script>
@endpush
