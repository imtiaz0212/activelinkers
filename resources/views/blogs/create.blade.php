@extends('layouts.app')

@section('content')
<div>
    <!-- Page Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Create Blog</h3>
        <a href="{{ route('admin.blog') }}" class="panelHeaderBtn">
            <i class="fa-solid fa-list-check"></i>
            All Blog
        </a>
    </div>

    <!-- Form -->
    <div class=" shadow-md rounded p-5">
        <form action="{{ route('admin.blog.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="grid lg:grid-cols-[auto_300px] gap-10">
                <div class="grid gap-4">
                    <div class="grid gap-1.5">
                        <label for="title" class="inputLabel">Title</label>
                        <input type="text" name="title" id="title" onkeyup="setPageUrlFn()" placeholder="Title"
                            class="inputField" required />
                    </div>

                    <div class="grid gap-1.5">
                        <label for="page_url" class="inputLabel">Page URL</label>
                        <input type="text" name="page_url" id="pageUrl" placeholder="Page Url" class="inputField"
                            readonly />
                    </div>
                    <div class="grid gap-1.5">
                        <label for="subtitle" class="inputLabel">Subtitle</label>
                        <input id="subtitle" type="text" name="subtitle" placeholder="Subtitle" class="inputField" />
                    </div>
                    <div class="grid gap-1.5">
                        <label for="shortDesc" class="inputLabel">Short Description</label>
                        <textarea id="shortDesc" name="short_description" class="inputField resize-none " rows="3"
                            placeholder="Your Short Discription..."></textarea>
                    </div>

                    <div class="grid gap-1.5">
                        <label for="serviceDesc" class="inputLabel">Description</label>
                        <textarea class="inputField" name="description" id="serviceDesc"></textarea>
                    </div>

                    <div class="grid gap-4">
                        <div class="panelHeader bg-darkblue text-white">
                            <h3 class="panelHeaderTitle lg:text-xl">Meta Information</h3>
                        </div>

                        <div class="grid gap-1.5">
                            <label for="metaTitle" class="inputLabel">Meta Title</label>
                            <input type="text" id="metaTitle" name="meta_title" placeholder="Meta Title"
                                class="inputField" />
                        </div>

                        <div class="grid gap-1.5">
                            <label for="metaTag" class="inputLabel">Meta Tag</label>
                            <input type="text" id="metaTag" name="meta_tag" placeholder="Meta Tag" class="inputField" />
                        </div>

                        <div class="grid gap-1.5">
                            <label for="metaDesc" class="inputLabel">Meta Description</label>
                            <textarea name="meta_description" class="inputField" id="metaDesc"></textarea>
                        </div>

                        <div class="grid gap-1.5">
                            <label for="metaImg" class="inputLabel">Meta Image</label>
                            <input type="file" id="metaImg" name="meta_image" class="inputField">
                        </div>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="button"> Submit</button>
                    </div>
                </div>

                <!-- Thumbnail area -->
                <div class="w-full order-first lg:order-last">
                    <div id="displayImage"
                        class="relative border bg-center bg-contain bg-no-repeat bg-white aspect-[295/244] rounded w-full">
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
@push('headerPartial')
<style>
    .inputField[type="file"] {
        padding: 0 !important;
    }
</style>
@endpush

@push('footerPartial')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    $('#serviceDesc').summernote({
            placeholder: 'Service Description',
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
        $('#metaDesc').summernote({
            placeholder: 'Meta Description',
            tabsize: 2,
            height: 200,
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
            var title = document.getElementById('title').value.trim();
            if (isUTF8Encoded(title)) {
                title = '';
            } else {
                title = title.toLowerCase().replace(/  +/g, ' ').replace(/ /g, '-').replace(/[^a-zA-Z0-9-]/g, '');
            }
            document.getElementById('pageUrl').value = title;
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
        document.getElementById("featuredImage").addEventListener("change", function() {
            readURL(this);
        });
</script>
@endpush