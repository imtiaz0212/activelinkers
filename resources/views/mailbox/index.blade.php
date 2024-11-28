@extends('layouts.app')

@section('content')

<div>
    <!-- Pages Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle mb-2 md:mb-0">Mailing Lists</h3>
        <!-- Modal toggle -->
        <div class="flex gap-4 flex-wrap">
            @if (canAccess(['mail mailing lists import csv']))
            <a data-modal-target="import-modal" data-modal-toggle="import-modal" href="#" class="button">
                <i class="fa-solid fa-plus"></i>
                Import Csv
            </a>
            @endif
            @if (canAccess(['mail mailing lists create new']))
            <a data-modal-target="default-modal" data-modal-toggle="default-modal" href="#" class="button">
                <i class="fa-solid fa-plus"></i>
                Create New
            </a>
            @endif
        </div>
    </div>

    @if (canAccess(['mail mailing lists create campaign']))
    <div class="mb-4 px-4">
        <div class="relative  shadow-sm border rounded mt-5 p-5">
            <form action="{{ route('admin.email.campaign.store') }}" method="post">
                @csrf

                <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-3">
                    <div class="md:col-span-1">
                        <select name="email_category_id" class="inputField" id="emailCategoryList"
                            onchange="getFilterData()">
                            <option value="all" selected>All Category</option>
                            @if (!empty($emailCategoryList))
                            @foreach ($emailCategoryList as $row)
                            <option value="{{ $row->id }}" @if ($email_category_id==$row->id) selected @endif>{{
                                $row->name }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="md:col-span-1">
                        <select name="template_id" class="inputField" required>
                            <option value="">Select Mail Template (*)</option>
                            @if (!empty($emailTemplateList))
                            @foreach ($emailTemplateList as $row)
                            <option value="{{ $row->id }}">{{ strFilter($row->name) }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="md:col-span-1">
                        <select name="email_from_id" class="inputField" required>
                            <option value="">Select Mail From (*)</option>
                            @if (!empty($emailFromList))
                            @foreach ($emailFromList as $row)
                            <option value="{{ $row->id }}">{{ strFilter($row->name) }}</option>
                            @endforeach
                            @endif
                        </select>

                        <div class="emailIdInput"></div>
                    </div>


                    <div class="md:col-span-1">
                        <button type="submit" class="button sendButton text-center" disabled>
                            Create Campaign (<span class="totalEmail">0</span>)
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif


    <!-- Blog Table -->
    <div class="custom-data-table overflow-x-auto">
        <table id="dataTable">
            <thead>
                <tr>
                    <th width="30">
                        SL.No
                    </th>
                    <th>&nbsp;
                        <label>
                            <input type="checkbox" id="allChecked">
                            Email
                        </label>
                    </th>
                    <th>
                        Category
                    </th>

                    <th>
                        Status
                    </th>

                    <th width="100" class="!text-right">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>


                @if (!empty($results) && $results->isNotEmpty())
                @foreach ($results as $key => $row)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td class="px-6 py-4">
                        <label>
                            <input type="checkbox" data-id="{{ $row->id }}" class="tdChecked">
                            {{ $row->email }}
                        </label>
                    </td>

                    <td>
                        {{ $row->category?->name }}
                    </td>
                    <td>
                        <span class="badge {{ $row->status == 1 ? ' badge-success' : 'badge-danger' }}">
                            {{ $row->status == 1 ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center justify-end gap-1">
                            @if (canAccess(['mail mailing lists edit']))
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
                            @if (canAccess(['mail mailing lists delete']))
                            <a href="{{ route('admin.email.destroy', $row->id) }}"
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



<!-- Import modal -->
<div id="import-modal" tabindex="-1" aria-hidden="true"
    class="hidden bg-black/70 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[99999999999] justify-center items-center w-full md:inset-0 h-full max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <form action="{{ route('admin.email.store-csv') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Create New
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="import-modal">
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
                        <select name="email_category_id" class="inputField" required>
                            <option value="" selected>Select Category</option>
                            @if (!empty($emailCategoryList))
                            @foreach ($emailCategoryList as $row)
                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-span-12 flex flex-col gap-1.5">
                        <input type="file" name="csv_file" placeholder="Select Csv File" class="inputField" />
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


<!-- Main modal -->
<div id="default-modal" tabindex="-1" aria-hidden="true"
    class="hidden bg-black/70 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[99999999999] justify-center items-center w-full md:inset-0 h-full max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <form action="{{ route('admin.email.store') }}" method="post" enctype="multipart/form-data">
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
                        <label for="">Category</label>
                        <select name="email_category_id" class="inputField" required>
                            <option value="" selected>Select Category</option>
                            @if (!empty($emailCategoryList))
                            @foreach ($emailCategoryList as $row)
                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-span-12 flex flex-col gap-1.5">
                        <label for="">Email</label>
                        <input type="text" name="email" placeholder="Email" class="inputField" />
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
            <form action="{{ route('admin.email.update') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Edit Email
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

                        <input type="hidden" id="emailId" name="id" />

                        <div class="col-span-12 flex flex-col gap-1.5">
                            <label for="">Category</label>
                            <select name="email_category_id" class="inputField" id="editEmailCategoryList" required>
                                <option value="" selected>Select Category</option>
                                @if (!empty($emailCategoryList))
                                @foreach ($emailCategoryList as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-span-12 flex flex-col gap-1.5">
                            <label for="">Email</label>
                            <input type="text" id="emailAddress" name="email" placeholder="Email" class="inputField" />
                        </div>

                        <div class="flex items-center gap-3">
                            <label class="flex items-center gap-1">
                                <input type="radio" name="status" value="1" id="statusActive"> Active
                            </label>

                            <label class="flex items-center gap-1">
                                <input type="radio" name="status" value="0" id="statusInactive"> Inactive
                            </label>
                        </div>

                    </div>
                </div>

                <!-- Modal footer -->
                <div
                    class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit" class="primary-btn"> Submit</button>
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

<style>
    .custom-data-table .dt-layout-table {
        overflow-x: auto
    }


    #edit-modal button[data-modal-hide] {
        display: none
    }
</style>
@endpush

@push('footerPartial')
<script>
    new DataTable('#dataTable', {
            "lengthMenu": [
                [50, 100, 250, 500, -1],
                [50, 100, 250, 500, "All"]
            ],
            "columnDefs": [{
                "targets": 1,
                "orderable": false
            }],
            // Disable sorting
            "sort": false
        });

        function getFilterData() {

            let getUrl = window.location.href;
            const [url, data] = getUrl.split('?');
            let mainUrl = '';

            const categoryList = document.getElementById('emailCategoryList').value;
            if (categoryList != 'all') {
                mainUrl = url + '?email_category_id=' + categoryList;
            } else {
                mainUrl = url;
            }
            console.log(mainUrl);

            location.href = mainUrl;
        }

        $('#dataTable').on('change', '.tdChecked', function() {
            if ($('.tdChecked:checked').length == $('.tdChecked').length) {
                $('#allChecked').prop('checked', true);
            } else {
                $('#allChecked').prop('checked', false);
            }
            getCheckRecords();
        });


        $('#allChecked').on('click', function(e) {
            $('.tdChecked').not(this).prop('checked', this.checked);
            getCheckRecords();
        });

        function getCheckRecords() {
            $(".emailIdInput").html("");
            $(".sendButton").attr('disabled');
            $(".totalEmail").html(0);
            let totalEmail = 0;
            $('.tdChecked:checked').each(function() {
                if ($(this).prop('checked')) {
                    const rec = "<input type='hidden' name='email_id[]' value='" + $(this).attr("data-id") + "'>";
                    $(".emailIdInput").append(rec);
                    totalEmail++;
                }
            });
            $(".totalEmail").html(totalEmail);

            if (totalEmail > 0) {
                $(".sendButton").prop('disabled', false);
            } else {
                $(".sendButton").prop('disabled', true);
            }
        }


        async function getData(id) {

            const targetEl = document.getElementById('edit-modal');

            const options = {
                placement: 'bottom-right',
                backdrop: 'dynamic',
                backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
                closable: true,
                onHide: () => {
                    console.log('modal is hidden');
                },
                onShow: () => {
                    console.log('modal is shown');
                },
                onToggle: () => {
                    console.log('modal has been toggled');
                },
            };

            // instance options object
            const instanceOptions = {
                id: 'edit-modal',
                override: false
            };
            const modal = new Modal(targetEl, options, instanceOptions);

            modal.show();

            $('#emailId').val();
            $('#emailAddress').val();
            $('#editEmailCategoryList option').removeAttr('selected');
            $('#statusActive').removeAttr('checked');
            $('#statusInactive').removeAttr('checked');

            if (id) {
                const action = "{{ url('admin/email/edit') }}";
                $.post(action, {
                    id: id,
                    _token: '{{ csrf_token() }}'
                }).then(function(response) {

                    $('#emailId').val(response.id);
                    $('#emailAddress').val(response.email);

                    const selectorEmailList = $('#editEmailCategoryList option[value="' + response
                        .email_category_id + '"]')
                    $(selectorEmailList).prop('selected', true);

                    console.log(response.status);

                    if (response.status) {
                        $('#statusActive').attr('checked', true);
                    } else {
                        $('#statusInactive').attr('checked', true);
                    }
                })
            }
        }
</script>
@endpush