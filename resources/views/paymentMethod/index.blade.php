@extends('layouts.app')

@section('content')

<div>
    <!-- Pages Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Payment Methods</h3>

        <!-- Modal toggle -->
        @if (canAccess(['payment methods create']))
        <a data-modal-target="default-modal" data-modal-toggle="default-modal" href="#" class="button">
            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            Create New
        </a>
        @endif
    </div>

    <!-- Blog Table -->
    <div class="custom-data-table">
        <table class="table" id="dataTable">
            <thead>
                <tr>
                    <th>SL</th>

                    <th>Name</th>

                    <th>Public Key/ Client ID</th>

                    <th>Secret key</th>

                    <th>Mode</th>

                    <th>Status</th>

                    <th class="!text-right">Action</th>
                </tr>
            </thead>

            <tbody>
                @if (!empty($results))
                @foreach ($results as $key => $row)
                <tr>
                    <th>{{ ++$key }}</th>

                    <td>{{ $row->name }}</td>

                    <td style="width: 350px;word-break: break-all;">{{ $row->public_key }}</td>

                    <td style="width: 350px;word-break: break-all;">{{ $row->secret_key }}</td>

                    <td>
                        <span class="badge {{ $row->mode == 1 ? ' badge-success' : 'badge-danger' }}">
                            {{ $row->mode == 1 ? 'Online' : 'Offline' }}
                        </span>
                    </td>

                    <td>
                        <span class="badge {{ $row->status == 1 ? ' badge-success' : 'badge-danger' }}">
                            {{ $row->status == 1 ? 'Active' : 'Inactive' }}
                        </span>
                    </td>

                    <td>
                        <div class="flex items-center justify-end gap-1">
                            @if (canAccess(['payment methods edit']))
                            <a data-modal-target="edit-modal" onclick="getInfo('{{ $row->id }}');"
                                data-modal-toggle="edit-modal" class="edit-action-btn">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                            @endif

                            @if (canAccess(['payment methods destroy']))
                            <a href="{{ route('admin.payment-method.destroy', $row) }}"
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
    </div>
</div>

<!-- Main modal -->
<div id="default-modal" tabindex="-1" aria-hidden="true"
    class="hidden bg-black/70 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[99999999999] justify-center items-center w-full md:inset-0 h-full max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <form action="{{ route('admin.payment-method.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Create New
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
                <div class="grid grid-cols-12 gap-4 p-4 md:p-5">
                    <div class="col-span-12 flex flex-col gap-1.5">
                        <label>Name</label>
                        <input type="text" name="name" placeholder="Name" class="inputField" required />
                    </div>

                    <div class="col-span-12 flex flex-col gap-1.5">
                        <label>Public Key / Client ID</label>
                        <textarea class="inputField" name="public_key" placeholder="Public/Client ID/Key"
                            required></textarea>
                    </div>

                    <div class="col-span-12 flex flex-col gap-1.5">
                        <label>Secret Key</label>
                        <textarea class="inputField" name="secret_key" placeholder="Secret Key" required></textarea>
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
            <form action="{{ route('admin.payment-method.update') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Edit Niche
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
                <div class="grid grid-cols-12 gap-4 p-4 md:p-5">

                    <input type="hidden" name="id" id="methodId" required>

                    <div class="col-span-12 flex flex-col gap-1.5">
                        <label>Name</label>
                        <input type="text" name="name" id="methodName" placeholder="Name" class="inputField" />
                    </div>

                    <div class="col-span-12 flex flex-col gap-1.5">
                        <label>Public Key/ Client ID</label>
                        <textarea class="inputField" name="public_key" id="publicKey" placeholder="Public/Client Key"
                            required></textarea>
                    </div>

                    <div class="col-span-12 flex flex-col gap-1.5">
                        <label>Secret Key</label>
                        <textarea class="inputField" name="secret_key" id="secretKey" placeholder="Secret Key"
                            required></textarea>
                    </div>

                    <div class="col-span-12 flex flex-col gap-1.5">
                        <label>Mode</label>

                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-1" for="modeOn">
                                <input type="radio" name="mode" value="1" class="statusActive" id="modeOn">
                                Online
                            </label>

                            <label class="flex items-center gap-1" for="modeOff">
                                <input type="radio" name="mode" value="0" class="statusActive" id="modeOff">
                                Offline
                            </label>
                        </div>
                    </div>

                    <div class="col-span-12 flex flex-col gap-1.5">
                        <label>Status</label>

                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-1" for="statusActive">
                                <input type="radio" name="status" value="1" class="statusActive" id="statusActive">
                                Active
                            </label>

                            <label class="flex items-center gap-1" for="statusInActive">
                                <input type="radio" name="status" value="0" class="statusActive" id="statusInActive">
                                Inactive
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div
                    class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit" class="button"> Submit</button>
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
        async function getInfo(id) {

            const methodId = document.getElementById('methodId');
            const methodName = document.getElementById('methodName');
            const publicKey = document.getElementById('publicKey');
            const secretKey = document.getElementById('secretKey');
            const statusActive = document.getElementById('statusActive');
            const statusInActive = document.getElementById('statusInActive');
            const modeOff = document.getElementById('modeOff');
            const modeOn = document.getElementById('modeOn');

            methodId.value = '';
            methodName.value = '';
            publicKey.value = '';
            secretKey.value = '';
            statusActive.checked = false;
            statusInActive.checked = false;
            modeOff.checked = false;
            modeOn.checked = false;

            if (id) {
                const response = await fetch("{{ url('admin/payment-method/edit') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-Token": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        id: id
                    }),
                });

                const result = await response.json();

                if (result.data) {
                    methodId.value = result.data.id;
                    methodName.value = result.data.name;
                    publicKey.value = result.data.public_key;
                    secretKey.value = result.data.secret_key;

                    if (result.data.mode == 0) {
                        modeOff.checked = true;
                    } else {
                        modeOn.checked = true;
                    }

                    if (result.data.status == 1) {
                        statusActive.checked = true;
                    } else {
                        statusInActive.checked = true;
                    }

                }
            }
        }
</script>
@endpush
