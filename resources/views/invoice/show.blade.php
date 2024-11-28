@extends('layouts.app')

@section('content')

<div class="panelHeader">
    <h3 class="panelHeaderTitle">Show Invoice</h3>

    <a href="{{ route('admin.invoice') }}" class="button">

        <i class="fa-solid fa-list-check"></i>
        All Invoice
    </a>

</div>

<div class="bg-[#3A9CFD05] m-4 border rounded">
    <div
        class="flex items-start justify-between py-6 px-8 bg-darkblue text-[#fff] text-xl md:text-3xl font-medium rounded-[4px_4px_0_0] border border-darkblue font-inter">

        <h4>
            Invoice
        </h4>

        <h4>
            Invoice No. #<span style="font-size: 70%;">{{ !empty($invoiceInfo->invoice_no) ? $invoiceInfo->invoice_no :
                '' }}</span>
        </h4>
    </div>

    <div class="py-5 md:py-10 px-4 md:px-[30px] rounded-[0_0_4px_4px] font-poppins">
        <div class="grid md:grid-cols-2 xl:grid-cols-12 gap-8 md:gap-4 xl:gap-0 mb-10">
            {{-- billing from --}}

            <div class="xl:col-start-1 xl:col-end-5">
                <p class="text-secondary font-medium">Order Form:</p>
                {{-- logo --}}
                {{-- <img src="{{asset('public')}}/frontend/images/logo.png" alt="Logo" height="34"> --}}

                <h3 class="mb-5 text-2xl xl:text-3xl font-bold text-black ">{{$siteInfo->site_name}}</h3>

                <div class="space-y-2 text-[#606060] text-lg text-medium ">

                    {{-- <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                        <span class="text-[#333] font-medium leading-1.6 whitespace-nowrap">
                            Name:
                        </span>
                        <span>
                            {{ strFilter('owner of this website') }}
                        </span>
                    </p> --}}

                    <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                        <span class="text-[#333] font-medium leading-1.6 whitespace-nowrap">
                            Email:
                        </span>
                        <span>
                            {{ !empty($siteInfo->email) ? $siteInfo->email : 'N/A' }}
                        </span>
                    </p>

                    <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                        <span class="text-[#333] font-medium leading-1.6 whitespace-nowrap">
                            Mobile:
                        </span>
                        <span>
                            {{ !empty($siteInfo->mobile) ? $siteInfo->mobile : 'N/A' }}
                        </span>
                    </p>

                    <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                        <span class="text-[#333] font-medium leading-1.6 whitespace-nowrap">
                            USA Address:
                        </span>
                        <span>
                            {{ !empty($siteInfo->us_location) ? $siteInfo->us_location : 'N/A' }}
                        </span>
                    </p>

                    <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                        <span class="text-[#333] font-medium leading-1.6 whitespace-nowrap">
                            BD Address:
                        </span>
                        <span>
                            {{ !empty($siteInfo->location) ? $siteInfo->location : 'N/A' }}
                        </span>
                    </p>
                </div>
            </div>

            {{-- billing to --}}
            <div class="xl:col-start-9 xl:col-end-[-1]">
                <p class="text-secondary font-medium">Order To:</p>

                @if (!empty($invoiceInfo->customer->company_name))
                <h3 class="my-5 text-3xl font-bold text-black ">
                    {{ !empty($invoiceInfo->customer->company_name) ? $invoiceInfo->customer->company_name : '' }}
                </h3>
                @endif

                <div class="space-y-2 text-[#606060] text-lg text-medium">

                    @if (!empty($invoiceInfo->customer->full_name))
                    <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                        <span class="text-[#333] font-medium leading-1.6 whitespace-nowrap">
                            Name:
                        </span>
                        {{ !empty($invoiceInfo->customer->full_name) ? strFilter($invoiceInfo->customer->full_name) :
                        'N/A' }}
                    </p>
                    @endif

                    @if (!empty($invoiceInfo->email))
                    <p class="flex gap-x-3 md:flex-wrap items-start text-[#606060] leading-[150%] font-normal">
                        <span class="text-[#333] font-medium leading-1.6 whitespace-nowrap">
                            Email:
                        </span>
                        <a href="mailto:{{ $invoiceInfo->email }}">{{ !empty($invoiceInfo->email) ? $invoiceInfo->email
                            : 'N/A' }}</a>
                    </p>
                    @endif

                    @if (!empty($invoiceInfo->customer->phone))
                    <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                        <span class="text-[#333] font-medium leading-1.6 whitespace-nowrap">
                            Mobile:
                        </span>
                        <a
                            href="tel:{{ !empty($invoiceInfo->customer->phone) ? $invoiceInfo->customer->phone : 'N/A' }}">
                            {{ !empty($invoiceInfo->customer->phone) ? $invoiceInfo->customer->phone : 'N/A' }}
                        </a>
                    </p>
                    @endif

                    @if (!empty($invoiceInfo->customer->address))
                    <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                        <span class="text-[#333] font-medium leading-1.6 whitespace-nowrap">
                            Address:
                        </span>
                        {{ !empty($invoiceInfo->customer->address) ? $invoiceInfo->customer->address : 'N/A' }}
                    </p>
                    @endif

                    {{-- <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                        <span class="text-[#333] font-medium leading-1.6 whitespace-nowrap">
                            Country:
                        </span>
                        @if (!empty($invoiceInfo->customer->country_id))
                        @php($countryName = $countryList->where('id', $invoiceInfo->customer->country_id)->first())
                        {{ $countryName->name }}
                        @endif
                    </p> --}}

                    {{-- <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                        <span class="text-[#333] font-medium leading-1.6 whitespace-nowrap">
                            Tax Code:
                        </span>
                        {{ (!empty($invoiceInfo->customer->tax_code) ? $invoiceInfo->customer->tax_code : "") }}
                    </p> --}}

                    {{-- <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                        <span class="text-[#333] font-medium leading-1.6 whitespace-nowrap">
                            Ref. Code:
                        </span>
                        {{ (!empty($invoiceInfo->ref_code) ? $invoiceInfo->ref_code : "") }}
                    </p> --}}

                    @if (!empty($invoiceInfo->created))
                    <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                        <span class="text-[#333] font-medium leading-1.6 whitespace-nowrap">
                            Invoice Date:
                        </span>
                        <span>
                            {{ !empty($invoiceInfo->created) ? date('d F, Y', strtotime($invoiceInfo->created)) : 'N/A'
                            }}
                        </span>
                    </p>
                    @endif

                    @if (!empty($invoiceInfo->payment_date))
                    <p class="flex gap-3 items-start text-[#606060] leading-[150%] font-normal">
                        <span class="text-[#333] font-medium leading-1.6 whitespace-nowrap">
                            Paid Date:
                        </span>
                        <span>
                            {{ !empty($invoiceInfo->payment_date) ? date('d F, Y',
                            strtotime($invoiceInfo->payment_date)) : 'N/A' }}
                        </span>
                    </p>
                    @endif

                </div>
            </div>
        </div>

        <div class="overflow-x-auto">

            @if (!empty($orderList) && $orderList->isNotEmpty())
            <table class="w-full">
                <thead class="bg-darkblue text-black rounded-[4px_4px_0_0] whitespace-nowrap">
                    <tr>
                        <th rowspan="2"
                            class="border w-[200px] border-[#C5CAE9] text-[#fff] px-5 py-3 font-normal text-sm ">
                            Order ID
                        </th>

                        <th rowspan="2"
                            class="border w-[200px] border-[#C5CAE9] text-[#fff] px-5 py-3 font-normal text-sm ">
                            Date
                        </th>

                        <th colspan="2" class="border border-[#C5CAE9] text-[#fff] px-5 py-3 font-normal text-sm">
                            Billing On
                        </th>
                    </tr>
                    <tr>
                        <th class="border !text-left border-[#C5CAE9] text-[#fff] px-5 py-3 font-normal text-sm">
                            Live Link
                        </th>
                        <th class="border !text-right border-[#C5CAE9] text-[#fff] px-5 py-3 font-normal text-sm">
                            Total
                        </th>
                    </tr>
                </thead>

                <tbody class="table-body text-[#555] font-normal leading-[160%] bg-[#fff] text-lg">
                    @foreach ($orderList as $key => $order)
                    <tr class="border border-[#C5CAE9] px-5 py-3">
                        <td class="border border-[#C5CAE9] px-5 py-3 whitespace-nowrap">
                            #{{ !empty($order->order_no) ? $order->order_no : '' }}
                        </td>
                        <td class="border border-[#C5CAE9] px-5 py-3 whitespace-nowrap">
                            {{ !empty($order->created) ? date('d F, Y', strtotime($order->created)) : '' }}
                        </td>
                        <td colspan="2">
                            <table class="w-full">
                                <tbody class="table-body text-[#555] font-normal leading-[160%] bg-[#fff] text-sm">
                                    <tr class="border border-[#C5CAE9] px-5">
                                        <td colspan="2" class="border border-[#C5CAE9] px-5 py-1">
                                            {{ $order->billType?->name }}
                                            @if (!empty($order->orderItem))
                                            @php($itemQty = count($order->orderItem))
                                            @for ($i = 0; $i < $itemQty; $i++) <?php $mainUrl=parse_url($order->
                                                orderItem[$i]->url);
                                                echo $mainUrl['host'];
                                                ?>,
                                                @endfor
                                                @endif
                                        </td>
                                    </tr>

                                    @if (!empty($order->orderItem))
                                    @foreach ($order->orderItem as $row => $items)
                                    <tr class="border border-[#C5CAE9] px-5">
                                        <td class="border border-[#C5CAE9] px-5 py-1">
                                            {{ $items->url }}
                                        </td>

                                        <td class="border border-[#C5CAE9] text-right px-5 py-1 w-[150px]">
                                            {{ sprintf("$%0.2f", $items->total) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif

                                    <tr class="border border-[#C5CAE9] px-5">
                                        <th class="text-right border border-[#C5CAE9] px-5 py-1 text-[#333]">
                                            Subtotal
                                        </th>

                                        <th class="border border-[#C5CAE9] text-right px-5 py-1">
                                            {{ sprintf("$%0.2f", $order->subtotal) }}
                                        </th>
                                    </tr>

                                    <tr class="border border-[#C5CAE9] px-5">
                                        <th class="text-right border border-[#C5CAE9] px-5 py-1 text-[#333]">
                                            Service Charge
                                        </th>

                                        <th class="border border-[#C5CAE9] text-right px-5 py-1">
                                            {{ sprintf("$%0.2f", $order->service_charge) }}
                                        </th>
                                    </tr>

                                    <tr class="border border-[#C5CAE9] px-5">
                                        <th class="text-right border border-[#C5CAE9] px-5 py-1 text-[#333]">
                                            Tax
                                        </th>

                                        <th class="border border-[#C5CAE9] text-right px-5 py-1">
                                            {{ sprintf("$%0.2f", $order->tax) }}
                                        </th>
                                    </tr>

                                    <tr class="border border-[#C5CAE9] px-5">
                                        <th class="text-right border border-[#C5CAE9] px-5 py-1 text-[#333]">
                                            Discount
                                        </th>

                                        <th class="border border-[#C5CAE9] text-right px-5 py-1">
                                            {{ sprintf("$%0.2f", $order->discount) }}
                                        </th>
                                    </tr>

                                    <tr class="border border-[#C5CAE9] px-5">
                                        <th class="text-right border border-[#C5CAE9] px-5 py-1 text-[#333]">
                                            Grand Total
                                        </th>

                                        <th class="border border-[#C5CAE9] text-right px-5 py-1">
                                            {{ sprintf("$%0.2f", $order->grand_total) }}
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <th rowspan="3" colspan="2"
                            class=" text-[#9FA8DA] border border-[#C5CAE9] text-lg md:text-xl px-2 py-3">
                            {{ !empty($invoiceInfo->status) ? strFilter($invoiceInfo->status) : '' }}
                        </th>

                        <th class="text-right border border-[#C5CAE9] px-5 py-3 text-[#333] text-lg md:text-xl">
                            Subtotal
                        </th>

                        <td
                            class="text-[#333] text-lg md:text-xl border border-[#C5CAE9] text-right px-5 py-3 w-[150px]">
                            <span>{{ sprintf("$%0.2f", $invoiceInfo->subtotal) }}</span>
                        </td>
                    </tr>

                    <tr class="border border-[#C5CAE9] px-5 py-3">
                        <th class="text-right border border-[#C5CAE9] px-5 py-3 text-[#333] text-lg md:text-xl">
                            Discount
                        </th>

                        <td class="text-[#333] text-lg md:text-xl border border-[#C5CAE9] text-right px-5 py-3">
                            <span>{{ sprintf("$%0.2f", $invoiceInfo->discount) }}</span>
                        </td>
                    </tr>

                    <tr
                        class=" border-[#C5CAE9] px-5 py-3 font-semibold md:font-bold text-2xl md:text-[30px] leading-[100%]">
                        <td class="text-right border border-[#C5CAE9] px-5 pt-3 pb-5 text-darkblue">
                            Total
                        </td>

                        <td class="border border-[#C5CAE9] px-5 pt-3 pb-5 text-right text-darkblue">
                            <span>{{ sprintf("$%0.2f", $invoiceInfo->grand_total) }}</span>
                        </td>
                    </tr>
                </tbody>

            </table>
            @endif
        </div>
    </div>
</div>


<div class="flex flex-wrap gap-1 md:gap-4 py-3 px-8 items-start mt-5">

    <a href="{{ url('download-invoice', $invoiceInfo->ref_code) }}" target="_blank"
        class="py-3 px-2 bg-secondary text-center md:w-72 rounded text-white ">
        Download as PDF
    </a>

    @if ($invoiceInfo->status != 'complete')
    <a href="{{ route('admin.invoice.edit', $invoiceInfo->id) }}"
        class="py-3 px-2 bg-darkblue text-center md:w-72 rounded text-white ">
        Edit Again
    </a>
    @endif

    <input type="hidden" value="{{ url('invoice', $invoiceInfo->ref_code) }}" id="copyUrl">

    <button onclick="copyText()" onmouseout="outFunc()" tooltip data-tooltip="Copy invoice Link"
        class="py-[11px] px-2 border border-darkblue text-black md:w-72 rounded ">
        Copy invoice
    </button>
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
                    }).catch(function(err) {
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