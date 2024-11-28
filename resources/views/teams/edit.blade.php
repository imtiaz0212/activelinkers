@extends('layouts.app')

@section('content')
<div>
    <!-- Page Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Edit Team</h3>
        <a href="{{ route('admin.teams') }}" class="panelHeaderBtn">
            <i class="fa-solid fa-list-check"></i>
            All Team
        </a>
    </div>

    <!-- Form -->
    <div class="shadow-md rounded p-5">
        <form action="{{ route('admin.teams.update', $info->id) }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="grid lg:grid-cols-[auto_300px] gap-10">
                <div class="grid gap-4">
                    <input type="hidden" name="id" value="{{ $info->id }}">

                    <div class="grid gap-1.5">
                        <label for="title" class="inputLabel">Title</label>
                        <input type="text" name="name" value="{{ $info->name }}" id="title" onkeyup="setPageUrlFn()"
                            placeholder="Title" class="inputField" required />
                    </div>

                    <input type="hidden" name="slug" value="{{ $info->slug }}" id="pageUrl" class="inputField"
                        readonly />
                    <div class="grid gap-1.5">
                        <label for="phone" class="inputLabel">Phone</label>
                        <input id="phone" type="text" name="phone" placeholder="Phone" value="{{ $info->phone }}"
                            class="inputField" />
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="grid gap-1.5">
                            <label for="email" class="inputLabel">Email</label>
                            <input id="email" type="text" name="email" placeholder="Email" value="{{ $info->email }}"
                                class="inputField" />
                        </div>
                        <div class="grid gap-1.5">
                            <label for="designation" class="inputLabel">Designation</label>
                            <input id="designation" type="text" name="designation" placeholder="Designation"
                                value="{{ $info->designation }}" class="inputField" />
                        </div>

                        <div class="grid gap-1.5">
                            <label for="department" class="inputLabel">Department</label>
                            <input id="department" type="text" name="department" placeholder="Department"
                                value="{{ $info->department }}" class="inputField" />
                        </div>

                        <div class="grid gap-1.5">
                            <label for="joiningDate" class="inputLabel">Jonning Date</label>
                            <input id="joiningDate" type="text" name="joining_date" value="{{ $info->joining_date }}"
                                placeholder="Joining Date" class="datepicker inputField" />
                        </div>
                    </div>

                    <div class="grid gap-1.5">
                        <label for="serviceDesc" class="inputLabel">Description</label>
                        <textarea name="description" id="serviceDesc">{!! $info->description !!}</textarea>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="button">Update</button>
                    </div>
                </div>

                <!-- Thumbnail area -->
                <div class="w-full order-first lg:order-last">
                    <div id="displayImage"
                        class="relative border bg-center bg-contain bg-no-repeat bg-white aspect-[295/244] rounded w-full">
                        @if (!empty($info->images))
                        <a href="{{ route('admin.teams.destroy-featured-image', $info->id) }}"
                            class="absolute -right-3 -top-3 text-error">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
                                height="2em" width="2em" xmlns="http://www.w3.org/2000/svg">
                                <path fill="none" d="M0 0h24v24H0z"></path>
                                <path
                                    d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z">
                                </path>
                            </svg>
                        </a>
                        @endif
                    </div>
                    <label for="featuredImage" class="button button--secondary w-full mt-3">
                        <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"
                            height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        Upload Featured Image
                    </label>
                    <input type="file" name="featured_image" id="featuredImage" class="hidden" />
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('footerPartial')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $('#serviceDesc').summernote({
            placeholder: 'Team Testomonial',
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onInit: function() {
                    $('.note-editor').addClass('prose');
                }
            }
        });

        function isUTF8Encoded(str) {
            for (let i = 0; i < str.length; i++) {
                const charCode = str.charCodeAt(i);
                if (charCode >= 0x0980 && charCode <= 0x09FF) {
                    return true;
                }
            }
            return false;
        }

        function setPageUrlFn() {
            var title = $('#title').val().trim();
            if (isUTF8Encoded(title)) {
                title = '';
            } else {
                title = title.toLowerCase().replaceAll(/ /g, '-').replace(/[^a-zA-Z0-9-]/g, '');
            }
            $('#pageUrl').val(title);
        }

        const imageUrl = '{{ asset($info->image) }}';
        $('#displayImage').css('background-image', 'url(' + imageUrl + ')');

        //   Display Blog Thumbnail
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#displayImage').css('background-image', 'url(' + e.target.result + ')');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#featuredImage").change(function() {
            readURL(this);
        });
</script>
@endpush