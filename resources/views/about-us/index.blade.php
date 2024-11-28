@extends('layouts.app')

@section('content')
<div>
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">About Us</h3>
    </div>

    <!-- Settings Table -->
    <div class="relative overflow-x-auto shadow-md rounded p-5">
        <form action="{{ route('admin.about-us.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="grid lg:grid-cols-[auto_300px] gap-10">
                <!-- Inputs Area -->
                <div class="flex flex-col gap-8">
                    <div class="grid gap-4">
                        <div class="panelHeader bg-darkblue text-white">
                            <h3 class="panelHeaderTitle lg:text-xl">General Information</h3>
                        </div>

                        <input type="hidden" name="id" value="{{ $info->id }}">

                        <div class="flex flex-col gap-1.5">
                            <label for="title" class="inputLabel">Title</label>
                            <input type="text" name="title" id="title" value="{{ $info->title }}"
                                onkeyup="setPageUrlFn()" placeholder="Title" class="inputField" required />
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="pageUrl" class="inputLabel">Page URL</label>
                            <input type="text" name="page_url" id="pageUrl" value="{{ $info->page_url }}"
                                placeholder="Page Url" class="inputField" readonly />
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1.5">
                                <label for="reachValue" class="inputLabel">Reach Value</label>
                                <input id="reachValue" type="text" name="reach" value="{{ $info->reach }}"
                                    placeholder="Reach Value (23.11K)" class="inputField" />
                            </div>

                            <div class="flex flex-col gap-1.5">
                                <label for="reachPercent" class="inputLabel">Reach Percent</label>
                                <input id="reachPercent" type="text" name="reach_percent"
                                    value="{{ $info->reach_percent }}" placeholder="Reach Percent (89.4%)"
                                    class="inputField" />
                            </div>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="shortDesc" class="inputLabel">Short Description for Home</label>
                            <textarea name="short_description" class="inputField"
                                id="shortDesc">{{ $info->short_description }}</textarea>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="serviceDesc" class="inputLabel">Description </label>
                            <textarea name="description" id="serviceDesc">{{ $info->description }}</textarea>
                        </div>
                    </div>

                    <div class="grid gap-4">
                        <div class="panelHeader bg-darkblue text-white">
                            <h3 class="panelHeaderTitle lg:text-xl">Our Advantage</h3>
                        </div>

                        <div id="advantageList" class="space-y-5">
                            @php($advantageList = json_decode($info->advantage))
                            @foreach ($advantageList as $row)
                            <div class="rounded-md p-4 grid gap-4 border shadow-md relative">
                                <div class="flex flex-col gap-1.5">
                                    <label for="advantageTitle" class="inputLabel"> Title</label>
                                    <input id="advantageTitle" type="text" name="advantage_title[]"
                                        value="{{ $row->title }}" placeholder="Title" class="inputField" />
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <label for="advantageIcon" class="inputLabel"> Icon </label>
                                    <textarea id="advantageIcon" name="advantage_icon[]" class="inputField" rows="3"
                                        placeholder="Your <SVG> Icon Paste Here (80 * 80)">{{ $row->icon }}</textarea>
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <label for="advantageDesc" class="inputLabel"> Description</label>
                                    <textarea id="advantageDesc" name="advantage_discription[]"
                                        class="inputField resize-none " rows="3"
                                        placeholder="Your Short Discription...">{{ $row->description }}</textarea>
                                </div>

                                <div onclick="this.parentElement.remove()"
                                    class="absolute top-0 right-0 size-8 rounded-full flex items-center justify-center bg-red-700 cursor-pointer text-white text-sm">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                        viewBox="0 0 352 512" height="1em" width="1em"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="text-right mt-2">
                            <button type="button" onclick="addAdvantage()" class="button button--success">
                                <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"
                                    stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="18" height="18" x="3" y="3" rx="2"></rect>
                                    <path d="M8 12h8"></path>
                                    <path d="M12 8v8"></path>
                                </svg>
                                Add Advantage
                            </button>
                        </div>
                    </div>

                    <div class="grid gap-4">
                        <div class="panelHeader bg-darkblue text-white">
                            <h3 class="panelHeaderTitle lg:text-xl">Meta Information</h3>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="" class="inputLabel">Meta Title</label>
                            <input type="text" name="meta_title" placeholder="Meta Title"
                                value="{{ $info->meta_title }}" class="inputField" />
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="" class="inputLabel">Meta Tag</label>
                            <input type="text" name="meta_tag" placeholder="Meta Tag" value="{{ $info->meta_tag }}"
                                class="inputField" />
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="" class="inputLabel">Meta Description</label>
                            <textarea name="meta_description" placeholder="Meta Description" class="inputField"
                                id="metaDesc"
                                value="{{ $info->meta_description }}">{!! $info->meta_description !!}</textarea>
                        </div>

                        <div class="flex flex-col gap-1.5">
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
                        <button type="submit" class="button"> Submit</button>
                    </div>
                </div>

                <!-- Thumbnail area -->
                <div class="w-full order-first lg:order-last">
                    <div id="displayImage"
                        class="relative border bg-center bg-contain bg-no-repeat bg-white aspect-[295/244] rounded w-full">
                        @if (!empty($info->images))
                        <a href="{{ route('admin.about-us.destroy-featured-image', $info->id) }}"
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
<style>
    #uploaded-btn {
        overflow: hidden;
        padding: 10px 16px;
        background: red;
    }

    @media screen and (min-width: 600px) {
        .uploaded-btn {
            overflow: hidden;
        }
    }

    .inputField[type="file"] {
        padding: 0 !important;
    }

    #package_price_tab #monthly-tab[aria-selected="true"]::before,
    #package_price_tab #yearly-tab[aria-selected="true"]::before {
        visibility: visible;
        color: #0866FF !important
    }

    #package_price_tab #monthly-tab[aria-selected="true"]::after,
    #package_price_tab #yearly-tab[aria-selected="true"]::after {
        border-color: #0866FF !important
    }

    #package_price_tab #monthly-tab[aria-selected="true"],
    #package_price_tab #yearly-tab[aria-selected="true"] {
        color: #0866FF !important
    }

    .note-editor.note-airframe,
    .note-editor.note-frame {
        margin-bottom: 15px;
    }
