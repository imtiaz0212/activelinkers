@extends('layouts.app')

@section('content')

<div>
    <!-- Pages Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Brand List</h3>
        <!-- Modal toggle -->
        @if (canAccess(['brand create']))
        <a data-modal-target="default-modal" data-modal-toggle="default-modal" href="#" class="panelHeaderBtn">
            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            Create Brand
        </a>
        @endif
    </div>

    <!-- Blog Table -->
    <div class="custom-data-table">
        <table id="dataTable">
            <thead>
                <tr>
                    <th>SL</th>

                    <th>Name</th>

                    <th>Images</th>

                    <th class="!text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($results))
                @foreach ($results as $key => $row)
                <tr>
                    <th>{{ ++$key }}</th>

                    <td>
                        <a href="{{ $row->url }}" target="_blank"
                            class="px-1 py-[2px] rounded text-error bg-error/10 whitespace-nowrap">
                            {{ strFilter($row->title) }}
                        </a>
                    </td>

                    <th>
                        <img src="{{ $row->images ? asset($row->images) : asset('/images/placeholder.webp') }}"
                            width="100px" alt="{{ strFilter($row->title) }}">
                    </th>

                    <td>
                        <div class="flex items-center justify-end gap-1">
                            @if (canAccess(['brand edit']))
                            <a data-modal-target="edit-modal" onclick="editModal('{{ $row->id }}');"
                                data-modal-toggle="edit-modal" class="edit-action-btn">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                            @endif

                            @if (canAccess(['brand destroy']))
                            <a href="{{ route('admin.brand.destroy', $row->id) }}"
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
@if (canAccess(['brand create']))
<div id="default-modal" tabindex="-1" aria-hidden="true"
    class="hidden bg-black/70 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[99999999999] justify-center items-center w-full md:inset-0 h-full max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <form action="{{ route('admin.brand.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Create Brand
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
                <div class="grid grid-cols-12 items-start gap-4 p-4 md:p-5">
                    <div class="col-span-8 grid gap-4">
                        <div class="grid gap-1.5">
                            <label for="url" class="inputLabel">URL</label>
                            <input type="text" name="url" id="url" placeholder="URL" class="inputField" />
                        </div>
                        <div class="grid gap-1.5">
                            <label for="title" class="inputLabel">Title</label>
                            <input type="text" name="title" id="title" placeholder="Title" class="inputField" />
                        </div>
                    </div>

                    <!-- Thumbnail area -->
                    <div class="col-span-4">
                        <div id="displayImage"
                            class="relative border bg-center bg-contain bg-no-repeat bg-white aspect-[295/244] rounded w-full">
                        </div>
                        <label for="brandImage" class="button button--secondary w-full mt-3">
                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"
                                aria-hidden="true" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            <span class="hidden md:block">Brand Image</span>
                        </label>
                        <input type="file" name="images" id="brandImage" class="hidden" />
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
@endif


<!-- Edit modal -->
@if (canAccess(['brand edit']))
<div id="edit-modal" tabindex="-1" aria-hidden="true"
    class="hidden bg-black/70 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[99999999999] justify-center items-center w-full md:inset-0 h-full max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <form action="{{ route('admin.brand.update') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Edit Brand
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
                <div class="grid grid-cols-12 items-start gap-4 p-4 md:p-5">
                    <div class="col-span-8 grid gap-4">
                        <input type="hidden" id="brandId" name="id" />

                        <div class="grid gap-1.5">
                            <label for="brandUrl" class="inputLabel">URL</label>
                            <input type="text" id="brandUrl" name="url" placeholder="URL" class="inputField" />
                        </div>
                        <div class="grid gap-1.5">
                            <label for="brandTitle" class="inputLabel">Title</label>
                            <input type="text" id="brandTitle" name="title" placeholder="Title" class="inputField" />
                        </div>

                    </div>
                    <!-- Thumbnail area -->
                    <div class="col-span-4">
                        <div id="editDisplayImage"
                            class="relative border bg-center bg-contain bg-no-repeat bg-white aspect-[295/244] rounded w-full">
                        </div>
                        <label for="EditBrandImage" class="button button--secondary w-full mt-3">
                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"
                                aria-hidden="true" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            <span class="hidden md:block">Brand Image</span>
                        </label>
                        <input type="file" name="images" id="EditBrandImage" class="hidden" />
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
@endif

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
            xhr.open("POST", '{{ route('admin.brand.edit') }}', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById("editDisplayImage").style.backgroundImage = "url("+
                        "{{ asset('/') }}" + response.images + ")";
                    document.getElementById('brandId').value = response.id;
                    document.getElementById('brandUrl').value = response.url;
                    document.getElementById('brandTitle').value = response.title;
                }
            };
            xhr.send('id=' + encodeURIComponent(id) + '&_token=' + encodeURIComponent('{{ csrf_token() }}'));
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('displayImage').style.backgroundImage = 'url(' + e.target.result + ')';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.getElementById("brandImage").addEventListener("change", function() {
            readURL(this);
        });

        document.getElementById("EditBrandImage").addEventListener("change", function() {
            readURL(this);
        });
</script>
@endpush
