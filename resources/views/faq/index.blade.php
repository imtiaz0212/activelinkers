@extends('layouts.app')

@section('content')

<div>
    <!-- Pages Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">FAQ</h3>
        <!-- Modal toggle -->
        @if (canAccess(['faq create']))
        <a data-modal-target="default-modal" data-modal-toggle="default-modal" class="panelHeaderBtn">
            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            Create FAQ
        </a>
        @endif
    </div>

    <!-- Blog Table -->
    <div class="custom-data-table">
        <table id="dataTable">
            <thead>
                <tr>
                    <th>SL</th>

                    <th>Question</th>

                    <th>Answer</th>

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

                    <td>
                        <div class="flex items-center justify-end gap-1">
                            @if (canAccess(['faq edit']))
                            <a data-modal-target="edit-modal" onclick="editModal('{{ $row->id }}');"
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

                            @if (canAccess(['faq destroy']))
                            <a href="{{ route('admin.faq.destroy', $row->id) }}"
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
@if (canAccess(['faq create']))
<div id="default-modal" tabindex="-1" aria-hidden="true"
    class="hidden bg-black/70 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[99999999999] justify-center items-center w-full md:inset-0 h-full max-h-full">
    <div class="relative p-4 w-full max-w-4xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow ">
            <!-- Modal header -->
            <form action="{{ route('admin.faq.store') }}" method="post">
                @csrf

                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                    <h3 class="text-xl font-semibold text-gray-900 ">
                        Create FAQ
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
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
                        <input type="hidden" name="type" value="faq" />
                        <div class="grid gap-1.5">
                            <label for="title" class="inputLabel">Title</label>
                            <input type="text" name="title" id="title" placeholder="Question" class="inputField"
                                required />
                        </div>
                        <div class="grid gap-1.5">
                            <label for="answer" class="inputLabel">Answer</label>
                            <textarea name="description" id="answer" rows="4" class="inputField" placeholder="Answer"
                                required></textarea>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b ">
                    <button type="submit" class="button">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif


@if (canAccess(['faq edit']))
<!-- Edit modal -->
<div id="edit-modal" tabindex="-1" aria-hidden="true"
    class="hidden bg-black/70 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[99999999999] justify-center items-center w-full md:inset-0 h-full max-h-full">
    <div class="relative p-4 w-full max-w-4xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow ">
            <!-- Modal header -->
            <form action="{{ route('admin.faq.update') }}" method="post">
                @csrf

                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                    <h3 class="text-xl font-semibold text-gray-900 ">
                        Edit FAQ
                    </h3>

                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
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
                <div class="p-4 md:p-5 space-y-4">
                    <div class="grid gap-4">
                        <input type="hidden" id="faqId" name="id" />
                        <input type="hidden" name="type" value="faq" />

                        <div class="grid gap-1.5">
                            <label for="faqTitle" class="inputLabel">Title</label>
                            <input type="text" id="faqTitle" name="title" placeholder="Question" class="inputField"
                                required />
                        </div>
                        <div class="grid gap-1.5">

                            <label for="faqDescription" class="inputLabel">Answer</label>
                            <textarea name="description" id="faqDescription" rows="4" class="inputField"
                                placeholder="Answer" required></textarea>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b ">
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
            xhr.open("POST", '{{ route('admin.faq.edit') }}', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById('faqId').value = response.id;
                    document.getElementById('faqTitle').value = response.title;
                    document.getElementById('faqDescription').innerHTML = response.description;
                }
            };
            xhr.send('id=' + encodeURIComponent(id) + '&_token=' + encodeURIComponent('{{ csrf_token() }}'));
        }
</script>
@endpush