@extends('layouts.app')

@section('content')
<!-- Pages Header -->
<div class="panelHeader">
    <h3 class="panelHeaderTitle mb-2 md:mb-0">Image Manager</h3>
    <!-- Modal toggle -->
    <div class="flex gap-4 flex-wrap">
        @if (canAccess(['mail image create']))
        <a data-modal-target="create-modal" data-modal-toggle="create-modal" href="#" class="panelHeaderBtn">
            <i class="fa-solid fa-plus"></i>
            Upload Image
        </a>
        @endif
    </div>
</div>

<!-- Images List -->

@if (!empty($results) && $results->isNotEmpty())
<div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-5 gap-3 md:gap-4 lg:gap-6 p-5">
    @foreach ($results as $key => $row)
    <div class="relative border overflow-hidden rounded w-full aspect-square group">

        <img class="size-full" style="object-fit:contain" loading="lazy" src="{{ asset($row->img_path) }}" alt="{{ $row->name }}">

        <div
            class="flex items-start gap-2 justify-end p-4 absolute left-0 duration-300 bg-gradient-to-b from-black/60 pb-8 to-transparent -top-full w-full group-hover:top-0 h-auto">

            {{-- Copy Button --}}
            <input type="hidden" value="{{ asset($row->img_path) }}" id="copyUrl{{ $row->id }}">

            <button onclick="copyText({{ $row->id }})" onmouseout="outFunc({{ $row->id }})" data-id="{{ $row->id }}"
                class="size-8 flex items-center justify-center rounded bg-green-500 hover:bg-green-600 duration-300 text-white"
                data-tooltip="Copy" tooltip tooltip-place="bottom">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em"
                    width="1em" xmlns="http://www.w3.org/2000/svg">
                    <path fill="none" d="M0 0h24v24H0V0z"></path>
                    <path
                        d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm-1 4H8c-1.1 0-1.99.9-1.99 2L6 21c0 1.1.89 2 1.99 2H19c1.1 0 2-.9 2-2V11l-6-6zM8 21V7h6v5h5v9H8z">
                    </path>
                </svg>
            </button>

            {{-- View Button --}}
            <a data-fslightbox="gallery" href="{{ asset($row->img_path) }}"
                class="size-8 flex items-center justify-center rounded bg-blue-500 hover:bg-blue-600 duration-300 text-white"
                data-tooltip="View" tooltip tooltip-place="bottom">
                <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                    stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                    <path
                        d="M12.597 17.981a9.467 9.467 0 0 1 -.597 .019c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6c-.205 .342 -.415 .67 -.63 .983">
                    </path>
                    <path d="M16 22l5 -5"></path>
                    <path d="M21 21.5v-4.5h-4.5"></path>
                </svg>
            </a>

            {{-- Edit Button --}}
            {{-- <button
                class="size-8 flex items-center justify-center rounded bg-gray-500 hover:bg-gray-600 duration-300  text-white"
                data-tooltip="Edit" tooltip tooltip-place="bottom">
                <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                    stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 13.5V4a2 2 0 0 1 2-2h8.5L20 7.5V20a2 2 0 0 1-2 2h-5.5"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <path d="M10.42 12.61a2.1 2.1 0 1 1 2.97 2.97L7.95 21 4 22l.99-3.95 5.43-5.44Z"></path>
                </svg>
            </button> --}}

            {{-- Delete Button --}}
            <a href="{{ route('admin.email.images.destroy', $row->id) }}"
                onclick="return confirm('Are you sure you want to this data?')"
                class="size-8 flex items-center justify-center rounded bg-red-500 hover:bg-red-600 duration-300  text-white"
                data-tooltip="Delete" tooltip tooltip-place="bottom">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em"
                    width="1em" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M16 1.75V3h5.25a.75.75 0 0 1 0 1.5H2.75a.75.75 0 0 1 0-1.5H8V1.75C8 .784 8.784 0 9.75 0h4.5C15.216 0 16 .784 16 1.75Zm-6.5 0V3h5V1.75a.25.25 0 0 0-.25-.25h-4.5a.25.25 0 0 0-.25.25ZM4.997 6.178a.75.75 0 1 0-1.493.144L4.916 20.92a1.75 1.75 0 0 0 1.742 1.58h10.684a1.75 1.75 0 0 0 1.742-1.581l1.413-14.597a.75.75 0 0 0-1.494-.144l-1.412 14.596a.25.25 0 0 1-.249.226H6.658a.25.25 0 0 1-.249-.226L4.997 6.178Z">
                    </path>
                    <path
                        d="M9.206 7.501a.75.75 0 0 1 .793.705l.5 8.5A.75.75 0 1 1 9 16.794l-.5-8.5a.75.75 0 0 1 .705-.793Zm6.293.793A.75.75 0 1 0 14 8.206l-.5 8.5a.75.75 0 0 0 1.498.088l.5-8.5Z">
                    </path>
                </svg>
            </a>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="p-5 flex items-center justify-center flex-col">
    <img src="{{ asset('public/images/add-image.jpg') }}" alt="Add Image">
    <span class="text-lg font-medium text-center">Your folder is empty please upload an image</span>
