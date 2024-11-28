@extends('layouts.app')

@section('content')

<div>
    <!-- Page Header -->
    <div class="flex items-center justify-between bg-gray-50 p-5 border-b rounded">
        <h3 class="text-3xl font-semibold">Edit Site</h3>
        <a href="{{ route('admin.link_list') }}" class="primary-btn text-sm">
            All Sites
            <i class="fa-solid fa-list-check"></i>
        </a>
    </div>


    <!-- Form -->
    <div class=" shadow-md rounded p-5">
        <form action="{{ route('admin.link_list.update') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-[auto_300px] gap-10">
                <!-- Inputs Area -->
                <div class="flex flex-col gap-7">
                    {{-- Product Info --}}

                    <input type="hidden" name="id" value="{{ $info->id }}" />
                    <input type="hidden" name="product_id" value="{{ $info->product_id }}" />

                    <fieldset class="border border-solid border-gray-300 p-3 w-full">
                        <legend class="font-medium text-gray-900">Product Info</legend>

                        <div class="flex flex-col gap-7">
                            <div class="flex flex-col gap-2">
                                <label for="title">Product Title</label>
                                <input type="text" name="title" id="title" value="{{ $info->title }}"
                                    placeholder="Product Title" class="inputField" />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="url">Website URL</label>
                                <input type="text" name="url" id="url" value="{{ $info->url }}"
                                    placeholder="Website URL" class="inputField" />
                            </div>

                            {{-- <div class="flex flex-col gap-2">
                                <label for="nicheTag">Niche List</label>

                                <div class="tags-input inputField">
                                    <ul id="tags"></ul>
                                    <input type="text" class="inputField" name="niche" id="nicheTag"
                                        placeholder="Enter tag name" />
                                </div>
                            </div> --}}

                            <div class="grid lg:grid-cols-2 gap-7">
                                <div class="flex flex-col gap-2">
                                    <label for="publisherId">Site Owner Name</label>
                                    <select name="publisher_id" id="publisherId" class="inputField">
                                        <option value="">Select Site Owner Name</option>

                                        @if (!empty($publisher) && $publisher->isNotEmpty())
                                        @foreach ($publisher as $row)
                                        <option value="{{ $row->id }}" {{ $info->publisher_id == $row->id ? 'selected' :
                                            '' }}>
                                            {{ $row->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="flex flex-col gap-2">
                                    @php($selectNiche = json_decode($info->niche))

                                    <label for="niche">Niche List</label>
                                    <select class="js-example-basic-multiple" name="niche[]" multiple="multiple">
                                        <option value="">Select Niche</option>

                                        @if (!empty($nicheList) && $nicheList->isNotEmpty())
                                        @foreach ($nicheList as $key => $row)
                                        <option {{ In_array($row->id, $selectNiche) ? 'selected' : '' }}
                                            value="{{ $row->id }}"> {{ $row->name }} </option>
                                        @endforeach
                                        @endif

                                    </select>
                                </div>

                            </div>


                            <div class="flex flex-col gap-2">
                                <label for="productDesc">Product Description</label>
                                <textarea name="description" id="productDesc">{!! $info->description !!}</textarea>
                            </div>
                        </div>

                    </fieldset>

                    {{-- Pricing Info --}}
                    <fieldset class="border border-solid border-gray-300 p-3 w-full">
                        <legend class="font-medium text-gray-900">Pricing Info</legend>

                        <div class="grid lg:grid-cols-3 gap-7">
                            <div class="flex flex-col gap-2">
                                <label for="regularPrice"> Regular Price </label>
                                <input type="number" name="regular_price" id="regularPrice" placeholder="Regular Price"
                                    value="{{ $info->linkPrice->regular_price }}"
                                    class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    step="any" />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="salePrice"> Sale Price </label>
                                <input type="number" name="sale_price" id="salePrice" placeholder="Sale Price"
                                    value="{{ $info->linkPrice->sale_price }}"
                                    class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    step="any" />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="ownerPrice"> Site Owner Price </label>
                                <input type="number" name="owner_price" id="ownerPrice" placeholder="Site Owner Price"
                                    value="{{ $info->linkPrice->owner_price }}"
                                    class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    step="any" />
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-7 mt-5">

                            <div class="flex flex-col gap-2">
                                <label for="merchantCbdPrice"> Merchant CBD Price </label>
                                <input type="number" name="merchant_cbd_price" id="merchantCbdPrice"
                                    placeholder="Merchant CBD Price" value="{{ $info->linkPrice->merchant_cbd_price }}"
                                    class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    step="any" />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="ownerCbdPrice"> Site Owner CBD Price </label>
                                <input type="number" name="owner_cbd_price" id="ownerCbdPrice"
                                    placeholder="Site Owner CBD Price" value="{{ $info->linkPrice->owner_cbd_price }}"
                                    class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    step="any" />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="merchantCryptoPrice"> Merchant Crypto Price </label>
                                <input type="number" name="merchant_crypto_price" id="merchantCryptoPrice"
                                    placeholder="Merchant Crypto Price"
                                    value="{{ $info->linkPrice->merchant_crypto_price }}"
                                    class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    step="any" />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="ownerCryptoPrice"> Site Owner Crypto Price </label>
                                <input type="number" name="owner_crypto_price" id="ownerCryptoPrice"
                                    placeholder="Site Owner Crypto Price"
                                    value="{{ $info->linkPrice->owner_crypto_price }}"
                                    class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    step="any" />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="merchantCasinoPrice"> Merchant Casino Price </label>
                                <input type="number" name="merchant_casino_price" id="merchantCasinoPrice"
                                    placeholder="Merchant Casino Price"
                                    value="{{ $info->linkPrice->merchant_casino_price }}"
                                    class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    step="any" />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="ownerCasinoPrice"> Site Owner Casino Price </label>
                                <input type="number" name="owner_casino_price" id="ownerCasinoPrice"
                                    placeholder="Site Owner Casino Price"
                                    value="{{ $info->linkPrice->owner_casino_price }}"
                                    class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    step="any" />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="merchantHomepageLinkPrice"> Merchant Homepage Link Price </label>
                                <input type="number" name="merchant_homepage_price" id="merchantHomepageLinkPrice"
                                    placeholder="Merchant Homepage Link Price"
                                    value="{{ $info->linkPrice->merchant_homepage_price }}"
                                    class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    step="any" />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="ownerHomepageLinkPrice"> Site Owner Homepage Link Price </label>
                                <input type="number" name="owner_homepage_price" id="ownerHomepageLinkPrice"
                                    placeholder="Site Owner Homepage Link Price"
                                    value="{{ $info->linkPrice->owner_homepage_price }}"
                                    class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    step="any" />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="merchantSidebarLinkPrice"> Merchant Sidebar Link Price </label>
                                <input type="number" name="merchant_sidebar_price" id="merchantSidebarLinkPrice"
                                    placeholder="Merchant Sidebar Link Price"
                                    value="{{ $info->linkPrice->merchant_sidebar_price }}"
                                    class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    step="any" />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="ownerSidebarLinkPrice"> Site Owner Sidebar Link Price </label>
                                <input type="number" name="owner_sidebar_price" id="ownerSidebarLinkPrice"
                                    placeholder="Site Owner Sidebar Link Price"
                                    value="{{ $info->linkPrice->owner_sidebar_price }}"
                                    class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    step="any" />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="merchantFooterLinkPrice"> Merchant Footer Link Price </label>
                                <input type="number" name="merchant_footer_price" id="merchantFooterLinkPrice"
                                    placeholder="Merchant Footer Link Price"
                                    value="{{ $info->linkPrice->merchant_footer_price }}"
                                    class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    step="any" />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="ownerFooterLinkPrice"> Site Owner Footer Link Price </label>
                                <input type="number" name="owner_footer_price" id="ownerFooterLinkPrice"
                                    placeholder="Site Owner Footer Link Price"
                                    value="{{ $info->linkPrice->owner_footer_price }}"
                                    class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    step="any" />
                            </div>
                        </div>

                    </fieldset>

                    {{-- Website Info --}}
                    <fieldset class="border border-solid border-gray-300 p-3 w-full">
                        <legend class="font-medium text-gray-900">Website Info</legend>

                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-7">
                            <div class="flex flex-col gap-2">
                                <label for="da"> DA </label>
                                <input type="number" name="da" placeholder="DA" max="100" value="{{ $info->da }}"
                                    class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    step="any" id="da" />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="pa"> PA </label>
                                <input type="number" name="pa" placeholder="PA" max="100" value="{{ $info->pa }}"
                                    class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    step="any" id="pa" />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="dr"> DR </label>
                                <input type="number" name="dr" placeholder="DR" max="100" value="{{ $info->dr }}"
                                    class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    step="any" id="dr" />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="aHrefRank"> A href Rank </label>
                                <input type="number" name="ahref" placeholder="A href Rank" value="{{ $info->ahref }}"
                                    class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    step="any" id="aHrefRank" />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="traffic"> Traffic </label>
                                <input type="number" name="traffic" placeholder="Traffic" value="{{ $info->traffic }}"
                                    class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    step="any" id="traffic" />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="organicKeyword"> Organic Keywords </label>
                                <input type="number" name="organic_keyword" placeholder="Organic Keywords"
                                    value="{{ $info->organic_keyword }}"
                                    class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    step="any" id="organicKeyword" />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="cf"> CF </label>
                                <input type="number" name="cf" placeholder="CF" max="100" value="{{ $info->cf }}"
                                    class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    step="any" id="cf" />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="tf"> TF </label>
                                <input type="number" name="tf" placeholder="TF" max="100" value="{{ $info->tf }}"
                                    class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    step="any" id="tf" />
                            </div>
                        </div>
                    </fieldset>

                    {{-- Traffic By Source --}}
                    <fieldset class="border border-solid border-gray-300 p-3 w-full">
                        <legend class="font-medium text-gray-900">Traffic by Sources</legend>

                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-7">
                            <div class="flex flex-col gap-2">
                                <label for="direct"> Direct (%) </label>
                                <input type="number" name="direct" placeholder="Direct (%)" value="{{ $info->direct }}"
                                    class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    step="any" id="direct" />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="organicSearch"> Organic Search (%) </label>
                                <input type="number" name="organic_search" placeholder="Organic Search"
                                    value="{{ $info->organic_search }}"
                                    class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    step="any" id="organicSearch" />
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="social"> Social (%) </label>
                                <input type="number" name="social" placeholder="Social" value="{{ $info->social }}"
                                    class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    step="any" id="social" />
                            </div>
                        </div>
                    </fieldset>

                    {{-- Link Info --}}
                    <fieldset class="border border-solid border-gray-300 p-3 w-full">
                        <legend class="font-medium text-gray-900">Link Info</legend>

                        <div class="grid grid-cols-2 gap-7 mb-7">
                            <div class="flex flex-col gap-2">
                                <label for="linkType">Link Type</label>
                                <select name="link_type" id="linkType" class="inputField">
                                    {{-- <option value="">Select Link Type</option> --}}
                                    <option value="do_follow" {{ $info->link_type == 'do_follow' ? 'selected' : ''
                                        }}>DoFollow</option>
                                    <option value="no_follow" {{ $info->link_type == 'no_follow' ? 'selected' : ''
                                        }}>NoFollow</option>
                                    <option value="ugc" {{ $info->link_type == 'ugc' ? 'selected' : '' }}>UGC
                                    </option>
                                </select>
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="linkValidity"> Link Validity </label>
                                <select name="link_validity" id="linkValidity" class="inputField">
                                    {{-- <option value="">Select Link Validity</option> --}}
                                    <option value="1 years" {{ $info->link_validity == '1 years' ? 'selected' : '' }}>1
                                        years</option>
                                    <option value="2 years" {{ $info->link_validity == '2 years' ? 'selected' : '' }}>2
                                        years</option>
                                    <option value="3 years" {{ $info->link_validity == '3 years' ? 'selected' : '' }}>3
                                        years</option>
                                    <option value="4 years" {{ $info->link_validity == '4 years' ? 'selected' : '' }}>4
                                        years</option>
                                    <option value="5 years" {{ $info->link_validity == '5 years' ? 'selected' : '' }}>5
                                        years</option>
                                    <option value="6 years" {{ $info->link_validity == '6 years' ? 'selected' : '' }}>6
                                        years</option>
                                    <option value="7 years" {{ $info->link_validity == '7 years' ? 'selected' : '' }}>7
                                        years</option>
                                    <option value="8 years" {{ $info->link_validity == '8 years' ? 'selected' : '' }}>8
                                        years</option>
                                    <option value="9 years" {{ $info->link_validity == '9 years' ? 'selected' : '' }}>9
                                        years</option>
                                    <option value="10 years" {{ $info->link_validity == '10 years' ? 'selected' : ''
                                        }}>10 years
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-y-5">
                            <div class="flex items-center gap-3">
                                <div class="font-medium">
                                    Homepage Link Allowed ?
                                </div>

                                <div class="grid grid-cols-2 border border-gray-300 divide-x rounded overflow-hidden">
                                    <div>
                                        <input type="radio" name="homepage_link" {{ $info->homepage_link == 'yes' ?
                                        'checked' : '' }} id="homepageYes"
                                        value="yes" class="peer hidden">
                                        <label for="homepageYes"
                                            class="cursor-pointer peer-checked:bg-primary peer-checked:cursor-default text-black px-3 py-1 inline-block">Yes</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="homepage_link" {{ $info->homepage_link == 'no' ?
                                        'checked' : '' }} id="homepageNo"
                                        value="no" class="peer hidden">
                                        <label for="homepageNo"
                                            class="cursor-pointer peer-checked:bg-primary peer-checked:cursor-default text-black px-3 py-1 inline-block">No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="font-medium">
                                    Sidebar Link Allowed ?
                                </div>

                                <div class="grid grid-cols-2 border border-gray-300 divide-x rounded overflow-hidden">
                                    <div>
                                        <input type="radio" name="sidebar_link" {{ $info->sidebar_link == 'yes' ?
                                        'checked' : '' }} id="sidebarYes"
                                        value="yes" class="peer hidden">
                                        <label for="sidebarYes"
                                            class="cursor-pointer peer-checked:bg-primary peer-checked:cursor-default text-black px-3 py-1 inline-block">Yes</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="sidebar_link" {{ $info->sidebar_link == 'no' ?
                                        'checked' : '' }} id="sidebarNo"
                                        value="no" class="peer hidden">
                                        <label for="sidebarNo"
                                            class="cursor-pointer peer-checked:bg-primary peer-checked:cursor-default text-black px-3 py-1 inline-block">No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="font-medium">
                                    Footer Link Allowed ?
                                </div>

                                <div class="grid grid-cols-2 border border-gray-300 divide-x rounded overflow-hidden">
                                    <div>
                                        <input type="radio" name="footer_link" {{ $info->footer_link == 'yes' ?
                                        'checked' : '' }} id="footerYes"
                                        value="yes" class="peer hidden">
                                        <label for="footerYes"
                                            class="cursor-pointer peer-checked:bg-primary peer-checked:cursor-default text-black px-3 py-1 inline-block">Yes</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="footer_link" {{ $info->footer_link == 'no' ? 'checked'
                                        : '' }} id="footerNo"
                                        value="no" class="peer hidden">
                                        <label for="footerNo"
                                            class="cursor-pointer peer-checked:bg-primary peer-checked:cursor-default text-black px-3 py-1 inline-block">No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="font-medium">
                                    CBD Allowed ?
                                </div>

                                <div class="grid grid-cols-2 border border-gray-300 divide-x rounded overflow-hidden">
                                    <div>
                                        <input type="radio" name="cbd" id="cbdYes" {{ $info->cbd == 'yes' ? 'checked' :
                                        '' }} value="yes"
                                        class="peer hidden">
                                        <label for="cbdYes"
                                            class="cursor-pointer peer-checked:bg-primary peer-checked:cursor-default text-black px-3 py-1 inline-block">Yes</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="cbd" id="cbdNo" {{ $info->cbd == 'no' ? 'checked' : ''
                                        }} value="no"
                                        class="peer hidden">
                                        <label for="cbdNo"
                                            class="cursor-pointer peer-checked:bg-primary peer-checked:cursor-default text-black px-3 py-1 inline-block">No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="font-medium">
                                    Crypto Allowed ?
                                </div>

                                <div class="grid grid-cols-2 border border-gray-300 divide-x rounded overflow-hidden">
                                    <div>
                                        <input type="radio" name="crypto" id="cryptoYes" {{ $info->crypto == 'yes' ?
                                        'checked' : '' }} value="yes"
                                        class="peer hidden">
                                        <label for="cryptoYes"
                                            class="cursor-pointer peer-checked:bg-primary peer-checked:cursor-default text-black px-3 py-1 inline-block">Yes</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="crypto" id="cryptoNo" {{ $info->crypto == 'no' ?
                                        'checked' : '' }} value="no"
                                        class="peer hidden">
                                        <label for="cryptoNo"
                                            class="cursor-pointer peer-checked:bg-primary peer-checked:cursor-default text-black px-3 py-1 inline-block">No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="font-medium">
                                    Casino Allowed ?
                                </div>

                                <div class="grid grid-cols-2 border border-gray-300 divide-x rounded overflow-hidden">
                                    <div>
                                        <input type="radio" name="casino" id="casinoYes" {{ $info->casino == 'yes' ?
                                        'checked' : '' }} value="yes"
                                        class="peer hidden">
                                        <label for="casinoYes"
                                            class="cursor-pointer peer-checked:bg-primary peer-checked:cursor-default text-black px-3 py-1 inline-block">Yes</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="casino" id="casinoNo" {{ $info->casino == 'no' ?
                                        'checked' : '' }} value="no"
                                        class="peer hidden">
                                        <label for="casinoNo"
                                            class="cursor-pointer peer-checked:bg-primary peer-checked:cursor-default text-black px-3 py-1 inline-block">No</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </fieldset>

                    {{-- Traffic Countries --}}
                    <fieldset class="border border-solid border-gray-300 p-3 w-full">
                        <legend class="font-medium text-gray-900">Traffic Countries</legend>

                        <div id="visitedCountryList" class="space-y-3">
                            @foreach ($country_percent as $row => $country)
                            <input type="hidden" name="country[]" value="{{ $country->id }}">

                            <div class="flex relative gap-5 items-end">
                                <div class="grid grid-cols-2 gap-7 w-full">

                                    <div class="flex flex-col gap-2">
                                        <label>Select Country Name</label>
                                        <select name="country_id[]" class="inputField country_name">
                                            <option value="">Select Country</option>

                                            @if (!empty($countries) && $countries->isNotEmpty())
                                            @foreach ($countries as $key => $value)
                                            <option value="{{ $value->id }}" {{ $country->country_id == $value->id ?
                                                'selected' : '' }}>
                                                {{ $value->name }}</option>
                                            @endforeach
                                            @endif

                                        </select>
                                    </div>

                                    <div class="flex flex-col gap-2">
                                        <label> Visited Percent (%) </label>
                                        <input type="number" name="percent[]" placeholder="Percent (%)" max="100"
                                            value="{{ $country->percent }}"
                                            class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                            step="any" />
                                    </div>
                                </div>

                                <div class="flex-shrink-0 h-[50px] w-[50px] flex items-center justify-center bg-red-700 cursor-pointer rounded-sm text-white text-lg"
                                    onclick="this.parentElement.remove()">
                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                        viewBox="0 0 1024 1024" fill-rule="evenodd" height="1em" width="1em"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M799.855 166.312c.023.007.043.018.084.059l57.69 57.69c.041.041.052.06.059.084a.118.118 0 0 1 0 .069c-.007.023-.018.042-.059.083L569.926 512l287.703 287.703c.041.04.052.06.059.083a.118.118 0 0 1 0 .07c-.007.022-.018.042-.059.083l-57.69 57.69c-.041.041-.06.052-.084.059a.118.118 0 0 1-.069 0c-.023-.007-.042-.018-.083-.059L512 569.926 224.297 857.629c-.04.041-.06.052-.083.059a.118.118 0 0 1-.07 0c-.022-.007-.042-.018-.083-.059l-57.69-57.69c-.041-.041-.052-.06-.059-.084a.118.118 0 0 1 0-.069c.007-.023.018-.042.059-.083L454.073 512 166.371 224.297c-.041-.04-.052-.06-.059-.083a.118.118 0 0 1 0-.07c.007-.022.018-.042.059-.083l57.69-57.69c.041-.041.06-.052.084-.059a.118.118 0 0 1 .069 0c.023.007.042.018.083.059L512 454.073l287.703-287.702c.04-.041.06-.052.083-.059a.118.118 0 0 1 .07 0Z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="text-right mt-2">
                            <span onclick="visitedCountryList()"
                                class="inline-flex items-center gap-1.5 px-5 py-[10px] text-sm rounded-[4px] bg-tertiary cursor-pointer text-white">
                                <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"
                                    stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="18" height="18" x="3" y="3" rx="2"></rect>
                                    <path d="M8 12h8"></path>
                                    <path d="M12 8v8"></path>
                                </svg>
                                Add Country
                            </span>
                        </div>
                    </fieldset>

                    {{-- Submit Button --}}
                    <div class="flex items-center justify-end">
                        <button type="submit" class="primary-btn"> Update</button>
                    </div>
                </div>

                <!-- Thumbnail area -->
                <div class="w-full">
                    <div id="displayImage"
                        class="border-gray-200 bg-center bg-contain bg-no-repeat bg-gray-200 aspect-[295/244] rounded w-full">
                    </div>
                    <label for="pageImage" class="primary-btn justify-center mt-3">
                        Page Image
                        <i class="fa-solid fa-upload"></i>
                    </label>
                    <input type="file" name="image" id="pageImage" class="hidden" />
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

    .select2-container--default .select2-selection--single,
    .select2-container--default.select2-container--focus .select2-selection--multiple,
    .select2-container--default .select2-selection--multiple {
        height: 50px !important;
        display: flex !important;
        align-items: center !important;
        border-color: #e4e4e4 !important;
    }

    .select2-container--default .select2-selection--single[aria-expanded="true"],
    .select2-container--default.select2-container--focus .select2-selection--multiple[aria-expanded="true"],
    .select2-container--default .select2-selection--multiple[aria-expanded="true"] {
        border-color: #3A9CFD !important
    }

    .select2-selection__arrow {
        height: auto !important;
        top: 50% !important;
        transform: translateY(-50%) !important
    }


    .tags-input {
        display: inline-block;
        position: relative;
    }

    .tags-input ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .tags-input li {
        display: inline-block;
        background-color: #f2f2f2;
        color: #333;
        border-radius: 20px;
        padding: 5px 10px;
        margin-right: 5px;
        margin-bottom: 5px;
    }

    .tags-input input[type="text"] {
        border: none;
        outline: none;
        padding: 5px;
        font-size: 14px;
    }

    .tags-input input[type="text"]:focus {
        outline: none;
    }

    .tags-input .delete-button {
        background-color: transparent;
        border: none;
        color: #999;
        cursor: pointer;
        margin-left: 5px;
    }
</style>
@endpush


@push('footerPartial')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $('#productDesc').summernote({
            placeholder: 'Product Description',
            tabsize: 2,
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });


        // Display Page Thumbnail
        const imageUrl = '{{ asset($info->images) }}';
        document.getElementById('displayImage').style.backgroundImage = 'url(' + imageUrl + ')';

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('displayImage').style.backgroundImage = 'url(' + e.target.result + ')';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.getElementById("pageImage").addEventListener("change", function() {
            readURL(this);
        });

        // Select2 function
        document.addEventListener("DOMContentLoaded", function() {
            var countrySelects = document.querySelectorAll('.country_name');
            countrySelects.forEach(function(select) {
                new Select2(select);
            });

            var multipleSelects = document.querySelectorAll('.js-example-basic-multiple');
            multipleSelects.forEach(function(select) {
                new Select2(select);
            });
        });

        const visitedCountryTemplate = `
            <div class="flex relative gap-5 items-end">
                <div class="grid grid-cols-2 gap-7 w-full">
                    <div class="flex flex-col gap-2">
                        <label >Select Country Name</label>
                        <select name="country_id[]" class="inputField country_name">
                            <option value="">Select Country</option>
                            @if (!empty($countries) && $countries->isNotEmpty())
                            @foreach ($countries as $key => $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label> Visited Percent (%) </label>
                        <input type="number" name="percent[]" placeholder="Percent (%)" max="100" value="0" class="inputField [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" step="any"/>
                    </div>
                </div>

                <div class="flex-shrink-0 h-[50px] w-[50px] flex items-center justify-center bg-red-700 cursor-pointer rounded-sm text-white text-lg" onclick="this.parentElement.remove()">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024" fill-rule="evenodd" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M799.855 166.312c.023.007.043.018.084.059l57.69 57.69c.041.041.052.06.059.084a.118.118 0 0 1 0 .069c-.007.023-.018.042-.059.083L569.926 512l287.703 287.703c.041.04.052.06.059.083a.118.118 0 0 1 0 .07c-.007.022-.018.042-.059.083l-57.69 57.69c-.041.041-.06.052-.084.059a.118.118 0 0 1-.069 0c-.023-.007-.042-.018-.083-.059L512 569.926 224.297 857.629c-.04.041-.06.052-.083.059a.118.118 0 0 1 0-.07c-.022-.007-.042-.018-.083-.059l-57.69-57.69c-.041-.041-.052-.06-.059-.084a.118.118 0 0 1 0-.069c.007-.023.018-.042.059-.083L454.073 512 166.371 224.297c-.041-.04-.052-.06-.059-.083a.118.118 0 0 1 0-.07c.007-.022.018-.042.059-.083l57.69-57.69c.041-.041.06-.052.084-.059a.118.118 0 0 1 .069 0c.023.007.042.018.083.059L512 454.073l287.703-287.702c.04-.041.06-.052.083-.059a.118.118 0 0 1 .07 0Z"></path></svg>
                </div>
            </div>
        `;

        function visitedCountryList() {
            document.getElementById('visitedCountryList').insertAdjacentHTML('beforeend', visitedCountryTemplate);

            var countrySelects = document.querySelectorAll('.country_name');
            countrySelects.forEach(function(select) {
                new Select2(select);
            });
        }

        visitedCountryList();

        // Get the tags and input elements from the DOM
        const tags = document.getElementById('tags');
        const input = document.getElementById('nicheTag');

        // Add an event listener for keydown on the input element
        input.addEventListener('keydown', function(event) {

            // Check if the key pressed is 'Enter'
            if (event.key === 'Enter') {

                // Prevent the default action of the keypress
                // event (submitting the form)
                event.preventDefault();

                // Create a new list item element for the tag
                const tag = document.createElement('li');

                // Get the trimmed value of the input element
                const tagContent = input.value.trim();

                // If the trimmed value is not an empty string
                if (tagContent !== '') {

                    // Set the text content of the tag to
                    // the trimmed value
                    tag.innerText = tagContent;

                    // Add a delete button to the tag
                    tag.innerHTML += '<button class="delete-button">X</button>';
                    tag.innerHTML += '<input type="hidden" name="tags[]"' + ' value="' + tagContent + '" >';

                    // Append the tag to the tags list
                    tags.appendChild(tag);

                    // Clear the input element's value
                    input.value = '';
                }
            }
        });

        // Add an event listener for click on the tags list
        tags.addEventListener('click', function(event) {

            // If the clicked element has the class 'delete-button'
            if (event.target.classList.contains('delete-button')) {

                // Remove the parent element (the tag)
                event.target.parentNode.remove();
            }
        });
</script>
@endpush