@extends('layouts.app')

@section('content')

<div>
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Edit Service</h3>
        <a href="{{ route('admin.service') }}" class="panelHeaderBtn">
            <i class="fa-solid fa-list-check"></i>
            All Service
        </a>
    </div>

    <!-- Form -->
    <div class=" shadow-md rounded p-5">
        <form action="{{ route('admin.service.update', $info->id) }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="grid lg:grid-cols-[auto_300px] gap-10">
                <!-- Inputs Area -->
                <div class="flex flex-col gap-4">
                    <input type="hidden" name="id" value="{{ $info->id }}">

                    <div class="grid gap-1.5">
                        <label for="service_category" class="inputLabel">Select Category</label>
                        <select id="service_category" name="service_category_id" class="inputField" required>
                            <option value="">Select Service Category</option>
                            @if (!empty($serviceCategoryList) && $serviceCategoryList->isNotEmpty())
                            @foreach ($serviceCategoryList as $row)
                            <option value="{{ $row->id }}" {{ $info->service_category_id == $row->id ? 'selected' : ''
                                }}>
                                {{ $row->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="grid gap-1.5">
                        <label for="title" class="inputLabel">Title</label>
                        <input type="text" name="title" value="{{ $info->title }}" id="title" onkeyup="setPageUrlFn()"
                            placeholder="Title" class="inputField" required />
                    </div>

                    <?php /*
                        <label for="pageUrl" class="inputLabel">Page URL</label>
                        <input type="text" name="page_url" value="{{ $info->page_url }}" id="pageUrl" placeholder="Page Url" class="inputField" readonly />
                        */
                        ?>

                    <div class="grid gap-1.5">
                        <label for="svg_icon" class="inputLabel">SVG Icon </label>
                        <textarea name="icon" id="svg_icon" class="inputField" rows="3"
                            placeholder="Your <SVG> Icon Paste Here...">{!! $info->icon !!}</textarea>
                    </div>

                    <div class="grid gap-1.5">
                        <label for="subtitle" class="inputLabel">Subtitle </label>
                        <input id="subtitle" type="text" name="subtitle" placeholder="Subtitle"
                            value="{{ $info->subtitle }}" class="inputField" />

                    </div>
                    <div class="grid gap-1.5">
                        <label for="short_desc" class="inputLabel">Short Description</label>
                        <textarea id="short_desc" name="short_description" class="inputField resize-none " rows="3"
                            placeholder="Your Short Discription...">{!! $info->short_description !!}</textarea>
                    </div>

                    <div class="grid gap-1.5">
                        <label for="reach" class="inputLabel">Reach Value</label>
                        <input id="reach" type="text" name="reach" placeholder="Reach Value (23.11K)"
                            value="{{ $info->reach }}" class="inputField" />
                    </div>

                    <div class="grid gap-1.5">
                        <label for="reach_percent" class="inputLabel">Reach Percent</label>
                        <input id="reach_percent" type="text" name="reach_percent" placeholder="Reach Percent (89.4%)"
                            value="{{ $info->reach_percent }}" class="inputField" />
                    </div>

                    <div class="grid gap-4">
                        <div class="panelHeader bg-darkblue text-white">
                            <h3 class="panelHeaderTitle lg:text-xl">Meta Information</h3>
                        </div>

                        <div class="grid gap-1.5">
                            <label for="" class="inputLabel">Meta Title</label>
                            <input type="text" name="tag_title" placeholder="Tag Title" value="{{ $info->tag_title }}"
                                class="inputField" />
                        </div>

                        <div class="grid gap-1.5">
                            <label for="" class="inputLabel">Meta Tag</label>
                            <div class="tags-input inputField">
                                <ul id="tags">
                                    @if (!empty(json_decode($info->tags)))
                                    @php($allTags = json_decode($info->tags))
                                    @foreach ($allTags as $tag)
                                    <li>
                                        {{ $tag }}
                                        <button class="delete-button">X</button>
                                        <input type="hidden" name="tags[]" value="{{ $tag }}">
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                                <input type="text" class="inputField" id="input-tag" placeholder="Enter tag name" />
                            </div>
                        </div>

                        <div class="grid gap-1.5">
                            <label for="" class="inputLabel">Meta Description</label>
                            <textarea name="meta_description"
                                id="serviceDesc">{!! $info->meta_description !!}</textarea>
                        </div>

                        <div class="grid gap-1.5">
                            <label for="" class="inputLabel">Meta Image</label>
                            @if (!empty($info->meta_image))
                            <div class="relative border w-fit rounded">
                                <img src="{{ asset($info->meta_image) }}" alt="Meta Image" width="100" height="50">
                            </div>
                            @endif
                            <input type="file" name="meta_image" class="inputField">
                        </div>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="button">Update</button>
                    </div>
                </div>

                <!-- Thumbnail area -->
                <div class="w-full order-first lg:order-last">
                    <div id="displayImage" style="background-image: url({{asset($info->images)}})"
                        class="relative border bg-center bg-contain bg-no-repeat bg-white aspect-[295/244] rounded w-full">
                        @if (!empty($info->images))
                        <a href="{{ route('admin.service.destroy-featured-image', $info->id) }}"
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

@push('headerPartial')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    .inputField[type="file"] {
        padding: 0 !important;
    }

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
@endpush

@push('footerPartial')
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
                title = title.toLowerCase().replaceAll(/ /g, '-').replace(/[^a-zA-Z0-9-]/g, '');
            }
            document.getElementById('pageUrl').value = title;
        }
        // Display Blog Thumbnail
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

                    // Add a Input Type Hidden Field With Value
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'tags[]';
                    hiddenInput.value = tagContent;
                    tag.appendChild(hiddenInput);

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