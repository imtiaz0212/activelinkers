@extends('layouts.app')

@section('content')

<div>
    <!-- Page Header -->
    <div class="panelHeader">
        <h3 class=" panelHeaderTitle">Edit</h3>
        <a href="{{ route('admin.site-list') }}" class="button">
            <i class="fa-solid fa-list-check"></i>
            All Sites

        </a>
    </div>

    <!-- Form -->
    <div class=" shadow-md rounded p-5">
        <form action="{{ route('admin.site-list.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $info->id }}" />
            <div class="grid lg:grid-cols-3 items-end gap-4">
                <div class="grid gap-1.5">
                    <label for="title" class="inputLabel">Title <span>*</span></label>
                    <input type="text" name="title" id="title" value="{{ $info->title }}" placeholder="Product Title"
                        class="inputField" required />
                </div>

                <div class="grid gap-1.5">
                    <label for="url" class="inputLabel">Website URL <span>*</span></label>
                    <input type="text" name="url" id="url" value="{{ $info->url }}" placeholder="https://domain.com"
                        class="inputField" required />
                </div>

                <div class="grid gap-1.5">
                    <label for="owner" class="inputLabel">Owner Name</label>
                    <input type="text" name="owner" id="owner" value="{{ $info->owner }}" placeholder="Owner Name"
                        class="inputField" />
                </div>

                <div class="grid gap-1.5">
                    @php($selectNiche = !empty(json_decode($info->niche)) ? json_decode($info->niche) : [])
                    <label for="niche" class="inputLabel">Niche List <span>*</span></label>
                    <select class="js-example-basic-multiple inputField" name="niche[]" multiple="multiple"
                        data-placeholder="Select Niche">
                        <option value="">Select Niche</option>
                        @if (!empty($nicheList) && $nicheList->isNotEmpty())
                        @foreach ($nicheList as $key => $row)
                        <option {{ in_array($row->id, $selectNiche) ? 'selected' : '' }}
                            value="{{ $row->id }}"> {{ $row->name }} </option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <div class="grid gap-1.5">
                    <label for="generalPrice" class="inputLabel"> General Price <span>*</span></label>
                    <input type="number" name="general_price" id="generalPrice" placeholder="General Price"
                        value="{{ $info->general_price }}"
                        class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                        step="any" />
                </div>

                <div class="grid gap-1.5">
                    <label for="otherPrice" class="inputLabel"> Others Price </label>
                    <input type="number" name="other_price" id="otherPrice" placeholder="Other Price"
                        value="{{ $info->other_price }}"
                        class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                        step="any" />
                </div>

                <div class="grid gap-1.5">
                    <label for="da" class="inputLabel"> DA </label>
                    <input type="number" name="da" placeholder="DA" max="100" value="{{ $info->da }}"
                        class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                        step="any" id="da" />
                </div>

                <div class="grid gap-1.5">
                    <label for="pa" class="inputLabel"> PA </label>
                    <input type="number" name="pa" placeholder="PA" max="100" value="{{ $info->pa }}"
                        class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                        step="any" id="pa" />
                </div>

                <div class="grid gap-1.5">
                    <label for="dr" class="inputLabel"> DR </label>
                    <input type="number" name="dr" placeholder="DR" max="100" value="{{ $info->dr }}"
                        class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                        step="any" id="dr" />
                </div>

                <div class="grid gap-1.5">
                    <label for="aHrefRank" class="inputLabel"> A href Rank </label>
                    <input type="number" name="ahref" placeholder="A href Rank" value="{{ $info->ahref_rank }}"
                        class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                        step="any" id="aHrefRank" />
                </div>

                <div class="grid gap-1.5">
                    <label for="traffic" class="inputLabel"> Traffic </label>
                    <input type="number" name="traffic" placeholder="0" value="{{ $info->traffic }}"
                        class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                        step="any" id="traffic" />
                </div>

                <div class="grid gap-1.5">
                    <label for="organicKeyword" class="inputLabel"> Organic Keywords </label>
                    <input type="text" name="organic_keyword" placeholder="100 or 100k+"
                        value="{{ $info->organic_keyword }}"
                        class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                        step="any" id="organicKeyword" />
                </div>

                <div class="grid gap-1.5">
                    <label for="country" class="inputLabel"> Country</label>
                    <select name="country_id" class="inputField">
                        <option value="">Select Country</option>
                        @if($countryList)
                        @foreach($countryList as $row)
                        <option value="{{$row->id}}" @if($row->id == $info->country_id) selected @endif>{{$row->name}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <div class="grid gap-1.5">
                    <label for="" class="inputLabel">Upload Image</label>
                    <div class="flex space-x-2">
                        @if (!empty($info->image))
                        <img src="{{asset($info->image)}}" alt="{{$info->title}}" height="46"
                            class="h-[46px] border rounded w-auto">
                        @endif
                        <input type="file" name="attachment" class="inputField" />
                    </div>
                </div>

                <div class="grid gap-1.5">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" {{ $info->auto_update ? 'checked' : '' }} name="auto_update" class="sr-only peer">
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none  rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all  peer-checked:bg-blue-600">
                        </div>
                        <span class="ms-3 text-lg font-medium text-gray-900 ">Auto update</span>
                    </label>
                </div>

                <div class="panelHeader lg:col-span-3 bg-darkblue text-white">
                    <h3 class="panelHeaderTitle lg:text-xl">SEO Details</h3>
                </div>

                <div class="grid lg:grid-cols-2 gap-4 lg:col-span-3">
                    <div class="grid gap-1.5">
                        <label for="" class="inputLabel">Meta Title</label>
                        <input type="text" name="meta_title" value="{{$info->meta_title}}" placeholder="Meta Title"
                            class="inputField" />
                    </div>

                    <div class="grid gap-1.5">
                        <label for="" class="inputLabel">Meta Tag</label>
                        <input type="text" name="meta_tag" value="{{$info->meta_tag}}" placeholder="Meta Tag"
                            class="inputField" />
                    </div>
                </div>

                <div class="grid gap-1.5 lg:col-span-3">
                    <label for="" class="inputLabel">Meta Description</label>
                    <textarea name="meta_description" class="inputField min-h-24"
                        id="metaDesc">{{$info->meta_description}}</textarea>
                </div>

                <div class="flex items-center justify-end lg:col-span-3">
                    <button type="submit" class="button"> Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('headerPartial')
{{-- Select2 CDN --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

<style>
    fieldset {
        border-radius: 0.25rem;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #bcec00;
        border: 1px solid #bcec00;
        color: #333;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        background-color: #031f42;
        border: 1px solid #031f42;
        color: #fff;
        font-size: 0.75em;
        padding: 2px 4px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        background-color: #c81e1e;
        border: 1px solid #c81e1e;
        color: #fff;
    }

    .select2-container--default .select2-selection--multiple {
        border: 1px solid #e4e4e4 !important;
    }

    .select2-container--default .select2-selection--single[aria-expanded="true"],
    .select2-container--default.select2-container--focus .select2-selection--multiple[aria-expanded="true"],
    .select2-container--default .select2-selection--multiple[aria-expanded="true"] {
        border-color: #3A9CFD !important;
    }

    .select2-selection__arrow {
        height: auto !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
    }
</style>
@endpush

@push('footerPartial')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
</script>
@endpush
