@extends('layouts.app')

@section('content')

<div>
    <!-- Pages Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Email Froms</h3>
        <!-- Modal toggle -->
        @if (canAccess(['mail email froms create new']))
        <a data-modal-target="default-modal" data-modal-toggle="default-modal" href="#" class="panelHeaderBtn">
            <i class="fa-solid fa-plus"></i>
            Create New
        </a>
        @endif
    </div>

    <!-- Blog Table -->
    <div class="custom-data-table">
        <table class="table" id="dataTable">
            <thead>
                <tr>
                    <th width="50">SL</th>

                    <th>Name</th>

                    <th>Email</th>

                    <th>Status</th>

                    <th width="100" class="!text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($results))
                @foreach ($results as $key => $row)
                <tr>
                    <th>{{ ++$key }}</th>

                    <td class="px-6 py-4">{{ strFilter($row->name) }}</td>

                    <td class="px-6 py-4">{{ $row->email }}</td>

                    <td>
                        <span class="badge {{ $row->status == 1 ? ' badge-success' : 'badge-danger' }}">
                            {{ $row->status == 1 ? 'Active' : 'Inactive' }}
                        </span>
                    </td>

                    <td>
                        <div class="flex items-center justify-end gap-1">
                            @if (canAccess(['mail email froms edit']))
                            <a data-modal-target="edit-modal" onclick="getData('{{ $row->id }}');"
                                data-modal-toggle="edit-modal"
                                class="h-8 w-8 rounded duration-300 flex items-center justify-center  bg-green-600/20 text-green-600  hover:bg-green-600 hover:text-white">
                                <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"
                                    stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                    </path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                    </path>
                                </svg>
                            </a>
                            @endif

                            @if (canAccess(['mail email froms delete']))
                            <a href="{{ route('admin.email.from.destroy', $row->id) }}"
                                onclick="return confirm('Do you want to delete this data?')"
                                class="h-8 w-8 rounded duration-300 flex items-center justify-center  bg-red-600/20 text-red-600 hover:bg-red-600 hover:text-white">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                                    height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"
                                        d="m112 112 20 320c.95 18.49 14.4 32 32 32h184c17.67 0 30.87-13.51 32-32l20-320">
                                    </path>
                                    <path stroke-linecap="round" stroke-miterlimit="10" stroke-width="32"
                                        d="M80 112h352"></path>
                                    <path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"
                                        d="M192 112V72h0a23.93 23.93 0 0 1 24-24h80a23.93 23.93 0 0 1 24 24h0v40m-64 64v224m-72-224 8 224m136-224-8 224">
                                    </path>
                                </svg>
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
            <form action="{{ route('admin.email.from.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Create From Email
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
                        <div>
                            <label class="block mb-2.5">Name</label>
                            <input type="text" name="name" placeholder="Name" class="inputField" required />
                        </div>

                        <div>
                            <label class="block mb-2.5">Email</label>
                            <input type="text" name="email" placeholder="Email" class="inputField" required />
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


<!-- Edit modal -->
<div id="edit-modal" tabindex="-1" aria-hidden="true"
    class="hidden bg-black/70 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[99999999999] justify-center items-center w-full md:inset-0 h-full max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <form action="{{ route('admin.email.from.update') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Edit From Email
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
                    <div class="col-span-12  flex flex-col gap-1.5">

                        <input type="hidden" id="categoryId" name="id" />

                        <div>
                            <label class="block mb-2.5">Name</label>
                            <input type="text" id="fromName" name="name" placeholder="Name" class="inputField"
                                required />
                        </div>

                        <div>
                            <label class="block mb-2.5">Email</label>
                            <input type="text" id="fromEmail" name="email" placeholder="Name" class="inputField"
                                required />
                        </div>

                        <div class="flex items-center gap-3">
                            <label class="flex items-center gap-1">
                                <input type="radio" name="status" value="1" id="fromActive"> Active
                            </label>

                            <label class="flex items-center gap-1">
                                <input type="radio" name="status" value="0" id="fromInactive"> Inactive
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
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
@endpush

@push('footerPartial')
<script>
    new DataTable('#dataTable', {
            scrollX: true,
            // Disable sorting
            "sort": false
        });

        async function getData(id) {
            try {
                let categoryId = document.getElementById('categoryId');
                let fromName = document.getElementById('fromName');
                let fromEmail = document.getElementById('fromEmail');
                let fromActive = document.getElementById('fromActive');
                let fromInactive = document.getElementById('fromInactive');

                categoryId.value = '';
                fromName.value = '';
                fromEmail.value = '';
                fromActive.removeAttribute('checked');
                fromInactive.removeAttribute('checked');

                const response = await fetch("{{ url('admin/email/from/edit') }}", {
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

                if (result) {

                    categoryId.value = result.id;
                    fromName.value = result.name;
                    fromEmail.value = result.email;

                    if (result.status) {
                        fromActive.setAttribute('checked', true);
                    } else {
                        fromInactive.setAttribute('checked', true);
                    }
                }

                console.log('Response', result);
            } catch (error) {
                console.error("Error:", error);
            }
        }
</script>
@endpush