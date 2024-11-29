@extends('layouts.app')
@section('content')
<div>
    <!-- Pages Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Why Choose Us</h3>

        @if (canAccess(['why choose us create']))
        <a data-modal-target="default-modal" data-modal-toggle="default-modal" href="#" class="panelHeaderBtn">
            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            Create Why Choose Us
        </a>
        @endif
    </div>

    <!-- Blog Table -->
    <div class="custom-data-table">
        <table id="dataTable">
            <thead>
                <tr>
                    <th>SL</th>

                    <th>Title</th>

                    <th>Description</th>
                    <th>Icon</th>

                    <th class="!text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($results))
                @foreach ($results as $key => $row)
                <tr>
                    <th>{{ ++$key }}</th>

                    <td>{{ strFilter($row->title) }}</td>

                    <td>{!! strLimit($row->description, 20) !!}</td>
                    <td>{!! $row->icon !!}</td>

                    <td>
                        <div class="flex items-center justify-end gap-1">
                            @if (canAccess(['why choose us edit']))
                            <a data-modal-target="edit-modal" onclick="editModal('{{ $row->id }}');"
                                data-modal-toggle="edit-modal"
                                class="edit-action-btn">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                            @endif

                            @if (canAccess(['why choose us destroy']))
                            <a href="{{ route('admin.why-us.destroy', $row->id) }}"
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
    <div class="relative p-4 w-full max-w-4xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <form action="{{ route('admin.why-us.store') }}" method="post">
                @csrf
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Create Why Choose Us
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
                <div class="p-5">
                    <div class="grid gap-4">
                        <input type="hidden" name="type" value="why-us" />

                        <div class="grid gap-1.5">
                            <label for="title" class="inputLabel">Title</label>
                            <input type="text" name="title" id="title" placeholder="Title" class="inputField"
                                required />
                        </div>

                        <div class="grid gap-1.5">
                            <label for="description" class="inputLabel">Description</label>
                            <textarea name="description" id="description" rows="4" class="inputField"
                                placeholder="Why Choose Us Description"></textarea>
                        </div>

                        <div class="grid gap-1.5">
                            <label for="icon" class="inputLabel">Icon</label>
                            <textarea name="icon" id="icon" class="inputField" rows="4"></textarea>
                        </div>
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
    <div class="relative p-4 w-full max-w-4xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <form action="{{ route('admin.why-us.update') }}" method="post">
                @csrf
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Edit Why Choose Us
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
                <div class="p-5">
                    <div class="grid gap-4">
                        <input type="hidden" id="questionId" name="id" />

                        <input type="hidden" name="type" value="why-us" />
                        <div class="grid gap-1.5">
                            <label for="title" class="inputLabel">Title</label>
                            <input type="text" id="questionTitle" id="title" name="title" placeholder="Title"
                                class="inputField" required />
                        </div>

                        <div class="grid gap-1.5">
                            <label for="questionDescription" class="inputLabel">Description</label>
                            <textarea name="description" id="questionDescription" rows="4" class="inputField"
                                placeholder="Why Choose Us Description"></textarea>
                        </div>

                        <div class="grid gap-1.5">
                            <label for="updateIcon" class="inputLabel">Icon</label>
                            <textarea name="icon" id="updateIcon" class="inputField" rows="4"></textarea>
                        </div>
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
            fetch('{{ route('admin.why-us.edit') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id: id
                })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('questionId').value = data.id;
                document.getElementById('questionTitle').value = data.title;
                document.getElementById('questionDescription').innerHTML = data.description;
                document.getElementById('updateIcon').innerHTML = data.icon;
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
</script>
@endpush
