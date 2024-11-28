@extends('layouts.frontend')

@section('headerMeta')
<meta name="title" content="{{$siteInfo->site_name}} | Your Order Invoice Details">
@endsection

@section('content')

<?php
    $cardData = [
        [
            'title' => 'Invoice Issued date',
            'icon' => '<svg width="32" height="32" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M27.9184 5.85501V3.28922C27.9184 2.61487 27.3517 2.05566 26.6684 2.05566C25.985 2.05566 25.4184 2.61487 25.4184 3.28922V5.75632H14.585V3.28922C14.585 2.61487 14.0184 2.05566 13.335 2.05566C12.6517 2.05566 12.085 2.61487 12.085 3.28922V5.85501C7.58502 6.26619 5.40168 8.91422 5.06835 12.8451C5.03502 13.3221 5.43502 13.7168 5.90168 13.7168H34.1017C34.585 13.7168 34.985 13.3057 34.935 12.8451C34.6017 8.91422 32.4184 6.26619 27.9184 5.85501Z" fill="#00005C" /> <path d="M33.3333 16.1836H6.66667C5.75 16.1836 5 16.9237 5 17.8283V27.9599C5 32.8941 7.5 36.1836 13.3333 36.1836H26.6667C32.5 36.1836 35 32.8941 35 27.9599V17.8283C35 16.9237 34.25 16.1836 33.3333 16.1836ZM15.35 29.95C15.2667 30.0158 15.1833 30.0981 15.1 30.1474C15 30.2132 14.9 30.2625 14.8 30.2954C14.7 30.3448 14.6 30.3777 14.5 30.3941C14.3833 30.4106 14.2833 30.427 14.1667 30.427C13.95 30.427 13.7333 30.3777 13.5333 30.2954C13.3167 30.2132 13.15 30.0981 12.9833 29.95C12.6833 29.6375 12.5 29.2099 12.5 28.7823C12.5 28.3546 12.6833 27.927 12.9833 27.6145C13.15 27.4665 13.3167 27.3514 13.5333 27.2691C13.8333 27.1375 14.1667 27.1046 14.5 27.1704C14.6 27.1869 14.7 27.2198 14.8 27.2691C14.9 27.302 15 27.3514 15.1 27.4171C15.1833 27.4829 15.2667 27.5487 15.35 27.6145C15.65 27.927 15.8333 28.3546 15.8333 28.7823C15.8333 29.2099 15.65 29.6375 15.35 29.95ZM15.35 24.1935C15.0333 24.4895 14.6 24.6704 14.1667 24.6704C13.7333 24.6704 13.3 24.4895 12.9833 24.1935C12.6833 23.881 12.5 23.4533 12.5 23.0257C12.5 22.5981 12.6833 22.1704 12.9833 21.8579C13.45 21.3974 14.1833 21.2494 14.8 21.5125C15.0167 21.5948 15.2 21.7099 15.35 21.8579C15.65 22.1704 15.8333 22.5981 15.8333 23.0257C15.8333 23.4533 15.65 23.881 15.35 24.1935ZM21.1833 29.95C20.8667 30.2461 20.4333 30.427 20 30.427C19.5667 30.427 19.1333 30.2461 18.8167 29.95C18.5167 29.6375 18.3333 29.2099 18.3333 28.7823C18.3333 28.3546 18.5167 27.927 18.8167 27.6145C19.4333 27.006 20.5667 27.006 21.1833 27.6145C21.4833 27.927 21.6667 28.3546 21.6667 28.7823C21.6667 29.2099 21.4833 29.6375 21.1833 29.95ZM21.1833 24.1935C21.1 24.2593 21.0167 24.325 20.9333 24.3908C20.8333 24.4566 20.7333 24.506 20.6333 24.5389C20.5333 24.5882 20.4333 24.6211 20.3333 24.6375C20.2167 24.654 20.1167 24.6704 20 24.6704C19.5667 24.6704 19.1333 24.4895 18.8167 24.1935C18.5167 23.881 18.3333 23.4533 18.3333 23.0257C18.3333 22.5981 18.5167 22.1704 18.8167 21.8579C18.9667 21.7099 19.15 21.5948 19.3667 21.5125C19.9833 21.2494 20.7167 21.3974 21.1833 21.8579C21.4833 22.1704 21.6667 22.5981 21.6667 23.0257C21.6667 23.4533 21.4833 23.881 21.1833 24.1935ZM27.0167 29.95C26.7 30.2461 26.2667 30.427 25.8333 30.427C25.4 30.427 24.9667 30.2461 24.65 29.95C24.35 29.6375 24.1667 29.2099 24.1667 28.7823C24.1667 28.3546 24.35 27.927 24.65 27.6145C25.2667 27.006 26.4 27.006 27.0167 27.6145C27.3167 27.927 27.5 28.3546 27.5 28.7823C27.5 29.2099 27.3167 29.6375 27.0167 29.95ZM27.0167 24.1935C26.9333 24.2593 26.85 24.325 26.7667 24.3908C26.6667 24.4566 26.5667 24.506 26.4667 24.5389C26.3667 24.5882 26.2667 24.6211 26.1667 24.6375C26.05 24.654 25.9333 24.6704 25.8333 24.6704C25.4 24.6704 24.9667 24.4895 24.65 24.1935C24.35 23.881 24.1667 23.4533 24.1667 23.0257C24.1667 22.5981 24.35 22.1704 24.65 21.8579C24.8167 21.7099 24.9833 21.5948 25.2 21.5125C25.5 21.381 25.8333 21.3481 26.1667 21.4139C26.2667 21.4303 26.3667 21.4632 26.4667 21.5125C26.5667 21.5454 26.6667 21.5948 26.7667 21.6606C26.85 21.7264 26.9333 21.7921 27.0167 21.8579C27.3167 22.1704 27.5 22.5981 27.5 23.0257C27.5 23.4533 27.3167 23.881 27.0167 24.1935Z" fill="#00005C" /> </svg>',
            'value' =>  !empty($invoiceInfo->created) ? date('d F, Y', strtotime($invoiceInfo->created)) : '',
        ],
        [
            'title' => 'Invoice No',
            'icon' => '<svg width="32" height="32" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M23.9169 3.33325H16.0836C14.3503 3.33325 12.9336 4.73325 12.9336 6.46659V8.03325C12.9336 9.76659 14.3336 11.1666 16.0669 11.1666H23.9169C25.6503 11.1666 27.0503 9.76659 27.0503 8.03325V6.46659C27.0669 4.73325 25.6503 3.33325 23.9169 3.33325Z" fill="#00005C" /> <path d="M28.7344 8.0333C28.7344 10.6833 26.5677 12.85 23.9177 12.85H16.0844C13.4344 12.85 11.2677 10.6833 11.2677 8.0333C11.2677 7.09997 10.2677 6.51663 9.43437 6.94997C7.08437 8.19997 5.48438 10.6833 5.48438 13.5333V29.2166C5.48438 33.3166 8.83438 36.6666 12.9344 36.6666H27.0677C31.1677 36.6666 34.5177 33.3166 34.5177 29.2166V13.5333C34.5177 10.6833 32.9177 8.19997 30.5677 6.94997C29.7344 6.51663 28.7344 7.09997 28.7344 8.0333ZM25.5677 21.2166L18.901 27.8833C18.651 28.1333 18.3344 28.25 18.0177 28.25C17.701 28.25 17.3844 28.1333 17.1344 27.8833L14.6344 25.3833C14.151 24.9 14.151 24.1 14.6344 23.6166C15.1177 23.1333 15.9177 23.1333 16.401 23.6166L18.0177 25.2333L23.801 19.45C24.2844 18.9666 25.0844 18.9666 25.5677 19.45C26.051 19.9333 26.051 20.7333 25.5677 21.2166Z" fill="#00005C" /> </svg>',
            'value' =>  !empty($invoiceInfo->invoice_no) ? $invoiceInfo->invoice_no : '',
        ],
        [
            'title' => 'Ref Code',
            'icon' => '<svg width="32" height="32" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M34.9987 16.6667H4.9987C4.08203 16.6667 3.33203 17.4167 3.33203 18.3334V26.9834C3.33203 27.3168 3.3487 27.6501 3.38203 27.9834C3.71536 33.1168 6.88203 36.2834 12.0154 36.6167C12.3487 36.6501 12.682 36.6667 13.0154 36.6667H26.982C27.3154 36.6667 27.6487 36.6501 27.982 36.6167C33.1154 36.2834 36.282 33.1168 36.6154 27.9834C36.6487 27.6501 36.6654 27.3168 36.6654 26.9834V18.3334C36.6654 17.4167 35.9154 16.6667 34.9987 16.6667ZM13.332 26.9167C13.8987 27.7501 14.6654 28.4334 15.5487 28.8834C16.182 29.1834 16.432 29.9334 16.1154 30.5667C15.8987 31.0001 15.4487 31.2501 14.9987 31.2501C14.8154 31.2501 14.6154 31.2001 14.4487 31.1167C13.1487 30.4834 12.0487 29.5001 11.2654 28.3167C10.5987 27.3167 10.5987 26.0167 11.2654 25.0167C12.0487 23.8334 13.1487 22.8501 14.4487 22.2167C15.0654 21.9001 15.8154 22.1501 16.1154 22.7667C16.432 23.4001 16.182 24.1501 15.5487 24.4501C14.6654 24.9001 13.8987 25.5834 13.332 26.4167C13.232 26.5667 13.232 26.7667 13.332 26.9167ZM29.082 28.3167C28.282 29.5001 27.182 30.4834 25.8987 31.1167C25.7154 31.2001 25.532 31.2501 25.3487 31.2501C24.882 31.2501 24.4487 31.0001 24.232 30.5667C23.9154 29.9334 24.1654 29.1834 24.782 28.8834C25.682 28.4334 26.4487 27.7501 26.9987 26.9167C27.1154 26.7667 27.1154 26.5667 26.9987 26.4167C26.4487 25.5834 25.682 24.9001 24.782 24.4501C24.1654 24.1501 23.9154 23.4001 24.232 22.7667C24.532 22.1501 25.282 21.9001 25.8987 22.2167C27.182 22.8501 28.282 23.8334 29.082 25.0167C29.7487 26.0167 29.7487 27.3167 29.082 28.3167Z" fill="#00005C" /> <path d="M36.6654 13.0166V13.3333C36.6654 14.2499 35.9154 14.9999 34.9987 14.9999L4.9987 15.0166C4.08203 15.0166 3.33203 14.2666 3.33203 13.3499V13.0166C3.33203 12.6833 3.3487 12.3499 3.38203 12.0166C3.71536 6.88325 6.88203 3.71659 12.0154 3.38325C12.3487 3.34992 12.682 3.33325 13.0154 3.33325H26.982C27.3154 3.33325 27.6487 3.34992 27.982 3.38325C33.1154 3.71659 36.282 6.88325 36.6154 12.0166C36.6487 12.3499 36.6654 12.6833 36.6654 13.0166Z" fill="#00005C" /> </svg>',
            'value' =>  (!empty($invoiceInfo->ref_code) ? $invoiceInfo->ref_code : "") ,
        ],
    ];
