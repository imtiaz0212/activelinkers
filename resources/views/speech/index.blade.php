@extends('layouts.app')

@section('content')
<div>

    <!-- Slider Header -->
    <div class="flex items-center justify-between bg-gray-50 p-5 border-b rounded">
        <h3 class="text-3xl font-semibold">Speech</h3>
    </div>


    <!-- Slider Table -->
    <div class="relative overflow-x-auto shadow-md rounded p-5">
        <form action="{{ route('admin.speech.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col-reverse lg:grid lg:grid-cols-[auto_300px] gap-10">
                <!-- Inputs Area -->
                <div class="flex flex-col gap-1.5">
                    <div>
                        <label class="block mb-2" for="name">Name</label>
                        <input type="text" name="name" value="{{ !empty($info->name) ? $info->name : '' }}" id="name"
                            placeholder="Name" class="inputField" required />
                    </div>
                    <div>
                        <label class="block mb-2" for="designation">Reward</label>
                        <input type="text" name="reward" id="reward"
                            value="{{ !empty($info->reward) ? $info->reward : '' }}" placeholder="Designation"
                            class="inputField" required />
                    </div>
                    <div>
                        <label class="block mb-2" for="designation">Designation</label>
                        <input type="text" name="designation" id="designation"
                            value="{{ !empty($info->designation) ? $info->designation : '' }}" placeholder="Designation"
                            class="inputField" required />
                    </div>
                    <div>
                        <label class="block mb-2" for="title">Title</label>
                        <input type="text" name="title" id="title"
                            value="{{ !empty($info->title) ? $info->title : '' }}" placeholder="Title"
                            class="inputField" required />
                    </div>
                    <div>
                        <label class="block mb-2" for="long_desc">Description</label>
                        <textarea name="description" id="description" placeholder="Long Description"
                            class="inputField min-h-[200px]"
                            required>{{ !empty($info->description) ? $info->description : '' }}</textarea>
                    </div>
                    <div class="flex items-center justify-end">
                        <button type="submit" class="primary-btn"> Submit</button>
                    </div>
                </div>

                <!-- Thumbnail area -->
                <div class="w-full">
                    <div id="displayImage"
                        class="border-gray-200 bg-center bg-contain bg-no-repeat bg-gray-200 aspect-[295/244] rounded w-full">
                    </div>
                    <label for="avatarImage" class="primary-btn justify-center mt-3">
                        Upload Image
                        <i class="fa-solid fa-upload"></i>
                    </label>
                    <input type="file" name="image_path" id="avatarImage" class="hidden" />
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
    $('#description').summernote({
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
            ]
        });


        const imageUrl = '{{ !empty($info->image_path) ? asset($info->image_path) : '' }}';
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

        $("#avatarImage").change(function() {
            readURL(this);
        });
</script>
@endpush