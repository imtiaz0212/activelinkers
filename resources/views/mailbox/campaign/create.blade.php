@extends('layouts.app')

@section('content')
<div>
    <!-- Pages Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Create Template</h3>
        <!-- Modal toggle -->
        <a href="{{ route('admin.email.template') }}" class="button">
            <i class="fa-solid fa-list-check"></i>
            All Templates
        </a>
    </div>

    <form action="{{ route('admin.email.template.store') }}" method="post">
        @csrf
        <div class="flex flex-col gap-3 p-4 md:p-5">
            <div>
                <label class="block mb-[10px]">Template Name</label>
                <input type="text" name="name" placeholder="Template Name" class="inputField" required />
            </div>

            <div>
                <label class="block mb-[10px]">Subject</label>
                <input type="text" name="subject" placeholder="Subject" class="inputField" required />
            </div>

            <div>
                <label class="block mb-[10px]">Short Code</label>
                <textarea class="inputField"
                    readonly>[Invoice No] &nbsp; [Invoice Date] &nbsp; [Order Date] &nbsp; [Client Name] &nbsp; [Total Bill] &nbsp; [Invoice Link] &nbsp; [Post Link]</textarea>
            </div>

            <div>
                <textarea name="description" id="emailTemDesc"></textarea>
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="button"> Submit</button>
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