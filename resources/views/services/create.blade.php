@extends('layouts.app')

@section('content')

<div>
    <!-- Page Header -->
    <div class="flex items-center justify-between bg-gray-50 p-5 border-b rounded">
        <h3 class="text-3xl font-semibold">Create Service</h3>
        <a href="{{ route('admin.service') }}" class="primary-btn text-sm">
            All Service
            <i class="fa-solid fa-list-check"></i>
        </a>
    </div>

    <!-- Form -->
    <div class=" shadow-md rounded p-5">
        <form action="{{ route('admin.service.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="grid lg:grid-cols-[auto_300px] gap-10">
                <!-- Inputs Area -->
                <div class="flex flex-col gap-1.5">

                    <div class="fle flex-col gap-1.5">
                        <label for="service_categories">Service Category</label>
                        <select id="service_categories" name="service_category_id" class="inputField" required>
                            <option value="">Select Service Category</option>
                            @if (!empty($serviceCategoryList) && $serviceCategoryList->isNotEmpty())
                            @foreach ($serviceCategoryList as $row)
                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="fle flex-col gap-1.5">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" onkeyup="setPageUrlFn()" placeholder="Title"
                            class="inputField" required />
                    </div>

                    <div class="fle flex-col gap-1.5">
                        <label for="pageUrl">Page URL</label>
                        <input type="text" name="page_url" id="pageUrl" placeholder="Page Url" class="inputField"
                            readonly />
                    </div>

                    <div class="fle flex-col gap-1.5">
                        <label for="icon">Your SVG Icon</label>
                        <textarea id="icon" name="icon" class="inputField" rows="3"
                            placeholder="Your <SVG> Icon Paste Here..."></textarea>
                    </div>

                    <div class="fle flex-col gap-1.5">
                        <label for="subtitle">Subtitle</label>
                        <input id="subtitle" type="text" name="subtitle" placeholder="Subtitle" class="inputField" />
                    </div>

                    <div class="fle flex-col gap-1.5">
                        <label for="short_description">Your Short Description</label>
                        <textarea id="short_description" name="short_description" class="inputField resize-none "
                            rows="3" placeholder="Your Short Discription..."></textarea>
                    </div>

                    <div class="fle flex-col gap-1.5">
                        <label for="reach_value">Reach Value</label>
                        <input id="reach_value" type="text" name="reach" placeholder="Reach Value (23.11K)"
                            class="inputField" />
                    </div>

                    <div class="fle flex-col gap-1.5">
                        <label for="reach_percent">Reach Percent</label>
                        <input id="reach_percent" type="text" name="reach_percent" placeholder="Reach Percent (89.4%)"
                            class="inputField" />
                    </div>

                    <fieldset class="rounded border border-[#E4E4E4] p-5 space-y-2">
                        <legend class="font-medium text-tertiary text-xl md:text-2xl ">Meta Information</legend>

                        <div class="flex flex-col gap-1.5">
                            <label for="" class="text-lg opacity-80">Meta Title</label>
                            <input type="text" name="tag_title" placeholder="Tag Title" class="inputField" />
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="" class="text-lg opacity-80">Meta Tag</label>
                            <div class="tags-input inputField">
                                <ul id="tags"></ul>
                                <input type="text" class="inputField" name="tag_name" id="input-tag"
                                    placeholder="Enter tag name" />
                            </div>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="" class="text-lg opacity-80">Meta Description</label>
                            <textarea name="meta_description" id="serviceDesc"></textarea>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="" class="text-lg opacity-80">Meta Image</label>
                            <input type="file" name="meta_image" class="inputField">
                        </div>

                    </fieldset>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="primary-btn">Submit</button>
                    </div>
                </div>

                <!-- Thumbnail area -->
                <div class="w-full order-first lg:order-last">
                    <div id="displayImage"
                        class="border-gray-200 bg-center bg-contain bg-no-repeat bg-gray-200 aspect-[295/244] rounded w-full">
                    </div>
                    <label for="featuredImage" class="primary-btn justify-center mt-3">
                        Featured Image
                        <i class="fa-solid fa-upload"></i>
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
<style>
    .tags-input {
        display: inline-block;
        position: relative;
    }

    .tags-input ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .tags-input li {
        display: inline-block;
        background-color: #f2f2f2;
        color: #333;
        border-radius: 20px;
        padding: 5px 10px;
        margin-right: 5px;
        margin-bottom: 5px;
    }

    .tags-input input[type="text"] {
        border: none;
        outline: none;
        padding: 5px;
        font-size: 14px;
    }

    .tags-input input[type="text"]:focus {
        outline: none;
    }

    .tags-input .delete-button {
        background-color: transparent;
        border: none;
        color: #999;
        cursor: pointer;
        margin-left: 5px;
    }
</style>
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
                title = title.toLowerCase().replace(/  +/g, ' ').replaceAll(/ /g, '-').replace(/[^a-zA-Z0-9-]/g, '');
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
        // Get the tags and input elements from the DOM
        const tags = document.getElementById('tags');
        const input = document.getElementById('input-tag');

        // Add an event listener for keydown on the input element
        input.addEventListener('keydown', function(event) {
            // Check if the key pressed is 'Enter'
            if (event.key === 'Enter') {

                // Prevent the default action of the keypress
                // event (submitting the form)
                event.preventDefault();

                // Create a new list item element for the tag
                const tag = document.createElement('li');

                // Get the trimmed value of the input element
                const tagContent = input.value.trim();

                // If the trimmed value is not an empty string
                if (tagContent !== '') {

                    // Set the text content of the tag to
                    // the trimmed value
                    tag.innerText = tagContent;

                    // Add a delete button to the tag
                    tag.innerHTML += '<button class="delete-button">X</button>';
                    tag.innerHTML += '<input type="hidden" name="tags[]"' + ' value="' + tagContent + '" >';

                    // Append the tag to the tags list
                    tags.appendChild(tag);

                    // Clear the input element's value
                    input.value = '';
                }
            }
        });
        // Add an event listener for click on the tags list
        tags.addEventListener('click', function(event) {
            // If the clicked element has the class 'delete-button'
            if (event.target.classList.contains('delete-button')) {
                // Remove the parent element (the tag)
                event.target.parentNode.remove();
            }
        });
</script>
@endpush