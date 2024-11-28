@extends('layouts.app')

@section('content')

<div>
    <!-- Page Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Edit Package</h3>
        <a href="{{ route('admin.package') }}" class="button">
            <i class="fa-solid fa-list-check"></i>
            All Package
        </a>
    </div>

    <!-- Form -->
    <div class=" shadow-md rounded p-5">
        <form action="{{ route('admin.package.update') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div>
                <!-- Inputs Area -->
                <input type="hidden" name="id" value="{{ $info->id }}">

                <div class="grid gap-4">
                    <div class="grid gap-1.5">
                        <label for="select_service" class="inputLabel"> Services</label>
                        <select id="select_service" name="service_id" class="inputField" required>
                            <option value="">Select Services</option>
                            @if (!empty($servicelist) && $servicelist->isNotEmpty())
                            @foreach ($servicelist as $service)
                            <option value="{{ $service->id }}" {{ $info->service_id == $service->id ? 'selected' : ''
                                }}>
                                {{ strFilter($service->title) }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="grid gap-1.5">
                        <label for="select_package" class="inputLabel"> Packages</label>
                        <select id="select_package" name="type" class="inputField" required>
                            <option value="">Select Packages</option>
                            <option value="starter" {{ $info->type == 'starter' ? 'selected' : '' }}>Starter</option>
                            <option value="professional" {{ $info->type == 'professional' ? 'selected' : '' }}>
                                Professional</option>
                            <option value="enterprise" {{ $info->type == 'enterprise' ? 'selected' : '' }}>Enterprise
                            </option>
                        </select>
                    </div>

                    <div class="grid gap-1.5">
                        <label for="title" class="inputLabel">Title</label>
                        <input type="text" name="title" id="title" value="{{ $info->title }}" placeholder="Title"
                            class="inputField" required />
                    </div>

                    <div class="grid gap-1.5">
                        <label for="serviceDesc" class="inputLabel">Short Description </label>
                        <textarea name="short_description" id="serviceDesc">{{ $info->short_description }}</textarea>
                    </div>

                    <div class="grid gap-1.5">
                        <ul class="flex font-medium text-center" id="package_price_tab"
                            data-tabs-toggle="#package_price_tab_content" role="tablist">
                            <li class="me-2" role="presentation">
                                <button
                                    class="inline-block px-2 py-1 relative pl-6 after:absolute after:left-0 after:top-1/2 after:-translate-y-1/2 after:h-5 after:w-5 after:rounded-full after:border before:absolute before:left-1 before:top-1/2 before:-translate-y-1/2 before:h-3 before:w-3 before:rounded-full before:text-xs before:bg-[#0866FF] before:border before:border-[#0866FF] before:invisible before:text-white before:flex before:items-center before:justify-center"
                                    id="monthly-tab" data-tabs-target="#monthly" type="button" role="tab"
                                    aria-controls="monthly"
                                    aria-selected="{{ $info->monthly > 0.0 ? 'true' : 'false' }}">
                                    Monthly
                                </button>
                            </li>

                            <li class="me-2" role="presentation">
                                <button
                                    class="inline-block px-2 py-1 relative pl-6 after:absolute after:left-0 after:top-1/2 after:-translate-y-1/2 after:h-5 after:w-5 after:rounded-full after:border before:absolute before:left-1 before:top-1/2 before:-translate-y-1/2 before:h-3 before:w-3 before:rounded-full before:text-xs before:bg-[#0866FF] before:border before:border-[#0866FF] before:invisible before:text-white before:flex before:items-center before:justify-center"
                                    id="yearly-tab" data-tabs-target="#yearly" type="button" role="tab"
                                    aria-controls="yearly" aria-selected="{{ $info->yearly > 0.0 ? 'true' : 'false' }}">
                                    Yearly
                                </button>
                            </li>
                        </ul>

                        <div id="package_price_tab_content">
                            <div class="hidden" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
                                <input type="text" name="monthly" value="{{ $info->monthly > 0 ? $info->monthly : '' }}"
                                    placeholder="Monthly Amount" class="inputField" />
                            </div>

                            <div class="hidden" id="yearly" role="tabpanel" aria-labelledby="yearly-tab">
                                <input type="text" name="yearly" value="{{ $info->yearly > 0 ? $info->yearly : '' }}"
                                    placeholder="Yearly amount" class="inputField" />
                            </div>
                        </div>
                    </div>


                    <div class="grid gap-4">
                        <div class="panelHeader bg-darkblue text-white">
                            <h3 class="panelHeaderTitle lg:text-xl">Feature List</h3>
                        </div>

                        <div id="featuresList" class="space-y-2">
                            @php($features = json_decode($info->features))
                            @foreach ($features as $item)
                            <div class="flex gap-[10px] relative">
                                <input type="text" name="features[]" value="{{ $item }}" placeholder="Feature"
                                    class="inputField" />
                                <div class="h-[50px] w-[50px] flex items-center justify-center bg-red-700 cursor-pointer rounded text-white text-xl"
                                    onclick="this.parentElement.remove()">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                        viewBox="0 0 448 512" height="1em" width="1em"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="text-right mt-2">
                            <button onclick="addFeatures()" class="button button--success">
                                <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"
                                    stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="18" height="18" x="3" y="3" rx="2"></rect>
                                    <path d="M8 12h8"></path>
                                    <path d="M12 8v8"></path>
                                </svg>
                                Add Feature
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center cursor-pointer">
                        <input id="isRecommended" type="checkbox" name="is_recommended" {{ $info->is_recommended == 1 ?
                        'checked' : '' }} value="1"
                        class="w-6 h-6 text-blue-600 bg-gray-100 border-gray-300 rounded focus:!shadow-none !ring-0">
                        <label for="isRecommended" class="ms-2 text-lg font-medium cursor-pointer">
                            This is Recommended Package.
                        </label>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="button">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('headerPartial')
<style>
    #package_price_tab #monthly-tab[aria-selected="true"]::before,
    #package_price_tab #yearly-tab[aria-selected="true"]::before {
        visibility: visible;
        color: #0866FF !important;
    }

    #package_price_tab #monthly-tab[aria-selected="true"]::after,
    #package_price_tab #yearly-tab[aria-selected="true"]::after {
        border-color: #0866FF !important;
    }

    #package_price_tab #monthly-tab[aria-selected="true"],
    #package_price_tab #yearly-tab[aria-selected="true"] {
        color: #0866FF !important;
    }
</style>
@endpush

@push('footerPartial')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $('#serviceDesc').summernote({
            placeholder: 'Package Short Description',
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
        const featuresLayout = `
            <input type="text" name="features[]" placeholder="Feature" class="inputField"/>
            <div class="h-[50px] w-[50px] flex items-center justify-center bg-red-700 cursor-pointer rounded text-white text-xl" onclick="this.parentElement.remove()">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg>
            </div>
        `;

        function addFeatures() {
            const featuresList = document.getElementById('featuresList');
            const div = document.createElement('div');
            div.className = 'flex gap-[10px] relative';
            div.innerHTML = featuresLayout;
            featuresList.appendChild(div);
        }
        addFeatures();
</script>
@endpush