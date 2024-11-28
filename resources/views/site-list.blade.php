@section('headerMeta')
@php
$metaTitle = $metaDescription = $metaKeywords = strFilter(config('app.name'));
$metaImage = 'images/website.png';
if (!empty($info)) {
$metaTitle = !empty($info->meta_title) ? $info->meta_title : $siteInfo->meta_title;
$metaDescription = $info->meta_description;
$metaKeywords = $info->meta_tag;
$metaImage = !empty($info->meta_image) ? $info->meta_image : $metaImage;
} elseif (!empty($siteInfo)) {
$metaTitle = $siteInfo->meta_title;
$metaDescription = $siteInfo->meta_description;
$metaKeywords = $siteInfo->meta_tag;
$metaImage = !empty($siteInfo->meta_image) ? $siteInfo->meta_image : $metaImage;
}
@endphp
<title>{{ $metaTitle }}</title>

<meta name="title" content="{{ $metaTitle }}">
<meta name="description" content="{{ $metaDescription }}">
<meta name="keywords" content="{{ $metaKeywords }}">

<meta name='og:title' content="{{ $metaTitle }}">
<meta name='og:image' content="{{ asset( $metaImage) }}">
<meta name='og:site_name' content="{{ $metaTitle }}">
<meta name='og:description' content="{{ $metaDescription }}">
@endsection

@extends('layouts.frontend')
@section('content')

@include('layouts.frontend-partial.breadcrumb')

<section class="sectionGap">
    <div class="container">
        <div class="mb-8 space-y-3">
            <h1 class="sectionTitle lg:text-4xl">
                {{ !empty($info->title) ? $info->title : '' }}
            </h1>

            <p class=" text-[#627193] md:text-lg">
                {{ !empty($info->subtitle) ? $info->subtitle : '' }}
            </p>
        </div>

        {{-- =====================================================
        site cart table section begins here
        ============================================= --}}
        <div class="overflow-hidden">
            <table
                class="display text-sm md:text-base responsive nowrap text-[#627193] stripe font-normal rounded-[8px] overflow-hidden"
                id="dataTable" width="100%">
                <thead class="text-white bg-primary">
                    <tr class="border-[#D9D9D9]">
                        <th data-priority="1" class="border">Website URL</th>
                        <th class="border !text-center">DA</th>
                        <!--<th class="border">PA</th>-->
                        <th class="border !text-center">DR</th>
                        <th class="border !text-center">Traffic</th>
                        <th class="border !text-center">Keywords</th>
                        <th class="border">Niche</th>
                        <th data-priority="2" class="border !text-center">Price</th>
                        <th class="border !text-center w-36">Buy Now</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($siteList as $key => $data)
                    <tr>
                        <td class="border">
                            <a href="{{ $data->url }}" target="_blank"
                                class="text-secondary font-semibold relative hover:text-darkblue">
                                {{ removeHttp($data->url) }}
                            </a>
                        </td>

                        <td class="border !text-center">
                            <div class="circle da-progress-value" style="--percent:{{ $data->da }}%;">
                                <span class="progress-value">{{ $data->da }}</span>
                            </div>
                        </td>

                        <td class="border !text-center">
                            <div class="circle dr-progress-value" style="--percent:{{ $data->dr }}%;">
                                <span class=" progress-value">{{ $data->dr }}</span>
                            </div>
                        </td>

                        <td class="border !text-center">
                            <span class="flex items-center gap-1.5">
                                @if(!empty($data->country))
                                <img src="{{asset('images/country-flags/' . strtolower($data->country->code) .'.svg')}}"
                                    class="object-fill size-6 rounded-full border" alt="Country flag">
                                @else
                                <img src="{{asset('images/globe.svg')}}" class="object-fill size-6 rounded-full border"
                                    alt="Country flag">
                                @endif
                                {{formatNumber($data->traffic) }}
                            </span>
                        </td>

                        <td class="border !text-center">{{ formatNumber($data->organic_keyword) }}</td>

                        <td class="border">
                            <div class="flex flex-wrap gap-1.5">
                                @php
                                if (!empty(json_decode($data->niche))) {
                                $nicheItems = json_decode($data->niche);
                                $allNiche = '';
                                $count = count($nicheItems) - 1;
                                foreach ($nicheItems as $key => $niche) {
                                $allNiche .= '<span>' . $nicheList->where('id', $niche)->first()->name . ($count > $key
                                    ? ',' : '') . '</span>' ;
                                }
                                echo trim($allNiche);
                                }
                                @endphp
                            </div>
                        </td>

                        <td class="border !text-center"><span>{{ sprintf('$%0.2f', $data->general_price) }}</span></td>

                        <td class="border">
                            <span class="flex items-center gap-2 items-center">
                                <a href="{{ url('websites/' . $data->id.'/details') }}"
                                    class="bg-secondary border border-secondary rounded-full inline-flex items-center gap-1 py-2 px-3 text-sm font-medium font-syne text-white transition duration-300 hover:bg-darkblue hover:border-darkblue">
                                    <span class="shrink-0 whitespace-nowrap"> Buy Now</span>
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 32 32"
                                        height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M 18.71875 6.78125 L 17.28125 8.21875 L 24.0625 15 L 4 15 L 4 17 L 24.0625 17 L 17.28125 23.78125 L 18.71875 25.21875 L 27.21875 16.71875 L 27.90625 16 L 27.21875 15.28125 Z">
                                        </path>
                                    </svg>
                                </a>

                                <a href="mailto:{{$siteInfo->email}}"
                                    class="border border-secondary text-secondary rounded-full inline-flex items-center gap-1 py-2 px-3 text-sm font-medium font-syne transition duration-300 hover:bg-secondary hover:text-white">
                                    <span class="shrink-0 whitespace-nowrap">Send Mail</span>
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 32 32"
                                        height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M 18.71875 6.78125 L 17.28125 8.21875 L 24.0625 15 L 4 15 L 4 17 L 24.0625 17 L 17.28125 23.78125 L 18.71875 25.21875 L 27.21875 16.71875 L 27.90625 16 L 27.21875 15.28125 Z">
                                        </path>
                                    </svg>
                                </a>
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@include('layouts.frontend-partial.cta-area')
@endsection
@push('headerPartial')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.6/css/dataTables.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css">

