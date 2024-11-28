@extends('layouts.frontend')
@section('headerMeta')
@php
$metaTitle = $metaDescription = $metaKeywords = strFilter(config('app.name'));
$metaImage = 'images/website.png';
if (!empty($info)) {
$metaTitle = $info->meta_title;
$metaDescription = $info->meta_description;
$metaKeywords = $info->meta_tag;
$metaImage = !empty($info->image) ? $info->image : $metaImage;
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
<meta name='og:image' content="{{ asset($metaImage) }}">
<meta name='og:site_name' content="{{ $metaTitle }}">
<meta name='og:description' content="{{ $metaDescription }}">
@endsection

@section('content')

@include('layouts.frontend-partial.breadcrumb')

{{-- ================================
cart section begins here
================================= --}}
<section class="sectionGap">
    <div class="container">

        <div class="grid md:grid-cols-2 gap-7 lg:gap-20">
            <div
                class="aspect-[610/435] relative md:sticky md:top-[90px] border bg-[#f7f7f7] rounded-lg bg-cover flex items-center justify-center">

                <div class="macbook">
                    <div class="screen">
                        <div class="viewport">
                            <img width="1484" height="878" src="{{asset($info->image)}}" alt="{{$info->title}}">
                        </div>
                    </div>
                    <div class="base"></div>
                    <div class="notch"></div>
                    <img class="absolute -bottom-10 md:-bottom-16 lg:-bottom-20 right-0 w-24 md:w-32 lg:w-44"
                        src="{{asset('public')}}/images/money-back-badge.png" alt="Money back badge">
                </div>
            </div>

            <div>
                <h1 class="text-2xl md:text-3xl font-semibold text-darkblue mb-4">{{$info->title}}</h1>
                <p class="text-5xl font-bold font-sans text-secondary">${{$info->general_price}}</p>

                <form class="grid gap-4 mt-7">
                    <div class="border border-secondary/10 rounded-md overflow-hidden">
                        <div class="px-4 py-3 bg-[#F3EDED] text-darkblue text-2xl flex items-center gap-2">
                            <h5 class="font-syne font-medium">
                                {{$info->check_url}} statistics
                            </h5>
                        </div>
                        <div class="p-4">
                            <div class="grid grid-cols-3 border bg-secondary/10 gap-px rounded-sm overflow-hidden">
                                <div class="flex items-center justify-between p-2.5 min-h-20 bg-white">
                                    <div class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 176.515 51.465"
                                            class="mt-0.5 mb-1 h-2" data-tip="" data-for="domainAuthority"
                                            currentitem="false">
                                            <script xmlns=""></script>
                                            <path
                                                d=" M 0 46.153 L 10.787 46.153 C 11.901 46.153 12.812 45.242 12.812 44.128 L 12.812 25.438 L 32.947 47.863 L 53.083 25.438 L 53.083 44.128 C 53.083 45.242 53.994 46.153 55.108 46.153 L 65.894 46.153 L 65.894 6.105 L 56.735 6.105 C 54.088 6.105 52.115 7.38 51.049 8.566 L 32.947 28.726 L 14.845 8.566 C 13.78 7.38 11.806 6.105 9.16 6.105 L 0 6.105 L 0 46.153 Z "
                                                fill-rule="evenodd" fill="rgb(36,171,226)"></path>
                                            <path
                                                d=" M 121.126 46.153 L 174.49 46.153 C 175.604 46.153 176.515 45.242 176.515 44.128 L 176.515 33.462 L 150.568 33.462 L 176.44 6.142 L 123.109 6.142 C 121.996 6.142 121.084 7.054 121.084 8.167 L 121.084 18.833 L 146.998 18.833 L 121.126 46.153 Z "
                                                fill-rule="evenodd" fill="rgb(36,171,226)"></path>
                                            <path
                                                d=" M 95.064 0 C 111.349 0 124.551 11.383 124.551 25.733 C 124.551 40.082 111.349 51.465 95.064 51.465 C 78.778 51.465 65.577 40.082 65.577 25.733 C 65.577 11.383 78.778 0 95.064 0 Z  M 95.064 12.859 C 103.005 12.859 109.815 18.623 109.815 25.733 C 109.815 32.842 103.211 38.606 95.064 38.606 C 86.917 38.606 80.312 32.842 80.312 25.733 C 80.312 18.623 87.123 12.859 95.064 12.859 Z "
                                                fill-rule="evenodd" fill="rgb(36,171,226)"></path>
                                        </svg>

                                        <span>DA</span>
                                    </div>

                                    <div class="circle da-progress-value" style="--percent:{{ $info->da }}%;">
                                        <span class=" progress-value">{{ $info->da }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-2.5 min-h-20 bg-white">
                                    <div class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 455.7 115.9"
                                            class="mb-1 h-2.5" data-tip="" data-for="domainRating" currentitem="false">
                                            <script xmlns=""></script>
                                            <path fill="#f18618"
                                                d="M7.7,45.6H52V58L35.3,59.3C8.4,61.3,0,68.4,0,88.4v4c0,14.6,10.2,23.4,26,23.4, 12.4,0,19.6-2.9,28.4-11.9h1.5v9.5H73.7V26.1H7.7ZM52,87.7c-5.5,5.5-13.7,9.1-20.5,9.1-7.3,0-10.4-2.7-10.2-8.8.2-8.4, 3.3-10.4,17.4-11.7L52.1,75V87.7Z">
                                            </path>
                                            <path fill="#2e53a0" fill-rule="evenodd"
                                                d="M110.9,26.2h34.2V44h18.7v69.5H142V45.8H110.9v67.7H89.1V0h21.8V26.2ZM429.3, 61.4l-13.2-1.3c-7.3-.7-9.1-2.6-9.1-8.4,0-6.6,2.6-8.2,12.8-8.2,9.1,0,11.7,1.5,13,7.7h20.5c-.5-20.9-7-26.2-32.4-26.2-27.8, 0-34.8,5.3-34.8,26.7,0,19.6,5.1,24.9,25.8,26.9l10.8,1c9.7.9,12.1,2.7,12.1,8.6,0,7.1-2.9,9-14.8,9-10.4,0-13.2-1.6-13.7-8.4H385.6c.5, 21.6,7.1,27.1,33.5,27.1,29.3,0,36.6-5.9,36.6-29.7C455.7,68.5,450.4,63.4,429.3,61.4ZM317.2,63c0-28.2-9.7-38.1-37.5-38.1-27.5,0-38.2, 12.8-38.2,44.7,0,34.8,9.5,46.3,40.3,46.3,22.1,0,31.5-6.8,34.6-25.8h-21c-2.4,5.9-4.9,7.2-13.9,7.2-13.5,0-17-3.8-17.8-20.1h52.2A98.64,98.64, 0,0,0,317.2,63Zm-53.4-3.1c.2-12.3,5.1-16.8,16.8-16.8,11.2,0,15.7,4.6,16.1,16.8Zm66.1-29.8v83.5h21.8V45h26.2V26.3H351.7V23.9c.2-5.1, 1.5-6.6,5.7-6.6h23.8V.1H355.6C338.1,0,329.9,5.4,329.9,30.1ZM201.5,113.5H179.7V26.2h54.2V46.7H201.5v66.8Z">
                                            </path>
                                        </svg>

                                        <span>DR</span>
                                    </div>

                                    <div class="circle dr-progress-value" style="--percent:{{ $info->dr }}%;">
                                        <span class=" progress-value">{{ $info->dr }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-2.5 min-h-20 bg-white">
                                    <div class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 455.7 115.9"
                                            class="mb-1 h-2.5" data-tip="" data-for="domainRating" currentitem="false">
                                            <script xmlns=""></script>
                                            <path fill="#f18618"
                                                d="M7.7,45.6H52V58L35.3,59.3C8.4,61.3,0,68.4,0,88.4v4c0,14.6,10.2,23.4,26,23.4, 12.4,0,19.6-2.9,28.4-11.9h1.5v9.5H73.7V26.1H7.7ZM52,87.7c-5.5,5.5-13.7,9.1-20.5,9.1-7.3,0-10.4-2.7-10.2-8.8.2-8.4, 3.3-10.4,17.4-11.7L52.1,75V87.7Z">
                                            </path>
                                            <path fill="#2e53a0" fill-rule="evenodd"
                                                d="M110.9,26.2h34.2V44h18.7v69.5H142V45.8H110.9v67.7H89.1V0h21.8V26.2ZM429.3, 61.4l-13.2-1.3c-7.3-.7-9.1-2.6-9.1-8.4,0-6.6,2.6-8.2,12.8-8.2,9.1,0,11.7,1.5,13,7.7h20.5c-.5-20.9-7-26.2-32.4-26.2-27.8, 0-34.8,5.3-34.8,26.7,0,19.6,5.1,24.9,25.8,26.9l10.8,1c9.7.9,12.1,2.7,12.1,8.6,0,7.1-2.9,9-14.8,9-10.4,0-13.2-1.6-13.7-8.4H385.6c.5, 21.6,7.1,27.1,33.5,27.1,29.3,0,36.6-5.9,36.6-29.7C455.7,68.5,450.4,63.4,429.3,61.4ZM317.2,63c0-28.2-9.7-38.1-37.5-38.1-27.5,0-38.2, 12.8-38.2,44.7,0,34.8,9.5,46.3,40.3,46.3,22.1,0,31.5-6.8,34.6-25.8h-21c-2.4,5.9-4.9,7.2-13.9,7.2-13.5,0-17-3.8-17.8-20.1h52.2A98.64,98.64, 0,0,0,317.2,63Zm-53.4-3.1c.2-12.3,5.1-16.8,16.8-16.8,11.2,0,15.7,4.6,16.1,16.8Zm66.1-29.8v83.5h21.8V45h26.2V26.3H351.7V23.9c.2-5.1, 1.5-6.6,5.7-6.6h23.8V.1H355.6C338.1,0,329.9,5.4,329.9,30.1ZM201.5,113.5H179.7V26.2h54.2V46.7H201.5v66.8Z">
                                            </path>
                                        </svg>

                                        <span>PA</span>
                                    </div>

                                    <div class="circle pa-progress-value" style="--percent:{{ $info->pa }}%;">
                                        <span class=" progress-value">{{ $info->pa }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-2.5 min-h-20 bg-white">
                                    <div class="flex items-center gap-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 455.7 115.9"
                                            class="mb-1 h-2.5" data-tip="" data-for="domainRating" currentitem="false">
                                            <script xmlns=""></script>
                                            <path fill="#f18618"
                                                d="M7.7,45.6H52V58L35.3,59.3C8.4,61.3,0,68.4,0,88.4v4c0,14.6,10.2,23.4,26,23.4, 12.4,0,19.6-2.9,28.4-11.9h1.5v9.5H73.7V26.1H7.7ZM52,87.7c-5.5,5.5-13.7,9.1-20.5,9.1-7.3,0-10.4-2.7-10.2-8.8.2-8.4, 3.3-10.4,17.4-11.7L52.1,75V87.7Z">
                                            </path>
                                            <path fill="#2e53a0" fill-rule="evenodd"
                                                d="M110.9,26.2h34.2V44h18.7v69.5H142V45.8H110.9v67.7H89.1V0h21.8V26.2ZM429.3, 61.4l-13.2-1.3c-7.3-.7-9.1-2.6-9.1-8.4,0-6.6,2.6-8.2,12.8-8.2,9.1,0,11.7,1.5,13,7.7h20.5c-.5-20.9-7-26.2-32.4-26.2-27.8, 0-34.8,5.3-34.8,26.7,0,19.6,5.1,24.9,25.8,26.9l10.8,1c9.7.9,12.1,2.7,12.1,8.6,0,7.1-2.9,9-14.8,9-10.4,0-13.2-1.6-13.7-8.4H385.6c.5, 21.6,7.1,27.1,33.5,27.1,29.3,0,36.6-5.9,36.6-29.7C455.7,68.5,450.4,63.4,429.3,61.4ZM317.2,63c0-28.2-9.7-38.1-37.5-38.1-27.5,0-38.2, 12.8-38.2,44.7,0,34.8,9.5,46.3,40.3,46.3,22.1,0,31.5-6.8,34.6-25.8h-21c-2.4,5.9-4.9,7.2-13.9,7.2-13.5,0-17-3.8-17.8-20.1h52.2A98.64,98.64, 0,0,0,317.2,63Zm-53.4-3.1c.2-12.3,5.1-16.8,16.8-16.8,11.2,0,15.7,4.6,16.1,16.8Zm66.1-29.8v83.5h21.8V45h26.2V26.3H351.7V23.9c.2-5.1, 1.5-6.6,5.7-6.6h23.8V.1H355.6C338.1,0,329.9,5.4,329.9,30.1ZM201.5,113.5H179.7V26.2h54.2V46.7H201.5v66.8Z">
                                            </path>
                                        </svg>

                                        <span>Rank</span>
                                    </div>

                                    <div>{{$info->ahref_rank}}</div>
                                </div>

                                <div class="flex items-center justify-between p-2.5 min-h-20 bg-white">
                                    <div>
                                        Organic Trafic
                                    </div>

                                    <div>
                                        {{formatNumber($info->traffic)}}
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-2.5 min-h-20 bg-white">
                                    <div>
                                        Organic Keywords
                                    </div>

                                    <div>
                                        {{formatNumber($info->organic_keyword)}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border border-secondary/10 rounded-md overflow-hidden">
                        <div class="px-4 py-3 bg-[#F3EDED] text-darkblue text-2xl flex items-center gap-2">
                            <h5 class="font-syne font-medium">Order Type</h5>
                        </div>
                        <div class="p-4">
                            <div class="divide-y">
                                <label class="flex items-center gap-2.5 py-2 cursor-pointer">
                                    <input type="radio" checked name="billing_type" value="2" />
                                    Guest Posting
                                </label>
                                <label class="flex items-center gap-2.5 py-2 cursor-pointer">
                                    <input type="radio" name="billing_type" value="1" />
                                    Link Insertion
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="border border-secondary/10 rounded-md overflow-hidden">
                        <div class="px-4 py-3 bg-[#F3EDED] text-darkblue text-2xl flex items-center gap-2">
                            <h5 class="font-syne font-medium">Your websites niche</h5>
                        </div>
                        <div class="p-4">
                            <div class="divide-y">
                                <label class="flex items-center gap-2.5 py-2 cursor-pointer">
                                    <input type="radio" checked name="niche" onchange="updatePriceType()"
                                        value="general" />
                                    General
                                </label>
                                <label class="flex items-center gap-2.5 py-2 cursor-pointer">
                                    <input type="radio" name="niche" onchange="updatePriceType()" value="others" />
                                    Others <span class="text-secondary font-bold">+$({{ $info->other_price }})</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="border border-secondary/10 rounded-md overflow-hidden">
                        <div class="px-4 py-3 bg-[#F3EDED] text-darkblue text-2xl flex items-center gap-2">
                            <h5 class="font-syne font-medium">Pricing details</h5>
                        </div>
                        <div>
                            <div class="grid grid-cols-[1fr_120px] border-b text-xl">
                                <div class="px-2 py-3 border-r">
                                    1 x {{$info->title}}
                                </div>
                                <div class="px-2 py-3 text-right font-medium text-darkblue">
                                    $<span id="item_price"></span>
                                </div>
                            </div>
                            <div class="grid grid-cols-[1fr_120px] text-2xl">
                                <div class="px-2 py-3 border-r text-right font-bold text-secondary">
                                    Total
                                </div>
                                <div class="px-2 py-3 text-right  font-bold text-secondary">
                                    $<span id="subtotal_price"></span>
                                </div>
                                <input type="text" name="price" class="hidden" id="total_price">
                            </div>
                        </div>
                    </div>

                    <div>
                        <button class="primary-btn" data-text="Add to cart" type="button" id="addToCart">
                            Add to cart
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
{{-- ================================
cart section ends here
================================= --}}
@endsection

@push('footerPartial')
<script>
    function updatePriceType() {
            const niche = document.querySelector('input[name="niche"]:checked').value;
            const itemPrice = (niche == 'others' ? {{ $info->general_price + $info->other_price}} : {{$info->general_price}});
            document.getElementById('item_price').textContent = itemPrice;
            document.getElementById('subtotal_price').textContent = itemPrice;
            document.getElementById('total_price').value = itemPrice;
        }
        updatePriceType()

        $(document).ready(function () {
            $('#addToCart').on('click', function () {

                const productId = {{$info->id}};
                const niche = document.querySelector('input[name="niche"]:checked').value;
                const billingType = document.querySelector('input[name="billing_type"]:checked').value;

                $.ajax({
                    url: "{{ route('cart.add') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        billing_type: billingType,
                        niche: niche,
                    },
                    success: function (response) {
                        console.log(response.message);
                        if (response.success) {
                            window.location.href = '{{ route("cart") }}';
                        }
                    },
                    error: function () {
                        console.log('Failed to add item to cart.');
                    }
                });
            });
        });
</script>
@endpush

@push('headerPartial')
<style>
    .macbook {
        position: absolute;
        margin: 0 auto;
        width: 90%;
    }

    .macbook .screen {
        background: #000;
        border-radius: 3% 3% 0.5% 0.5% / 5%;
        margin: 0 auto;
        position: relative;
        width: 80%;
    }

    .macbook .screen:before {
        border: 2px solid #cacacc;
        border-radius: 3% 3% 0.5% 0.5% / 5%;
        box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.8) inset,
            0 0 1px 2px rgba(255, 255, 255, 0.3) inset;
        content: "";
        display: block;
        padding-top: 67%;
    }

    .macbook .screen:after {
        content: "";
        border-top: 2px solid rgba(255, 255, 255, 0.15);
        position: absolute;
        bottom: 0.75%;
        left: 0.5%;
        padding-top: 1%;
        width: 99%;
    }

    .macbook .viewport {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        top: 0;
        margin: 4.3% 3.2%;
        background: #333;
        overflow: hidden;
    }

    .macbook .viewport img {
        height: 100%;
        width: 100%;
    }

    .macbook .base {
        position: relative;
        width: 100%;
    }

    .macbook .base:before {
        content: "";
        display: block;
        padding-top: 3.3%;
        background: linear-gradient(#eaeced,
                #edeef0 55%,
                #fff 55%,
                #8a8b8f 56%,
                #999ba0 61%,
                #4b4b4f 84%,
                #262627 89%,
                rgba(0, 0, 0, 0.01) 98%);
        border-radius: 0 0 10% 10%/ 0 0 50% 50%;
    }

    .macbook .base::after {
        background: linear-gradient(90deg,
                rgba(0, 0, 0, 0.5),
                rgba(255, 255, 255, 0.8) 0.5%,
                rgba(0, 0, 0, 0.4) 3.3%,
                transparent 15%,
                rgba(255, 255, 255, 0.8) 50%,
                transparent 85%,
                rgba(0, 0, 0, 0.4) 96.7%,
                rgba(255, 255, 255, 0.8) 99.5%,
                rgba(0, 0, 0, 0.5) 100%);
        content: "";
        height: 53%;
        position: absolute;
        top: 0;
        width: 100%;
    }

    .macbook .notch {
        background: #ddd;
        border-radius: 0 0 7% 7% / 0 0 95% 95%;
        box-shadow: -5px -1px 3px rgba(0, 0, 0, 0.2) inset,
            5px -1px 3px rgba(0, 0, 0, 0.2) inset;
        margin-left: auto;
        margin-right: auto;
        margin-top: -3.5%;
        z-index: 2;
        position: relative;
        width: 14%;
    }

    .macbook .notch:before {
        content: "";
        display: block;
        padding-top: 10%;
    }

    :root {
        --c-green-alt: #4caf50;
        --c-orange: #ff9800;
        --c-red: #f44336;
        --c-gray: #e0e0e0;
        --progress: 75deg;
    }

    .pie-progress {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: bold;
        border-radius: 50%;
        background: radial-gradient(closest-side, white 79%, transparent 80% 100%),
            conic-gradient(var(--c-progress) var(--progress), var(--c-gray) 0);
    }

    .pie-progress--green {
        --c-progress: var(--c-green-alt);
    }

    .pie-progress--orange {
        --c-progress: var(--c-orange);
    }

    .pie-progress--red {
        --c-progress: var(--c-red);
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
</style>
@endpush