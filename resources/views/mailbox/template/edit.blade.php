@extends('layouts.app')

@section('content')
<div>
    <!-- Pages Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Edit Template</h3>
        <!-- Modal toggle -->
        <a href="{{ route('admin.email.template') }}" class="button">
            <i class="fa-solid fa-list-check"></i>
            All Email Templates
        </a>
    </div>

    <form action="{{ route('admin.email.template.update', $info->id) }}" method="post">
        @csrf
        <div class="flex flex-col gap-3 p-4 md:p-5">
            <div class="grid gap-1.5">
                <label class="inputLabel">Template Name</label>
                <input type="text" name="name" value="{{ $info->name }}" placeholder="Title" class="inputField" />
            </div>

            <div class="grid gap-1.5">
                <label class="inputLabel">Subject</label>
                <input type="text" name="subject" value="{{ $info->subject }}" placeholder="Title" class="inputField" />
            </div>

            <div class="grid gap-1.5">
                <label class="inputLabel">Short Code</label>
                <textarea class="inputField"
                    readonly>[Invoice No] &nbsp; [Invoice Date] &nbsp; [Order Date] &nbsp; [Client Name] &nbsp; [Total Bill] &nbsp; [Invoice Link] &nbsp; [Post Link]  &nbsp; [Payment Details]</textarea>
            </div>

            <div class="grid gap-1.5">
                <label class="inputLabel">Description</label>
                <textarea name="description" id="emailTemDesc">{{ $info->description }}</textarea>
            </div>

            <div class="flex items-center gap-4">
                <label class="flex items-center gap-1 font-medium cursor-pointer" for="statusActive">
                    <input type="radio" name="status" class="peer hidden" value="1" id="statusActive" @if ($info->status
                    == 1) checked @endif
                    >
                    <div
                        class="size-4 rounded-full border-2 border-gray-800 peer-checked:border-4 peer-checked:border-blue-500">
                    </div>
                    <p class="peer-checked:text-blue-600">Active</p>
                </label>
                <label class="flex items-center gap-1 font-medium cursor-pointer" for="statusInActive">
                    <input type="radio" name="status" value="0" class="peer hidden" id="statusInActive"
                        @if($info->status == 0) checked @endif>
                    <div
                        class="size-4 rounded-full border-2 border-gray-800 peer-checked:border-4 peer-checked:border-blue-500">
                    </div>
                    <p class="peer-checked:text-blue-500">Inactive</p>
                </label>
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="button">Submit</button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('headerPartial')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('footerPartial')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    $('#emailTemDesc').summernote({
            placeholder: 'Description',
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
</script>
@endpush