<style>
    .cta-area {
        padding: 0 !important;
    }

    table.dataTable>thead>tr>th,
    table.dataTable>thead>tr>td {
        padding: 15px 10px !important;
    }

    .dt-paging.paging_full_numbers .dt-paging-button {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 20px !important;
    }

    .dt-search input[type="search"] {
        max-width: none !important;
        margin-left: 0px !important;
        width: 100% !important;
    }

    div.dt-container .dt-paging .dt-paging-button.current:hover {
        background: linear-gradient(to bottom, #585858 0%, #111 100%) !important;
        color: #eee !important;
    }

    .dt-layout-cell.dt-start .dt-length {
        display: none;
    }

    div.dt-container div.dt-layout-cell.dt-end {
        text-align: left !important;
    }

    .dt-length .dt-input {
        width: 80px;
    }

    .dt-layout-cell .dt-info {
        font-size: 16px;
    }

    .dt-type-numeric {
        text-align: left;
    }

    .dataTables_filter label input[type=search] {
        left: 15px;
        top: 2px;
        width: 100%;
        border-radius: 8px;
        padding-left: 40px;
        padding-top: 12px;
        padding-bottom: 12px;
        border-color: #D9D9D9;
    }

    .dt-search .dt-input {
        border-radius: 8px;
    }

    .dt-length label {
        font-size: 16px;
    }

    .dataTables_filter label input[type=search]:focus,
    select:not([size]):focus,
    .dt-search .dt-input:focus {
        border: 1px solid #7572FD !important;
        outline: none !important;
        box-shadow: none !important;
    }

    .bottom {
        display: table;
        width: 100%;
        padding-top: 15px;
    }

    .dataTables_info {
        display: table-cell;
        vertical-align: middle;
        width: 50%;
        padding-left: 15px;
    }

    .dataTables_paginate.paging_simple_numbers {
        display: table-cell;
        padding: 10px 15px;
        margin-top: 10px;
        vertical-align: middle;
        width: 50%;
        text-align: right;
    }

    #dataTable_wrapper .bottom {
        margin-top: 30px;
        display: flex;
        align-items: center;
        padding: 0 10px;
        justify-content: space-between
    }

    .dt-paging.paging_simple_numbers {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap
    }

    .dt-paging-button {
        background: transparent;
        border: 1px solid #D9D9D9 !important;
        border-radius: 10px !important;
        margin: 0 5px;
        cursor: pointer;
        transition: .35s;
        flex-shrink: 0;
        font-weight: 400;
        min-width: 35px !important;
        height: 35px;
        padding: 0 5px !important;
        font-size: 14px;
    }


    div.dt-container .dt-paging .dt-paging-button.current,
    div.dt-container .dt-paging .dt-paging-button.current:hover,
    div.dt-container .dt-paging .dt-paging-button:hover {
        background: linear-gradient(#00005C, #00005C) !important;
        border: 1px solid #00005C !important;
        color: white !important;
    }

    div.dt-container .dt-paging .dt-paging-button.disabled {
        background: #f2f2f2 !important;
        color: #333 !important;
        border: none;
    }

    div.dt-container .dt-paging .dt-paging-button.disabled:hover {
        background: #f2f2f2 !important;
        border: 1px solid #D9D9D9 !important;
    }

    .dt-paging-button {
        color: white !important;
    }

    @keyframes css-progress {
        to {
            --progress-value: 70;
        }
    }

    .circle {
        --percent: 0%;
        font-size: 1em;
        font-weight: 400;
        width: 42px;
        height: 42px;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        position: relative;
        z-index: 0;
    }

    .circle::before {
        content: "";
        position: absolute;
        z-index: -1;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: inherit;
        padding: 5px;
    }

    .da-progress-value::before {
        background: linear-gradient(white, white) content-box, conic-gradient(#008D00 0 var(--percent), #D9D9D9 0);
        -webkit-mask: radial-gradient(farthest-side, transparent calc(100% - 16px), #fff calc(100% - 15px));
    }

    .pa-progress-value::before {
        background: linear-gradient(white, white) content-box, conic-gradient(#FF7C22 0 var(--percent), #D9D9D9 0);
        -webkit-mask: radial-gradient(farthest-side, transparent calc(100% - 16px), #fff calc(100% - 15px));
    }

    .dr-progress-value::before {
        background: linear-gradient(white, white) content-box, conic-gradient(#407BFF 0 var(--percent), #D9D9D9 0);
        -webkit-mask: radial-gradient(farthest-side, transparent calc(100% - 16px), #fff calc(100% - 15px));
    }

    @media only screen and (max-width: 576px) {

        #dataTable_wrapper .top,
        #dataTable_wrapper .bottom {
            display: flex;
            flex-direction: column;
            gap: 10px;
            justify-content: center;
            align-items: flex-start;
            padding: .5rem;
        }

        .dataTables_filter,
        .dataTables_info {
            width: 100%;
        }
    }

    @media only screen and (min-width: 768px) {
        .dt-paging-button {
            min-width: 40px !important;
            height: 40px;
            padding: 0 7px !important;
            font-size: 16px;
        }

        .dt-paging.paging_simple_numbers {
            justify-content: flex-end;
        }
    }

    .dt-search input[type=search] {
        max-width: 500px;
        width: 100% !important;
        padding: 12px 20px !important;
        font-size: 18px;
        border-radius: 10px !important;
    }
</style>
@endpush
@push('footerPartial')
<script src="https://cdn.datatables.net/2.0.6/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>

<script>
    new DataTable('#dataTable', {
            columnDefs: [{
                responsivePriority: 1,
                targets: 0
            },
                {
                    responsivePriority: 2,
                    targets: 7
                }
            ],
            // dom: '<"top"fl>rt<"bottom"ip><"clear">',
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search by domain name"
            },
            pagingType: 'simple_numbers',
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": "Prev",
                    "sNext": "Next"
                }
            },
            // Disable sorting
            "sort": false,
            pageLength: 20
        });
</script>
@endpush