</div>
@endif



<!-- Create modal -->
<div id="create-modal" tabindex="-1" aria-hidden="true"
    class="hidden bg-black/70 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[99999999999] justify-center items-center w-full md:inset-0 h-full max-h-full">
    <div class="relative p-4 w-full max-w-4xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <form action="{{ route('admin.email.images.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Upload Image
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="create-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="grid gap-4 p-4 md:p-5">
                    <label for="file-input"
                        class="h-32 rounded-lg border border-dashed flex items-center justify-center text-2xl font-medium cursor-pointer">
                        Upload Images
                        <input type="file" id="file-input" accept="image/*" name="images[]" hidden multiple>
                    </label>
                    <div id="preview-container" class="flex items-center gap-2 flex-wrap"></div>
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
{{-- <div id="edit-modal" tabindex="-1" aria-hidden="true"
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

                        <input type="text" id="emailAddress" name="email" placeholder="Email" class="inputField" />

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
                    <button type="submit" class="button"> Submit</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}
@endsection

@push('headerPartial')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.dataTables.css">
<link rel="stylesheet" href="{{ asset('public/css/custom-data-table.css') }}">
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
@endpush

@push('footerPartial')
<script src="{{ asset('public/js/fslightbox.min.js') }}"></script>

{{-- Copy Image Url --}}
<script>
    function copyText(rowId) {
            var linkElement = document.querySelector(`[data-tooltip="Copy"][data-id="${rowId}"]`);
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
            var linkElement = document.querySelector(`[data-tooltip="Copied"][data-id="${rowId}"]`);
            if (linkElement) {
                linkElement.setAttribute('data-tooltip', 'Copy');
            }
        }
</script>

<script>
    $(document).ready(function() {
            $("#file-input").on("change", function() {
                var files = $(this)[0].files;
                $("#preview-container").empty();
                if (files.length > 0) {
                    for (var i = 0; i < files.length; i++) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $(`<div class='preview border relative rounded size-24'><img  src='${e.target.result}' class="size-full object-cover rounded" alt="Image"><button class='delete hidden absolute right-0 top-0 size-7 text-xs rounded-full  items-center justify-center hover:bg-red-700 duration-300 bg-red-600 text-white'><svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></button></div>`)
                                .appendTo("#preview-container");
                        };
                        reader.readAsDataURL(files[i]);
                    }
                }
            });
            $("#preview-container").on("click", ".delete", function() {
                $(this).parent(".preview").remove();
                $("#file-input").val("");
            });
        });
</script>

<script>
    new DataTable('#dataTable', {
            "columnDefs": [{
                "targets": 0,
                "orderable": false
            }]
        });

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
            try {

                let emailId = document.getElementById('emailId');
                let emailAddress = document.getElementById('emailAddress');
                let statusActive = document.getElementById('statusActive');
                let statusInactive = document.getElementById('statusInactive');

                emailId.value = '';
                emailAddress.value = '';
                statusActive.removeAttribute('checked');
                statusInactive.removeAttribute('checked');

                const response = await fetch("{{ url('admin/email/edit') }}", {
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

                    emailId.value = result.id;
                    emailAddress.value = result.email;

                    if (result.status) {
                        statusActive.setAttribute('checked', true);
                    } else {
                        statusInactive.setAttribute('checked', true);
                    }
                }

                //console.log('Response', result);
            } catch (error) {
                console.error("Error:", error);
            }
        }
</script>
@endpush