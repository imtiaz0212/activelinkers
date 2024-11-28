@extends('layouts.frontend')
@section('content')
@include('layouts.frontend-partial.breadcrumb')

@php($siteInfo = getSiteInfo())

<section class="container">
    <div class="sectionGap">
        <div class="bg-[#3A9CFD05]">
            <div
                class="flex items-start justify-between py-6 px-8 bg-darkblue text-[#fff] text-3xl font-medium rounded-[4px_4px_0_0] border border-darkblue font-inter">

                <h4 style="color: white !important;">
                    Invoice
                    <span class="text-red-600" style="font-size: 50%;">{{ (($orderInfo->status != "complete") ? '( ' .
                        strFilter($orderInfo->status) . ' )' : '') }}</span>
                </h4>
                <h4 style="color: white !important;">Order No. #<span style="font-size: 70%;">{{ $orderInfo->order_id
                        }}</span>

            </div>
            <div class="py-10 px-[30px] rounded-[0_0_4px_4px] font-poppins">

                <div class="grid grid-cols-12 justify-items-center mb-10">
                    {{-- billing from --}}

                    <div class="col-start-1 col-end-5">
                        <p class="text-[#5A4DC8] font-medium">Order Form:</p>
                        {{-- logo --}}
                        {{-- <img src="{{ asset('public') }}/frontend/images/logo.png" alt="Logo" height="34"> --}}
                        <h3 class="my-5 text-3xl font-bold text-black ">{{ strFilter($siteInfo->site_name) }}</h3>

                        <div class="space-y-2 text-[#606060] text-lg text-medium ">

                            <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                                <span class="text-[#333] font-medium leading-[160%]">
                                    Name:
                                </span>
                                <span>
                                    {{ strFilter('owner of this website') }}
                                </span>
                            </p>

                            <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                                <span class="text-[#333] font-medium leading-[160%]">
                                    Email:
                                </span>
                                <span>
                                    {{ $siteInfo->email }}
                                </span>
                            </p>

                            <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                                <span class="text-[#333] font-medium leading-[160%]">
                                    Mobile:
                                </span>
                                <span>
                                    {{ $siteInfo->mobile }}
                                </span>
                            </p>

                            <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                                <span class="text-[#333] font-medium leading-[160%]">
                                    Address:
                                </span>
                                <span>
                                    {{ $siteInfo->location }}
                                </span>
                            </p>

                            <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                                <span class="text-[#333] font-medium leading-[160%]">
                                    Date:
                                </span>
                                <span>
                                    {{ !empty($orderInfo->created) ? date('M d, Y', strtotime($orderInfo->created)) : ''
                                    }}
                                </span>
                            </p>

                        </div>
                    </div>

                    {{-- billing to --}}
                    <div class="col-start-9 col-end-[-1]">
                        <p class="text-[#5A4DC8]">Order To:</p>
                        {{-- logo --}}

                        @php($fullName = ((!empty($orderInfo->first_name) ? $orderInfo->first_name : '') .
                        (!empty($orderInfo->last_name) ? ' ' . $orderInfo->last_name : '')))

                        @php($address = ((!empty($orderInfo->house_no) ? $orderInfo->house_no : '') .
                        (!empty($orderInfo->apartment) ? '/' . $orderInfo->apartment : '') . (!empty($orderInfo->state)
                        ? ', ' . $orderInfo->state : '') . (!empty($orderInfo->city) ? ', ' . $orderInfo->city : '') .
                        (!empty($orderInfo->country) ? ', ' . $orderInfo->country : '') . (!empty($orderInfo->zip_code)
                        ? ' - ' . $orderInfo->zip_code : '')))

                        {{-- <img src="" alt=""> --}}
                        <h3 class="my-5 text-3xl font-bold text-black ">{{ strFilter($orderInfo->company) }}</h3>
                        <div class="space-y-2 text-[#606060] text-lg text-medium ">

                            <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                                <span class="text-[#333] font-medium leading-[160%]">
                                    Name:
                                </span>
                                <span>
                                    {{ strFilter($fullName) }}
                                </span>
                            </p>

                            <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                                <span class="text-[#333] font-medium leading-[160%]">
                                    Email:
                                </span>
                                <a href="mailto:{{ $orderInfo->email }}">{{ $orderInfo->email }}</a>
                            </p>

                            <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                                <span class="text-[#333] font-medium leading-[160%]">
                                    Mobile:
                                </span>
                                <a href="tel:{{ $orderInfo->mobile }}">{{ $orderInfo->mobile }}</a>
                            </p>

                            <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                                <span class="text-[#333] font-medium leading-[160%]">
                                    Address:
                                </span>
                                <span>
                                    {{ $address }}
                                </span>
                            </p>

                            <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                                <span class="text-[#333] font-medium leading-[160%]">
                                    Date:
                                </span>
                                <span>
                                    {{ !empty($orderInfo->created) ? date('M d, Y', strtotime($orderInfo->created)) : ''
                                    }}
                                </span>
                            </p>

                        </div>
                    </div>
                </div>
                <table class="w-full rounded-[4px_4px_0_0] ">

                    <thead class="bg-darkblue text-black rounded-[4px_4px_0_0] whitespace-nowrap">

                        <th class="border border-[#C5CAE9] text-[#fff] px-5 py-3 font-normal text-sm">
                            Name Of Service
                        </th>

                        <th class="border border-[#C5CAE9] text-[#fff] px-5 py-3 font-normal text-sm text-center"
                            width="150">
                            Price
                        </th>

                        <th class="border border-[#C5CAE9] text-[#fff] px-5 py-3 font-normal text-sm text-center"
                            width="150">
                            Other Price
                        </th>

                        <th class="border border-[#C5CAE9] text-[#fff] pl-5 pr-28 py-3 font-normal text-sm leading-[160%]"
                            width="150">
                            Amount
                        </th>

                    </thead>

                    {{-- <tbody class="table-body "> --}}
                    <tbody class="table-body text-[#555] font-normal leading-[160%] bg-[#fff] text-lg">

                        <tr class="border border-[#C5CAE9] px-5 py-3">
                            <td class="border border-[#C5CAE9] px-5 py-3">
                                <h4 class="text-[#333] text-lg font-medium leading-[150%] ">
                                    {{ $orderInfo->service_category_name }} -
                                    <small>
                                        <a href="{{ url('service', $orderInfo->page_url) }}" target="_blank"
                                            class="px-1 py-[2px] rounded text-error bg-error/10 whitespace-nowrap">
                                            {{ $orderInfo->title }}
                                        </a>
                                    </small>
                                </h4>

                            </td>
                            <td class="border border-[#C5CAE9] px-5 py-3 text-center">{{ $orderInfo->package_amount }}
                            </td>
                            <td class="border border-[#C5CAE9] px-5 py-3 text-center">{{ $orderInfo->other_price }}</td>
                            <td class="border border-[#C5CAE9] px-5 py-3">$<span>{{ $orderInfo->subtotal }}</span></td>
                        </tr>

                        <tr class="border border-[#C5CAE9] px-5 py-3">
                            <th rowspan="4" class="border border-[#C5CAE9]"></th>
                            <th colspan="2" class="text-right border border-[#C5CAE9] px-5 py-3 text-[#333] text-xl">
                                Service Charge ({{ round($orderInfo->service_charge , 2) }}%)
                            </th>
                            <td class="text-[#333] text-xl border border-[#C5CAE9] px-5 py-3">
                                $<span>{{ $orderInfo->total_service_charge }}</span>
                            </td>
                        </tr>

                        <tr class="border border-[#C5CAE9] px-5 py-3">
                            <th colspan="2" class="text-right border border-[#C5CAE9] px-5 py-3 text-[#333] text-xl">
                                Tax ({{ round($orderInfo->tax , 2) }}%)
                            </th>
                            <td class="text-[#333] text-xl border border-[#C5CAE9] px-5 py-3">
                                $<span>{{ $orderInfo->total_tax }}</span>
                            </td>
                        </tr>

                        <tr class="border border-[#C5CAE9] px-5 py-3">
                            <th colspan="2" class="text-right border border-[#C5CAE9] px-5 py-3 text-[#333] text-xl">
                                Discount ({{ round($orderInfo->discount , 2) }}%)
                            </th>
                            <td class="text-[#333] text-xl border border-[#C5CAE9] px-5 py-3">
                                $<span>{{ $orderInfo->total_discount }}</span>
                            </td>
                        </tr>

                        <tr class=" border-[#C5CAE9] px-5 py-3 text-[28px] leading-[100%]">
                            <th colspan="2"
                                class="text-right border border-[#C5CAE9] font-bold px-5 pt-3 pb-5 text-darkblue">Total
                            </th>
                            <td class="border border-[#C5CAE9] font-bold px-5 pt-3 pb-5 text-darkblue">$<span>{{
                                    $orderInfo->total_amount }}</span></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex gap-4 py-3 px-8 items-start mt-5">

            <input type="hidden" value="{{ url('invoice', $orderInfo->order_no) }}" id="copyUrl">

            {{-- <a href="{{ url('invoice', $orderInfo->order_no) }}" target="_blank"
                class="py-3 text-center bg-primary w-[281px] rounded">
                Show invoice
            </a> --}}

            <a href="{{ url('download', $orderInfo->order_no) }}" target="_blank"
                class="py-3 bg-secondary text-center w-[281px] rounded text-white">
                Download as PDF
            </a>

            @if ($orderInfo->status != 'complete')
            <a href="{{ route('user.order.edit', $orderInfo->id) }}"
                class="py-3 bg-darkblue text-center w-[281px] rounded text-white">
                Edit Again
            </a>
            @endif

            <button onclick="copyText()" onmouseout="outFunc()" data-tooltip-target="tooltip-default"
                class="py-[11px] border border-darkblue text-black w-[281px] rounded">
                Copy invoice Link
            </button>

            <div id="tooltip-default" role="tooltip"
                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Copy invoice Link
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>

        </div>
    </div>
</section>

@include('layouts.frontend-partial.cta-area')
@endsection
@push('headerPartial')

@endpush

@push('footerPartial')
<script>
    function copyText() {
        var copyText = document.getElementById("copyUrl");
        var tooltip = document.getElementById("tooltip-default");

        copyText.select();
        navigator.clipboard.writeText(copyText.value);

        tooltip.innerHTML = 'Copied <div class="tooltip-arrow" data-popper-arrow></div>';
    }

    function outFunc() {
        var tooltip = document.getElementById("tooltip-default");
        tooltip.innerHTML ='Copy invoice Link <div class="tooltip-arrow" data-popper-arrow></div>';;
    }
</script>
@endpush