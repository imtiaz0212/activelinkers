@extends('layouts.app')

@section('content')
<div>
    <!-- Settings Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Settings</h3>
    </div>

    <!-- Settings Table -->
    <div class="relative overflow-x-auto shadow-md rounded p-2 md:p-5">
        <form action="{{ route('admin.settings.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-4">
                <div class="grid gap-4 md:grid-cols-2 items-end">
                    <div class="panelHeader bg-darkblue md:col-span-2 text-white">
                        <h3 class="panelHeaderTitle lg:text-xl">General Information</h3>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="" class="inputLabel">Site Name</label>
                        <input type="text" name="site_name" value="{{ $info->site_name }}" class="inputField">
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="" class="inputLabel">Copyright</label>
                        <input type="text" name="copyright" value="{{ $info->copyright }}" class="inputField">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label for="" class="inputLabel">Logo</label>
                        @if (!empty($info->logo))
                        <div class="relative border w-fit rounded">
                            <img src="{{ asset($info->logo) }}" alt="Logo" class="w-auto h-12">
                            <a href="{{ route('admin.settings.destroy', 'logo') }}"
                                class="absolute -right-2 -top-2 flexCenter h-5 w-5 text-white bg-error text-sm rounded-full cursor-pointer">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        </div>
                        @endif
                        <input type="file" name="logo" class="inputField">
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="" class="inputLabel">Favicon</label>
                        @if (!empty($info->favicon))
                        <div class="relative border w-fit rounded">
                            <img src="{{ asset($info->favicon) }}" alt="Favicon" class="w-auto h-12">
                            <a href="{{ route('admin.settings.destroy', 'favicon') }}"
                                class="absolute -right-2 -top-2 flexCenter h-5 w-5 text-white bg-error text-sm rounded-full cursor-pointer">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        </div>
                        @endif
                        <input type="file" name="favicon" class="inputField">
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="" class="inputLabel">White Logo</label>
                        @if (!empty($info->footer_logo))
                        <div class="relative border w-fit rounded">
                            <img src="{{ asset($info->footer_logo) }}" alt="Logo" class="w-auto h-12" alt="Banner">
                            <a href="{{ route('admin.settings.destroy', 'footer_logo') }}"
                                class="absolute -right-2 -top-2 flexCenter h-5 w-5 text-white bg-error text-sm rounded-full cursor-pointer">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        </div>
                        @endif
                        <input type="file" name="footer_logo" class="inputField">
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="" class="inputLabel">Login Background</label>
                        @if (!empty($info->login_bg))
                        <div class="relative border w-fit rounded">
                            <img src="{{ asset($info->login_bg) }}" alt="Logo" height="48" class="h-12 w-auto"
                                alt="Banner">
                            <a href="{{ route('admin.settings.destroy', 'login_bg') }}"
                                class="absolute -right-2 -top-2 flexCenter h-5 w-5 text-white bg-error text-sm rounded-full cursor-pointer">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        </div>
                        @endif
                        <input type="file" name="login_bg" class="inputField">
                    </div>
                </div>

                <div class="grid gap-4">
                    <div class="panelHeader bg-darkblue text-white">
                        <h3 class="panelHeaderTitle lg:text-xl">Google Map</h3>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="" class="inputLabel">Title</label>
                        <input type="text" name="map_title"
                            value="{{ !empty($info->map_title) ? $info->map_title : '' }}" class="inputField">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="" class="inputLabel">Iframe <small class="text-red-400">(Embed a
                                Map)</small></label>
                        <textarea name="map"
                            class="min-h-[120px] inputField">{{ !empty($info->map) ? $info->map : '' }}</textarea>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div class="panelHeader md:col-span-2 bg-darkblue text-white">
                        <h3 class="panelHeaderTitle lg:text-xl">Social Information</h3>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="" class="inputLabel">Facebook</label>
                        <input type="text" name="facebook" value="{{ $info->facebook }}" class="inputField">
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="" class="inputLabel">Google Plus</label>
                        <input type="text" name="google_plus" value="{{ $info->google_plus }}" class="inputField">
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="" class="inputLabel">Twitter</label>
                        <input type="text" name="twitter" value="{{ $info->twitter }}" class="inputField">
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="" class="inputLabel">Instagram</label>
                        <input type="text" name="instagram" value="{{ $info->instagram }}" class="inputField">
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="" class="inputLabel">Linkedin</label>
                        <input type="text" name="linkedin" value="{{ $info->linkedin }}" class="inputField">
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="" class="inputLabel">Youtube</label>
                        <input type="text" name="youtube" value="{{ $info->youtube }}" class="inputField">
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div class="panelHeader md:col-span-2 bg-darkblue text-white">
                        <h3 class="panelHeaderTitle lg:text-xl">Footer Information</h3>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="" class="inputLabel">Mobile</label>
                        <input type="tel" name="mobile" value="{{ $info->mobile }}" class="inputField">
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="" class="inputLabel">Telephone</label>
                        <input type="tel" name="telephone" value="{{ $info->telephone }}" class="inputField">
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="" class="inputLabel">Fax</label>
                        <input type="tel" name="fax" value="{{ $info->fax }}" class="inputField">
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="" class="inputLabel">Email</label>
                        <input type="email" name="email" value="{{ $info->email }}" class="inputField">
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="" class="inputLabel">Skype</label>
                        <input type="tel" name="skype" value="{{ $info->skype }}" class="inputField">
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="" class="inputLabel">Whatsapp</label>
                        <input type="tel" name="whatsapp" value="{{ $info->whatsapp }}" class="inputField">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="" class="inputLabel">BD Address</label>
                        <input type="text" name="location" class="inputField" value="{{ $info->location }}">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="" class="inputLabel">US Address</label>
                        <input type="text" name="us_location" class="inputField" value="{{ $info->us_location }}">
                    </div>

                    <div class="flex flex-col md:col-span-2 gap-2">
                        <label for="" class="inputLabel">About Us</label>
                        <textarea name="about_us" class="min-h-[120px] inputField">{{ $info->about_us }}</textarea>
                    </div>
                </div>

                <div class="grid gap-4">
                    <div class="panelHeader bg-darkblue text-white">
                        <h3 class="panelHeaderTitle lg:text-xl">Meta Information</h3>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="" class="inputLabel">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ $info->meta_title }}" class="inputField">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="" class="inputLabel">Meta Tag</label>
                        <input type="text" name="meta_tag" value="{{ $info->meta_tag }}" class="inputField">
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="" class="inputLabel">Meta Description</label>
                        <textarea name="meta_description"
                            class="inputField min-h-[150px]">{{ $info->meta_description }}</textarea>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="" class="inputLabel">Meta Image</label>
                        @if (!empty($info->meta_image))
                            <div class="relative border w-fit rounded">
                                <img src="{{ asset($info->meta_image) }}" alt="Favicon" class="w-auto h-12">
                                <a href="{{ route('admin.settings.destroy', 'favicon') }}"
                                   class="absolute -right-2 -top-2 flexCenter h-5 w-5 text-white bg-error text-sm rounded-full cursor-pointer">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            </div>
                        @endif
                        <input type="file" name="meta_image" class="inputField">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button class="button">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('headerPartial')
<style>
</style>
@endpush

@push('footerPartial')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    // $('#clientCapital').summernote({
        //     placeholder: 'Client capital raised',
        //     tabsize: 2,
        //     height: 150,
        //     toolbar: [
        //         ['style', ['style']],
        //         ['font', ['bold', 'underline', 'clear']],
        //         ['color', ['color']],
        //         ['para', ['ul', 'ol', 'paragraph']],
        //         ['table', ['table']],
        //         ['insert', ['link', 'picture', 'video']],
        //         ['view', ['fullscreen', 'codeview', 'help']]
        //     ]
        // });
</script>
@endpush