?>

<header class="bg-[#F4FAFF]">
    <div class="container">
        <div class="logo flex justify-center items-center py-6">
            <a href="{{ route('home') }}">
                @php($logo = (!empty($siteInfo->logo) ? asset($siteInfo->logo) :
                'asset("public/frontend/images/linksposting.png")'))
                <img class="h-12 w-auto" src="{{ $logo }}"
                    alt="{{ (!empty( $siteInfo->site_name) ? $siteInfo->site_name : " Linksposting") }}">
            </a>
        </div>
    </div>
</header>

<section class="section_padding font-syne">
    <div class="container max-w-[1000px]">
        <div class="border border-[#D5E1FF]/40 rounded-[10px]">
            <div
                class="bg-[#18285D] rounded-t-[10px] border-[#D5E1FF] p-4 text-[#fff] text-[30px] text-center font-medium shadow-md">
                Invoice
            </div>

            {{-- Billing Details --}}
            <div class="grid lg:grid-cols-2 gap-7 lg:gap-0 py-4 md:py-5 lg:py-6">
                <div class="lg:border-e-2 px-5 md:px-6 lg:px-[30px]">
                    <h2 class="text-black text-xl md:text-2xl leading-none font-semibold mb-4">
                        Billing From
                    </h2>

                    <ul class="flex flex-col gap-0.5 md:gap-1 text-sm md:text-base lg:text-lg text-[#515151]">
                        <li class="flex items-start flex-col md:flex-row">
                            <span class="text-black shrink-0" style="width: 150px">Company Name </span>
                            <span class="flex-1 [text-indent:-8px] pl-1">: {{$siteInfo->site_name}}</span>
                        </li>

                        <li class="flex items-start flex-col md:flex-row">
                            <span class="text-black shrink-0" style="width: 150px">Email </span>
                            <span class="flex-1 [text-indent:-8px] pl-1">: {{ (!empty($siteInfo->email) ?
                                $siteInfo->email : "N/A") }}</span>
                        </li>

                        <li class="flex items-start flex-col md:flex-row">
                            <span class="text-black shrink-0" style="width: 150px">Phone </span>
                            <span class="flex-1 [text-indent:-8px] pl-1">: {{ (!empty($siteInfo->mobile) ?
                                $siteInfo->mobile : "N/A") }}</span>
                        </li>

                        <li class="flex items-start flex-col md:flex-row">
                            <span class="text-black shrink-0" style="width: 150px">Office Address </span>
                            <span class="flex-1 [text-indent:-8px] pl-1">: {{ (!empty($siteInfo->us_location) ?
                                $siteInfo->us_location : "N/A") }}</span>
                        </li>
                    </ul>
                </div>

                <div class=" px-5 md:px-6 lg:px-[30px]">
                    <h2 class="text-black text-xl md:text-2xl leading-none font-semibold mb-4">
                        Billing To
                    </h2>

                    <ul class="flex flex-col gap-0.5 md:gap-1 text-sm md:text-base lg:text-lg text-[#515151]">

                        @if(!empty($invoiceInfo->customer->full_name))
                        <li class="flex items-start flex-col md:flex-row">
                            <span class="text-black w-20 md:w-24 shrink-0">Name </span>
                            <span class="flex-1 [text-indent:-8px] pl-1">: {{(!empty($invoiceInfo->customer->full_name)
                                ? $invoiceInfo->customer->full_name : "N/A")}}</span>
                        </li>
                        @endif

                        <li class="flex items-start flex-col md:flex-row">
                            <span class="text-black w-20 md:w-24 shrink-0">Email </span>
                            <span class="flex-1 [text-indent:-8px] pl-1">: {{ (!empty($invoiceInfo->email) ?
                                $invoiceInfo->email : "N/A") }}</span>
                        </li>


                        @if(!empty($invoiceInfo->customer->phone))
                        <li class="flex items-start flex-col md:flex-row">
                            <span class="text-black w-20 md:w-24 shrink-0">Number </span>
                            <span class="flex-1 [text-indent:-8px] pl-1">: {{ (!empty($invoiceInfo->customer->phone) ?
                                $invoiceInfo->customer->phone : "N/A") }} </span>
                        </li>
                        @endif


                        @if(!empty($invoiceInfo->customer->address))
                        <li class="flex items-start flex-col md:flex-row">
                            <span class="text-black w-20 md:w-24 shrink-0">Address </span>
                            <span class="flex-1 [text-indent:-8px] pl-1">: {{ (!empty($invoiceInfo->customer->address) ?
                                $invoiceInfo->customer->address : "N/A") }} </span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>


        {{-- Cards --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-4 my-5 gap-4 md:gap-5">
            @foreach ($cardData as $key => $row)
            <div
                class="flex flex-col items-center text-center  overflow-hidden bg-[rgba(237,242,255,0.40)] rounded-[10px] border border-[#D5E1FF] p-5">

                {!!$row['icon']!!}

                <span class="text-base mt-2">{{$row['title']}} </span>

                <strong class="text-black text-base lg:text-lg">{{ $row['value'] }}</strong>
            </div>
            @endforeach

            <div
                class="flex flex-col items-center text-center  overflow-hidden {{$invoiceInfo->status == 'paid' ? 'bg-[#FAFFF9] border-[rgba(0,128,0,0.20)]' : 'bg-[#FFF9F9] border-[rgba(255,0,0,0.20)]'}} [&.unpaid]: [&.unpaid]: rounded-[10px] border p-5">

                <svg width="32" height="32" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M24.7513 6.58341V12.9167H22.2513V6.58341C22.2513 6.13341 21.8513 5.91675 21.5846 5.91675C21.5013 5.91675 21.418 5.93341 21.3346 5.96675L8.11797 10.9501C7.23464 11.2834 6.66797 12.1167 6.66797 13.0667V14.1834C5.1513 15.3167 4.16797 17.1334 4.16797 19.1834V13.0667C4.16797 11.0834 5.38464 9.31675 7.23464 8.61675L20.468 3.61675C20.8346 3.48341 21.218 3.41675 21.5846 3.41675C23.2513 3.41675 24.7513 4.76675 24.7513 6.58341Z"
                        fill="#00005C" />
                    <path
                        d="M35.8318 24.1666V25.8333C35.8318 26.2833 35.4818 26.6499 35.0152 26.6666H32.5818C31.6985 26.6666 30.8985 26.0166 30.8318 25.1499C30.7818 24.6333 30.9818 24.1499 31.3152 23.8166C31.6152 23.4999 32.0318 23.3333 32.4818 23.3333H34.9985C35.4818 23.3499 35.8318 23.7166 35.8318 24.1666Z"
                        fill="#00005C" />
                    <path
                        d="M32.468 21.5834H34.168C35.0846 21.5834 35.8346 20.8334 35.8346 19.9167V19.1834C35.8346 15.7334 33.018 12.9167 29.568 12.9167H10.4346C9.01797 12.9167 7.71797 13.3834 6.66797 14.1834C5.1513 15.3167 4.16797 17.1334 4.16797 19.1834V30.4001C4.16797 33.8501 6.98464 36.6667 10.4346 36.6667H29.568C33.018 36.6667 35.8346 33.8501 35.8346 30.4001V30.0834C35.8346 29.1667 35.0846 28.4167 34.168 28.4167H32.718C31.118 28.4167 29.5846 27.4334 29.168 25.8834C28.818 24.6167 29.2346 23.4001 30.068 22.5834C30.6846 21.9501 31.5346 21.5834 32.468 21.5834ZM23.3346 21.2501H11.668C10.9846 21.2501 10.418 20.6834 10.418 20.0001C10.418 19.3167 10.9846 18.7501 11.668 18.7501H23.3346C24.018 18.7501 24.5846 19.3167 24.5846 20.0001C24.5846 20.6834 24.018 21.2501 23.3346 21.2501Z"
                        fill="#00005C" />
                </svg>

                <span class="text-base mt-2">Payment Status</span>

                @if ($invoiceInfo->status == 'paid')
                <span class="inline-block text-base lg:text-lg font-bold text-green-500">Paid</span>
                @elseif($invoiceInfo->status == 'Pending')
                <span class="inline-block text-base lg:text-lg font-bold text-orange-600">Pending</span>
                @else
                <span class="inline-block text-base lg:text-lg font-bold text-red-600">Unpaid</span>
                @endif
            </div>
        </div>

        @foreach ($orderList as $key => $order)
        <div class="mt-4 rounded-[10px] border border-[#D5E1FF] overflow-x-auto">
            @if(!empty($order->orderItem))
            <table class="w-full mb-0">
                <tr class="text-left bg-[#E5E8F3] text-[#0A0A0A]">
                    <th class="px-3 py-2 border border-[#D5E1FF] border-r-0 text-lg">Order Details</th>
                    <th class="computer_header w-[185px] px-3 py-2 border border-[#D5E1FF] border-l-0 border-r-0"></th>
                    <th class="mobile_header w-[35px] px-3 py-2 border border-[#D5E1FF] border-l-0 border-r-0"></th>
                    <th class="px-3 py-2 border border-[#D5E1FF] text-lg border-l-0"></th>
                </tr>
                <tr>
                    <th colspan="2" class="text-start py-2">
                        <p class="pl-3 text-base">
                            <span class="text-black">Order ID: </span>
                            <span>{{ $order->order_no }}</span>
                        </p>

                        <p class="pl-3 text-base">
                            <span class="text-black">Billing Type: </span>
                            <span>{{ $order->billType?->name }}</span>
                        </p>

                        <p class="pl-3 text-base">
                            <span class="text-black">Order Date: </span>
                            <span>{{ date('d F, Y', strtotime($order->created)) }}</span>
                        </p>
                    </th>
                </tr>
                @foreach ($order->orderItem as $row => $items)
                <tr class="odd:bg-[#F9FCFF] group">
                    <td colspan="2" class="border group-odd:border-[#D5E1FF] py-2 text-[#515151] text-lg px-4">
                        <span class="text-bold">{{ $items->live_url }}</span>
                        @if($order->billType?->name == "Link Insertion On")
                        @php($anchorText = json_decode($items->anchor))
                        @foreach($anchorText as $anchor)
                        <div>
                            <span class="text-black mr-2">{{ $anchor->anchor_text }}: </span>
                            <span> {{ $anchor->link }}</span>
                        </div>
                        @endforeach
                        @endif
                    </td>

                    <td class="w-40 border group-odd:border-[#D5E1FF] py-2 text-[#515151] text-right text-lg px-4">
                        ${{ $items->total }}
                    </td>
                </tr>
                @endforeach

                <tr>
                    <th rowspan="5"
                        class="computer_view text-center px-4 border py-2 text-[#515151] text-lg leading-[20px] ">
                        &nbsp;
                    </th>

                    <th class="computer_header text-left px-4 border py-2 text-[#515151] text-lg leading-[20px] ">
                        Sub Total
                    </th>

                    <th class="mobile_header  px-4 border py-2 text-[#515151] text-right text-lg leading-[20px] ">
                        Sub Total
                    </th>

                    <th class="border  px-4 w-40 py-2 text-[#515151] text-right text-lg leading-[20px]">
                        ${{ $order->subtotal }}
                    </th>
                </tr>

                <tr>
                    <th class="computer_header text-left px-4 border py-2 text-[#515151] text-lg leading-[20px]">
                        Service Charge
                    </th>

                    <th class="mobile_header text-left px-4 border py-2 text-[#515151] text-lg leading-[20px]">
                        Service Charge
                    </th>

                    <th class="border  px-4 py-2 text-[#515151] text-right text-lg leading-[20px]">
                        ${{ $order->service_charge }}
                    </th>
                </tr>

                <tr>
                    <th class="computer_header text-left px-4 border py-2 text-[#515151] text-lg leading-[20px]">
                        Tax
                    </th>

                    <th class="mobile_header text-left px-4 border py-2 text-[#515151] text-lg leading-[20px]">
                        Tax
                    </th>

                    <th class="border  px-4 py-2 text-[#515151] text-right text-lg leading-[20px]">
                        ${{ $order->tax }}
                    </th>
                </tr>

                <tr>
                    <th class="computer_header text-left px-4 border py-2 text-[#515151] text-lg leading-[20px]">
                        Discount
                    </th>

                    <th class="mobile_header text-left px-4 border py-2 text-[#515151] text-lg leading-[20px]">
                        Discount
                    </th>

                    <th class="border  px-4 py-2 text-[#515151] text-right text-lg leading-[20px]">
                        ${{ $order->discount }}
                    </th>
                </tr>

                <tr>
                    <th
                        class="computer_header text-left px-4 border border-b-0 py-2 text-[#515151] text-lg leading-[20px]">
                        Total
                    </th>

                    <th
                        class="mobile_header text-left px-4 border border-b-0 py-2 text-[#515151] text-lg leading-[20px]">
                        Total
                    </th>

                    <th class="border  px-4 border-b-0 py-2 text-[#515151] text-right text-lg leading-[20px]">
                        ${{ $order->grand_total }}
                    </th>
                </tr>
            </table>
            @endif
        </div>
        @endforeach


        <div class="mt-4">
            <fieldset class="rounded-[10px] max-w-[500px] ml-auto border border-[#D5E1FF] overflow-hidden">
                <legend class="ml-[30px] text-xl text-[#031F42] px-1 max-w-full whitespace-nowrap">Total Order Summery
                </legend>

                <div class="flex flex-col px-[30px] py-[20px]">
                    <div class="flex items-center border-b justify-between font-semibold py-2">
                        <span class="text-black">Sub Total</span>
                        <span class="text-black">${{ $invoiceInfo->subtotal }}</span>
                    </div>

                    <div class="flex items-center border-b justify-between font-semibold py-2">
                        <span class="text-black">Discount</span>
                        <span class="text-black">${{ $invoiceInfo->discount }}</span>
                    </div>

                    <div class="flex items-center border-b justify-between font-semibold py-2">
                        <span class="text-black">Total</span>
                        <span class="text-black">${{ $invoiceInfo->grand_total }}</span>
                    </div>
                </div>

                @if ($invoiceInfo->status != 'paid')
                <div class="flex items-center justify-center p-[18px]">
                    @php($urlLink = "")
                    @if ($invoiceInfo->method_id == 1)
                    @php($urlLink = url('stripe/checkout', $invoiceInfo->ref_code))
                    @else
                    @php($urlLink = url('paypal/checkout', $invoiceInfo->ref_code))
                    @endif

                    <a class="flex gap-[12px] rounded-[10px] items-center justify-center p-[18px] w-full max-w-[430px] bg-[#705CF6] duration-300 text-white hover:bg-[#5039EC]"
                        href="{{ $urlLink }}">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 8.50488H22" stroke="white" stroke-width="1.5" stroke-miterlimit="10"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M6 16.5049H8" stroke="white" stroke-width="1.5" stroke-miterlimit="10"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M10.5 16.5049H14.5" stroke="white" stroke-width="1.5" stroke-miterlimit="10"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M6.44 3.50488H17.55C21.11 3.50488 22 4.38488 22 7.89488V16.1049C22 19.6149 21.11 20.4949 17.56 20.4949H6.44C2.89 20.5049 2 19.6249 2 16.1149V7.89488C2 4.38488 2.89 3.50488 6.44 3.50488Z"
                                stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span>Pay With Card</span>
                    </a>
                </div>
                @endif

            </fieldset>
        </div>

        <div class="flex justify-center items-center gap-5 md:gap-6 lg:gap-[30px]  mt-6 md:mt-8 lg:mt-10">
            <a href="{{ url('download-invoice', $invoiceInfo->ref_code) }}" onclick="downloadPDF(event)"
                class="download px-[30px] py-[15px] text-base duration-300 font-medium bg-[#2E353A] rounded-full border border-[#2E353A] text-white leading-[18px] hover:bg-[#2E353A]/80 hover:border-[#2E353A]/80">
                Download
            </a>

            <a href="{{ url('download-invoice', $invoiceInfo->ref_code) }}" target="_blank"
                class="view_pdf px-[30px] py-[15px] text-base duration-300 font-medium bg-transparent rounded-full border-2 border-[#2E353A] hover:text-white leading-[18px] text-[#263238] hover:border-[#2E353A] hover:bg-[#2E353A]">
                View PDF
            </a>
        </div>

    </div>
</section>

@endsection

@push('headerPartial')
<style>
    .header {
        display: none;
    }

    .paypal {
        display: block;
        width: 100%;
        background: #FBC02D;
        text-align: center;
        border: 1px solid #FBC02D;
        border-radius: 5px;
    }

    .paypal img {
        width: 40%;
        height: auto;
        margin: 10px auto;
    }

    .stripe {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px;
        width: 100%;
        background: #6772E5;
        font-size: 38px;
        font-weight: bold;
        color: #fff;
        border: 1px solid #6772E5;
        border-radius: 5px;
    }

    .stripe img {
        height: 35px;
        border-radius: 10px;
        margin-right: 15px;
    }

    .section_padding {
        padding: 50px 0;
    }

    .computer_header {
        display: table-cell;
    }

    .mobile_header {
        display: none;
    }

    .computer_view {
        display: table-cell;
    }

    .mobile_view {
        display: none;
    }

    @media only screen and (max-width: 768px) {
        .computer_view {
            display: none;
        }

        .mobile_view {
            display: table-cell;
        }

        .computer_header {
            display: none;
        }

        .mobile_header {
            display: table-cell;
        }
    }

    @media only screen and (max-width: 375px) {

        .download,
        .view_pdf {
            padding: 8px 15px !important;
        }
    }
</style>
@endpush

@push('footerPartial')
<script>
    function downloadPDF(event) {
            event.preventDefault(); // Prevent the default link behavior
            // Get the URL from the href attribute
            var url = event.target.href;
            // Create a hidden anchor element
            var anchor = document.createElement('a');
            anchor.href = url;
            anchor.download = ''; // You can set the desired file name here
            anchor.style.display = 'none';
            // Append the anchor to the body
            document.body.appendChild(anchor);
            // Trigger a click event on the anchor
            anchor.click();
            // Remove the anchor from the body
            document.body.removeChild(anchor);
        }
</script>
@endpush