</style>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    $('#serviceDesc').summernote({
            placeholder: 'About Page Description',
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

        $('#shortDesc').summernote({
            placeholder: 'Home Page Short Description',
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
                title = title.toLowerCase().replace(/ /g, '-').replace(/[^a-zA-Z0-9-]/g, '');
            }
            document.getElementById('pageUrl').value = title;
        }

        @if (!empty($info->images))
            const imageUrl = '{{ asset($info->images) }}';
            document.getElementById('displayImage').style.backgroundImage = 'url(' + imageUrl + ')';
        @endif

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

        const advantageLayout = `
        <div class="rounded-md p-4 grid gap-4 border shadow-md relative">
            <div class="flex flex-col gap-1.5">
                <label for="advantageTitle" class="inputLabel"> Title</label>
                <input id="advantageTitle" type="text" name="advantage_title[]"
                    placeholder="Title" class="inputField" />
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="advantageIcon" class="inputLabel"> Icon </label>
                <textarea id="advantageIcon" name="advantage_icon[]" class="inputField" rows="3"
                    placeholder="Your <SVG> Icon Paste Here (80 * 80)"></textarea>
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="advantageDesc" class="inputLabel"> Description</label>
                <textarea id="advantageDesc" name="advantage_discription[]"
                    class="inputField resize-none " rows="3"
                    placeholder="Your Short Discription..."></textarea>
            </div>

            <div onclick="this.parentElement.remove()"
                class="absolute top-0 right-0 size-8 rounded-full flex items-center justify-center bg-red-700 cursor-pointer text-white text-sm">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                    viewBox="0 0 352 512" height="1em" width="1em"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z">
                    </path>
                </svg>
            </div>
        </div>
        `;

        function addAdvantage() {
            document.getElementById('advantageList').insertAdjacentHTML('beforeend', advantageLayout);
        }
</script>
@endpush