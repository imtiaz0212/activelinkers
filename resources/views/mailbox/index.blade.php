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
                    <form id="formSubmit">
                        @csrf

                        <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-3">
                            <div class="md:col-span-1">
                                <select name="email_category_id" class="inputField" id="emailCategory">
                                    <option value="all" selected>All Category</option>
                                    @if (!empty($emailCategoryList))
                                        @foreach ($emailCategoryList as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }} </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="md:col-span-1">
                                <select name="template_id" id="emailTemplate" class="inputField" required>
                                    <option value="">Select Mail Template (*)</option>
                                    @if (!empty($emailTemplateList))
                                        @foreach ($emailTemplateList as $row)
                                            <option value="{{ $row->id }}">{{ strFilter($row->name) }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="md:col-span-1">
                                <select name="email_from_id" id="emailFrom" class="inputField" required>
                                    <option value="">Select Mail From (*)</option>
                                    @if (!empty($emailFromList))
                                        @foreach ($emailFromList as $row)
                                            <option value="{{ $row->id }}">{{ strFilter($row->name) }}</option>
                                        @endforeach
                                    @endif
                                </select>
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
                    <th width="20" style="padding-left: 17px">
                        <input type="checkbox" id="selectAll">
                    </th>
                    <th width="30">
                        #
                    </th>
                    <th>&nbsp;
                        Email
                    </th>
                    <th>
                        Category
                    </th>

                    <th>
                        Status
                    </th>

                    <th width="120" class="!text-right">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
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
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
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
                            <input type="file" name="csv_file" placeholder="Select Csv File" class="inputField"/>
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
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
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
                            <input type="text" name="email" placeholder="Email" class="inputField"/>
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
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <div class="grid grid-cols-12 gap-4 p-4 md:p-5">
                        <div class="col-span-12  flex flex-col gap-1.5">

                            <input type="hidden" id="emailId" name="id"/>

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
                                <input type="text" id="emailAddress" name="email" placeholder="Email"
                                       class="inputField"/>
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
        $(document).ready(function () {
            $('#dataTable thead').on('click', 'th', function () {
                const index = table.column(this).index();
                if (index === 0) {
                    e.stopPropagation();
                }
            });

            let table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.email') }}",
                    data: function (d) {
                        d.e_c_id = $('#emailCategory').val();
                    }
                },
                order: [[1, 'asc']],
                columns: [
                    {data: 'checkbox', orderable: false, searchable: false},
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'email', name: 'email'},
                    {data: 'category.name', name: 'category.name', searchable: false},
                    {data: 'status_badge', name: 'status_badge', searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                lengthMenu: [
                    [25, 50, 100, 250, 500, 1000],
                    [25, 50, 100, 250, 500, 1000]
                ],
            });

            table.on('length.dt', function () {
                $('#selectAll').prop('checked', false);
                $(".sendButton").prop('disabled', true);
                $(".totalEmail").html(0);
            });

            table.on('search.dt', function () {
                $('#selectAll').prop('checked', false);
                $(".sendButton").prop('disabled', true);
                $(".totalEmail").html(0);
            });

            table.on('page', function () {
                $('#selectAll').prop('checked', false);
                $(".sendButton").prop('disabled', true);
                $(".totalEmail").html(0);
            });

            $('#emailCategory').on('change', function () {
                $('#selectAll').prop('checked', false);
                table.ajax.reload();
            });

            $('#selectAll').on('click', function () {
                let isChecked = $(this).is(':checked');
                $('.row-checkbox').prop('checked', isChecked);
                getCheckRecords();
            });

            $('#dataTable tbody').on('change', '.row-checkbox', function () {
                if (!this.checked) {
                    $('#selectAll').prop('checked', false);
                }
            });

            $('#dataTable').on('change', '.row-checkbox', function () {
                if ($('.row-checkbox:checked').length == $('.row-checkbox').length) {
                    $('#selectAll').prop('checked', true);
                } else {
                    $('#selectAll').prop('checked', false);
                }
                getCheckRecords();
            });

            $('#formSubmit').on('submit', function (e) {
                e.preventDefault();

                let formData = new FormData(this);
                let emailIds = getCheckRecords();
                let action = "{{ route('admin.email.campaign.store') }}";
                let successCallback = "{{ route('admin.email.campaign.success') }}";

                formData.append('email_ids', JSON.stringify(emailIds));

                if (emailIds.length > 0) {

                    $.ajax({
                        url: action,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            if (response.success) {
                                window.location.href = successCallback;
                            }
                        },
                        error: function (xhr) {
                            console.error('Error:', xhr.responseText);
                        }
                    });
                }
            });
        });

        function getCheckRecords() {
            let totalEmail = 0;
            let emailIds = [];
            $('.row-checkbox:checked').each(function () {
                emailIds.push($(this).val());
                totalEmail++;
            });

            $(".sendButton").prop('disabled', totalEmail <= 0);
            $(".totalEmail").html(totalEmail);

            return emailIds;
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
                }).then(function (response) {

                    $('#emailId').val(response.id);
                    $('#emailAddress').val(response.email);

                    const selectorEmailList = $('#editEmailCategoryList option[value="' + response
                        .email_category_id + '"]')
                    $(selectorEmailList).prop('selected', true);

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
