@extends('layouts.app')

@section('content')
<div>
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Show Invoice</h3>
        <a href="{{ route('admin.order') }}" class="panelHeaderBtn">
            <i class="fa-solid fa-list-check"></i>
            All Order

        </a>
    </div>

    <div class="bg-[#3A9CFD05] m-4 border rounded">
        <div
            class="flex items-start justify-between p-5 md:py-6 md:px-8 bg-darkblue text-white text-xl md:text-3xl font-medium rounded-t border border-darkblue font-inter">
            <h4>
                Invoice
                <span class="text-red-600" style="font-size: 50%;">{{ $orderInfo->status != 'paid' ? '( ' .
                    strFilter($orderInfo->status) . ' )' : '' }}</span>
            </h4>
            <h4>Order No. #<span style="font-size: 70%;">{{ $orderInfo->order_no }}</span>

        </div>
        <div class="py-5 md:py-10 px-4 md:px-[30px] rounded-[0_0_4px_4px] font-poppins">
            <div class="grid md:grid-cols-2 xl:grid-cols-12 gap-8 md:gap-4 xl:gap-0 mb-10">
                {{-- billing from --}}

                <div class="xl:col-start-1 xl:col-end-5">
                    <p class="text-secondary font-medium">Order Form</p>
                    {{-- logo --}}
                    {{-- <img src="{{asset('public')}}/frontend/images/logo.png" alt="Logo" height="34"> --}}
                    <h3 class="mb-5 text-2xl xl:text-3xl font-bold text-black ">{{$siteInfo->site_name}}</h3>

                    <div class="space-y-2 text-[#606060] text-lg text-medium ">

                        {{-- <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                            <span class="whitespace-nowrap text-[#333] font-medium leading-1.6">
                                Name :
                            </span>
                            <span>
                                {{ strFilter('owner of this website') }}
                            </span>
                        </p> --}}

                        <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                            <span class="whitespace-nowrap text-[#333] font-medium leading-1.6">
                                Email :
                            </span>
                            <span>
                                {{ $siteInfo->email }}
                            </span>
                        </p>

                        <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                            <span class="whitespace-nowrap text-[#333] font-medium leading-1.6">
                                Mobile :
                            </span>
                            <span>
                                {{ $siteInfo->mobile }}
                            </span>
                        </p>

                        <p class="flex gap-3 items-start text-[#606060] leading-1.6 font-normal">
                            <span class="text-[#333] whitespace-nowrap font-medium leading-1.6">
                                Address :
                            </span>
                            <span>
                                {{ $siteInfo->location }}
                            </span>
                        </p>

                        {{-- <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                            <span class="whitespace-nowrap text-[#333] font-medium leading-1.6">
                                Ref. Code :
                            </span>
                            <span>
                                {{ $orderInfo->ref_no }}
                            </span>
                        </p> --}}

                        <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                            <span class="whitespace-nowrap text-[#333] font-medium leading-1.6">
                                Date :
                            </span>
                            <span>
                                {{ !empty($orderInfo->created) ? date('d F, Y', strtotime($orderInfo->created)) : '' }}
                            </span>
                        </p>

                    </div>
                </div>
                {{-- billing to --}}
                <div class="xl:col-start-9 xl:col-end-[-1]">
                    <p class="text-secondary font-medium">Order To</p>
                    {{-- logo --}}

                    {{-- <img src="" alt=""> --}}
                    @if (!empty($orderInfo->company))
                    <h3 class="my-5 text-3xl font-bold text-black ">
                        {{ !empty($orderInfo->company) ? strFilter($orderInfo->company) : '' }}</h3>
                    @endif

                    <div class="space-y-2 text-[#606060] text-lg text-medium ">

                        @if (!empty($orderInfo->customer->full_name))
                        <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                            <span class="whitespace-nowrap text-[#333] font-medium leading-1.6">
                                Name :
                            </span>
                            <span>
                                {{ !empty($orderInfo->customer->full_name) ? strFilter($orderInfo->customer->full_name)
                                : 'N/A' }}
                            </span>
                        </p>
                        @endif

                        @if (!empty($orderInfo->email))
                        <p class="flex md:flex-wrap gap-x-3 items-start text-[#606060] leading-[150%] font-normal">
                            <span class="whitespace-nowrap text-[#333] font-medium leading-1.6">
                                Email :
                            </span>
                            <a href="mailto:{{ !empty($orderInfo->email) ? $orderInfo->email : 'N/A' }}">{{
                                !empty($orderInfo->email) ? $orderInfo->email : 'N/A' }}</a>
                        </p>
                        @endif

                        @if (!empty($orderInfo->mobile))
                        <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                            <span class="whitespace-nowrap text-[#333] font-medium leading-1.6">
                                Mobile :
                            </span>
                            <a href="tel:{{ !empty($orderInfo->mobile) ? $orderInfo->mobile : 'N/A' }}">{{
                                !empty($orderInfo->mobile) ? $orderInfo->mobile : 'N/A' }}</a>
                        </p>
                        @endif

                        @if (!empty($orderInfo->address))
                        <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                            <span class="whitespace-nowrap text-[#333] font-medium leading-1.6">
                                Address :
                            </span>
                            <span>
                                {{ !empty($orderInfo->address) ? $orderInfo->address : 'N/A' }}
                            </span>
                        </p>
                        @endif

                        @if (!empty($orderInfo->delivery_date))
                        <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                            <span class="whitespace-nowrap text-[#333] font-medium leading-1.6">
                                Date :
                            </span>
                            <span>
                                {{ !empty($orderInfo->delivery_date) ? date('d F, Y',
                                strtotime($orderInfo->delivery_date)) : 'N/A' }}
                            </span>
                        </p>
                        @endif

                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="table">

                    <thead class="bg-darkblue rounded-[4px_4px_0_0]">

                        <tr>
                            <th class="border border-[#C5CAE9] text-[#fff] px-5 py-3 font-normal text-sm">
                                Live URL
                            </th>

                            <th class="border border-[#C5CAE9] text-[#fff] px-5 py-3 font-normal text-sm text-center"
                                width="150">
                                Price
                            </th>

                            <th class="border border-[#C5CAE9] text-[#fff] px-5 py-3 font-normal text-sm text-center"
                                width="150">
                                Other Price
                            </th>

                            <th class="border border-[#C5CAE9] text-[#fff] px-5 py-3 font-normal text-sm text-center whitespace-nowrap"
                                width="150">
                                Article Writing
                            </th>

                            <th class="border border-[#C5CAE9] text-[#fff] pl-5 pr-28 py-3 font-normal text-sm leading-[160%]"
                                width="150">
                                Amount
                            </th>
                        </tr>

                    </thead>


                    {{-- <tbody class="table-body "> --}}
                    <tbody class="table-body text-[#555] font-normal leading-[160%] bg-[#fff] text-lg">

                        @foreach ($orderInfo->orderItem as $key => $row)
                        <tr class="border border-[#C5CAE9] px-5 py-3">
                            <td class="border border-[#C5CAE9] px-5 py-3">
                                <h4 class="text-[#333] text-lg font-medium leading-[150%] ">
                                    {{ $row->live_url }}
                                </h4>
                            </td>

                            <td class="border border-[#C5CAE9] px-5 py-3 text-center">
                                {{ sprintf("$%0.2f", $row->url_price) }}
                            </td>

                            <td class="border border-[#C5CAE9] px-5 py-3 text-center">
                                {{ sprintf("$%0.2f", $row->other_price) }}
                            </td>

                            <td class="border border-[#C5CAE9] px-5 py-3 text-center">
                                {{ sprintf("$%0.2f", $row->artical) }}
                            </td>

                            <td class="border border-[#C5CAE9] px-5 py-3 text-center">
                                <span>{{ sprintf("$%0.2f", $row->total) }}</span>
                            </td>
                        </tr>
                        @endforeach

                        <tr class="border border-[#C5CAE9] px-5 py-3">
                            <th rowspan="5" colspan="2" class="border border-[#C5CAE9] text-[#9FA8DA] text-xl">
                                {{ strFilter($orderInfo->status) }}
                            </th>

                            <th colspan="2" class="text-right border border-[#C5CAE9] px-5 py-3 text-[#333] text-xl">
                                Subtotal
                            </th>

                            <td class="text-[#333] text-xl border border-[#C5CAE9] px-5 py-3 text-center">
                                <span>{{ sprintf("$%0.2f", $orderInfo->subtotal) }}</span>
                            </td>

                        </tr>

                        <tr class="border border-[#C5CAE9] px-5 py-3">
                            <th colspan="2" class="text-right border border-[#C5CAE9] px-5 py-3 text-[#333] text-xl">
                                Service Charge
                            </th>

                            <td class="text-[#333] text-xl border border-[#C5CAE9] px-5 py-3 text-center">
                                <span>{{ sprintf("$%0.2f", $orderInfo->service_charge) }}</span>
                            </td>
                        </tr>

                        <tr class="border border-[#C5CAE9] px-5 py-3">
                            <th colspan="2" class="text-right border border-[#C5CAE9] px-5 py-3 text-[#333] text-xl">
                                Tax
                            </th>

                            <td class="text-[#333] text-xl border border-[#C5CAE9] px-5 py-3 text-center">
                                <span>{{ sprintf("$%0.2f", $orderInfo->tax) }}</span>
                            </td>
                        </tr>

                        <tr class="border border-[#C5CAE9] px-5 py-3">
                            <th colspan="2" class="text-right border border-[#C5CAE9] px-5 py-3 text-[#333] text-xl">
                                Discount
                            </th>

                            <td class="text-[#333] text-xl border border-[#C5CAE9] px-5 py-3 text-center">
                                <span>{{ sprintf("$%0.2f", $orderInfo->discount) }}</span>
                            </td>
                        </tr>

                        <tr class=" border-[#C5CAE9] px-5 py-3 font-semibold md:font-bold text-[30px] leading-[100%]">
                            <td colspan="2" class="text-right border border-[#C5CAE9] px-5 pt-3 pb-5 text-darkblue">
                                Total
                            </td>

                            <td class="border border-[#C5CAE9] px-5 pt-3 pb-5 text-darkblue text-center">
                                <span>{{ sprintf("$%0.2f", $orderInfo->grand_total) }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('headerPartial')
@endpush

@push('footerPartial')
<script>
    function copyText() {
            var button = document.querySelector('button[data-tooltip="Copy invoice Link"]');
            button.setAttribute('data-tooltip', 'Copying...');

            // Get the value from the hidden input
            var copyText = document.getElementById("copyUrl").value;

            // Check if the browser supports the Clipboard API
            if (navigator.clipboard) {
                // Copy text to clipboard
                navigator.clipboard.writeText(copyText)
                    .then(function() {
                        // Set tooltip to "Copied" temporarily
                        button.setAttribute('data-tooltip', 'Copied');
                        setTimeout(function() {
                            // Reset tooltip after a delay
                            button.setAttribute('data-tooltip', 'Copy invoice Link');
                        }, 2000); // Delay in milliseconds
                    })
                    .catch(function(err) {
                        // Handle errors
                        console.error('Failed to copy text: ', err);
                        button.setAttribute('data-tooltip', 'Copy failed');
                    });
            } else {
                // Fallback for browsers that don't support Clipboard API
                var textarea = document.createElement('textarea');
                textarea.value = copyText;
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);

                // Set tooltip to "Copied" temporarily
                button.setAttribute('data-tooltip', 'Copied');
                setTimeout(function() {
                    // Reset tooltip after a delay
                    button.setAttribute('data-tooltip', 'Copy invoice Link');
                }, 2000); // Delay in milliseconds
            }
        }

        function outFunc() {
            var button = document.querySelector('button[data-tooltip="Copying..."]');
            if (button) {
                // Reset tooltip if copying is in progress
                button.setAttribute('data-tooltip', 'Copy invoice Link');
            }
        }
</script>
@endpush
