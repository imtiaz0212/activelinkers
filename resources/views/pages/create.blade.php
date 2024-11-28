@extends('layouts.app')

@section('content')
<div>
    <!-- Page Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Create Page</h3>
        <a href="{{ route('admin.page') }}" class="button">
            <i class="fa-solid fa-list-check"></i>
            All Page
        </a>
    </div>


    <!-- Form -->
    <div class="shadow-md rounded p-5">
        <form action="{{ route('admin.page.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="grid lg:grid-cols-[auto_300px] gap-10">
                <!-- Inputs Area -->
                <div class="flex flex-col gap-1.5">
                    <div class="flex flex-col gap-1.5">
                        <label class="block mb-1.5" for="title">Title</label>
                        <input type="text" name="title" id="title" onkeyup="setPageUrlFn()" placeholder="Title"
                            class="inputField" required />
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="pageUrl">Page URL</label>
                        <input type="text" name="page_url" id="pageUrl" placeholder="Page Url" class="inputField"
                            readonly />
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="blogDesc">Description</label>
                        <textarea class="inputField " name="description" id="blogDesc"></textarea>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="status">Status </label>
                        <select id="status" name="status" class="inputField">
                            <option value="publish">Publish</option>
                            <option value="draft">Draft</option>
                        </select>

                    </div>
                    <fieldset class="rounded border border-[#E4E4E4] p-5">
                        <legend class="font-medium text-tertiary text-xl md:text-2xl ">Meta Information</legend>

                        <div class="flex flex-col gap-2">
                            <label for="" class="text-lg opacity-80">Meta Title</label>
                            <input type="text" name="meta_title" placeholder="Meta Title" class="mb-2 inputField" />
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="" class="text-lg opacity-80">Meta Tag</label>
                            <input type="text" name="meta_tag" placeholder="Meta Tag" class="mb-2 inputField" />
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="" class="text-lg opacity-80">Meta Description</label>
                            <textarea name="meta_description" class="mb-2 inputField" id="metaDesc"></textarea>
                        </div>

                        <div class="flex flex-col gap-2">
                            <label for="" class="text-lg opacity-80">Meta Image</label>
                            <input type="file" name="meta_image" class="inputField">
                        </div>

                    </fieldset>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="button">Submit</button>
                    </div>
                </div>

                <!-- Thumbnail area -->
                <div class="w-full order-first lg:order-last">
                    <div id="displayImage"
                        class="border-gray-200 bg-center bg-contain bg-no-repeat bg-gray-200 aspect-[295/244] rounded w-full">
                    </div>
                    <label for="featuredImage" class="button flex justify-center mt-3">
                        <i class="fa-solid fa-upload"></i>
                        Featured Image
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
    $('#blogDesc').summernote({
            placeholder: 'Page Description',
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
            var title = document.getElementById('title').value.trim();
            if (isUTF8Encoded(title)) {
                title = '';
            } else {
                title = title.trim().toLowerCase().replace(/ /g, '-').replace(/[^a-zA-Z0-9-]/g, '');
            }
            document.getElementById('pageUrl').value = title;
        }
        //   Display Blog Thumbnail
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