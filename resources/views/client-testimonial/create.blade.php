@extends('layouts.app')

@section('content')
<div>
    <!-- Page Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Create Client Testimonial</h3>
        <a href="{{ route('admin.client-testimonial') }}" class="button">
            <i class="fa-solid fa-list-check"></i>
            All Client Testimonial
        </a>
    </div>

    <!-- Form -->
    <div class=" shadow-md rounded p-5">
        <form action="{{ route('admin.client-testimonial.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="grid lg:grid-cols-[auto_300px] gap-10">
                <!-- Inputs Area -->
                <div class="grid gap-4">

                    <div class="grid gap-1.5">
                        <label for="name" class="inputLabel">Name</label>
                        <input type="text" name="name" id="name" placeholder="Name" class="inputField" required />
                    </div>

                    <div class="grid gap-1.5">
                        <label for="designation" class="inputLabel">Designation</label>
                        <input type="text" name="designation" id="designation" placeholder="Designation"
                            class="inputField" />

                    </div>
                    <div class="grid gap-1.5">
                        <label for="star" class="inputLabel">Give star out of 5</label>
                        <input type="number" step="any" max="5" id="star" name="star" placeholder="Give star out of 5"
                            class="inputField" />
                    </div>
                    <div class="grid gap-1.5">
                        <label for="serviceDesc" class="inputLabel">Description</label>
                        <textarea name="description" id="serviceDesc"></textarea>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="button">Submit</button>
                    </div>
                </div>

                <!-- Thumbnail area -->
                <div class="w-full order-first lg:order-last">
                    <div id="displayImage"
                        class="relative border bg-center bg-contain bg-no-repeat bg-white aspect-[295/244] rounded w-full">
                    </div>
                    <label for="avatar" class="button button--secondary w-full mt-3">
                        <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"
                            height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        Upload Avatar
                    </label>
                    <input type="file" name="avatar" id="avatar" class="hidden" />
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('headerPartial')
<style>
    @layer base {

        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    }
</style>
@endpush

@push('footerPartial')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    $('#serviceDesc').summernote({
            placeholder: 'Client Tstimonial Description',
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

        // Client Tstimonial Thumbnail
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('displayImage').style.backgroundImage = 'url(' + e.target.result + ')';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.getElementById("avatar").addEventListener("change", function() {
            readURL(this);
        });
</script>
@endpush