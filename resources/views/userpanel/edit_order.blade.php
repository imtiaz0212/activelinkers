@extends('layouts.app')
@section('content')

<div>
    <!-- Pages Header -->
    <div class="flex items-center justify-between bg-gray-50 p-5 border-b rounded">
        <h3 class="text-3xl font-semibold">Edit Order</h3>
        {{-- <a href="" class="flex items-center gap-2 text-sm px-6 py-3 bg-primary rounded text-black">
            Create Team
            <i class="fa-solid fa-plus"></i>
        </a> --}}
    </div>

    <!-- Order Table -->
    <div class="relative overflow-x-auto shadow-md rounded p-5">
        <form class="flex flex-col lg:flex-row  gap-8 justify-between font-poppins"
            action="{{ route('user.order.update') }}" method="POST">
            @csrf
            <div class="lg:w-[51.5%]">

                <span
                    class="block py-3 pl-7 bg-[#F6F6F6] text-xl leading-[160%] font-semibold text-black1 rounded font-roboto">
                    Your Billing Details
                </span>

                <div class="w-full mt-5 lg:mt-[30px] space-y-[10px]">
                    <span class="flex gap-[10px]">

                        <input type="hidden" class="rounded w-full focus:ring-primary focus:border-primary" name="id"
                            value="{{ $orderInfo->id }}">
                        <input type="hidden" class="rounded w-full focus:ring-primary focus:border-primary"
                            name="package_id" value="{{ $orderInfo->package_id }}">
                        <input type="hidden" class="rounded w-full focus:ring-primary focus:border-primary"
                            name="service_id" value="{{ $orderInfo->service_id }}">

                        <input class="rounded w-full focus:ring-primary focus:border-primary" type="text"
                            name="first_name" value="{{ $orderInfo->first_name }}" placeholder="First Name">

                        <input class="rounded w-full focus:ring-primary focus:border-primary" type="text"
                            name="last_name" value="{{ $orderInfo->last_name }}" placeholder="Last Name">

                    </span>

                    <input class="w-full rounded focus:ring-primary focus:border-primary" type="text" name="company"
                        value="{{ $orderInfo->company }}" placeholder="Company Name">

                    <select required
                        class="rounded w-full [&:invalid]:text-[#C8C8C8] w-full rounded focus:ring-primary focus:border-primary"
                        name="country" id="">
                        <option value="" disabled selected>Select A Country / Region</option>
                        <option value="Bangladesh" {{ (($orderInfo->country == "Bangladesh") ? "selected" : "")
                            }}>Bangladesh</option>
                        <option value="India" {{ (($orderInfo->country == "India") ? "selected" : "") }}>India</option>
                        <option value="USA" {{ (($orderInfo->country == "USA") ? "selected" : "") }}>USA</option>
                        <option value="Russia" {{ (($orderInfo->country == "Russia") ? "selected" : "") }}>Russia
                        </option>
                    </select>

                    <input class="rounded w-full focus:ring-primary focus:border-primary" type="text" name="house_no"
                        value="{{ $orderInfo->house_no }}" placeholder="House Number and Street Name">

                    <input class="rounded w-full focus:ring-primary focus:border-primary" type="text" name="apartment"
                        value="{{ $orderInfo->apartment }}" placeholder="Apartment, Suite, Unit, etc. (optional)">

                    <input class="rounded w-full focus:ring-primary focus:border-primary" type="text" name="city"
                        value="{{ $orderInfo->city }}" placeholder="Town / City">

                    <input class="rounded w-full focus:ring-primary focus:border-primary" type="text" name="state"
                        value="{{ $orderInfo->state }}" placeholder="Your State">

                    <input class="rounded w-full focus:ring-primary focus:border-primary" type="number" name="zip_code"
                        value="{{ $orderInfo->zip_code }}" placeholder="ZIP Code">

                    <input class="rounded w-full focus:ring-primary focus:border-primary" type="tel" name="mobile"
                        value="{{ $orderInfo->mobile }}" placeholder="Valid Phone Number">

                    <input class="rounded w-full focus:ring-primary focus:border-primary" type="email" name="email"
                        value="{{ $orderInfo->email }}" placeholder="Your Email address">

                    <textarea class="rounded w-full h-[171px] focus:ring-primary focus:border-primary resize-none"
                        name="description" id=""
                        placeholder="Notes About Your Order, e.g. Special Notes For Delivery.">{{ $orderInfo->description }}</textarea>

                </div>
            </div>
            <div class="lg:w-[48.5%] font-poppins">

                <span
                    class="block py-3 pl-7 bg-[#F6F6F6] text-xl leading-[160%] font-semibold text-black1 rounded font-roboto">
                    Your Order Details
                </span>

                <div class=" my-5 lg:my-[30px]">

                    <div
                        class="flex justify-between block py-3 px-5 lg:px-[30px] bg-[#F6F6F6] text-lg text-opacity-90 font-medium text-black1">
                        <span>SERVICE</span>
                        <span>DETAILS</span>
                    </div>

                    <div class="px-5 lg:px-[30px] bg-[#FDFDFD]">

                        <div
                            class="flex justify-between block pt-2 pb-3 text-[16px] md:text-lg font-normal leading-[160%] text-[#606060] border-b border-b-[#EAEAEA]">
                            <a href="{{ url('service',$orderInfo->page_url) }}" target="_BLANK">
                                <span> {{ $orderInfo->service_category_name }} </span>
                                <small class="text-red-600">({{ strFilter($orderInfo->package_type) }})</small>
                            </a>

                            @if($orderInfo->monthly_price > 0.0)
                            <span>
                                <input type="hidden" class="rounded w-full focus:ring-primary focus:border-primary"
                                    name="package_amount_monthly" id="monthly"
                                    value="{{ (($orderInfo->monthly_price > 0.0) ? $orderInfo->monthly_price : 0) }}">
                                <input type="hidden" class="rounded w-full focus:ring-primary focus:border-primary"
                                    name="package_amount_yearly" id="yearly" value="0">
                                $<span>{{ $orderInfo->monthly_price }}</span><span>/monthly</span>
                            </span>

                            @else

                            <span>
                                <input type="hidden" class="rounded w-full focus:ring-primary focus:border-primary"
                                    name="package_amount_monthly" id="yearly"
                                    value="{{ (($orderInfo->yearly_price > 0.0) ? $orderInfo->yearly_price : 0) }}">
                                <input type="hidden" class="rounded w-full focus:ring-primary focus:border-primary"
                                    name="package_amount_yearly" id="monthly" value="0">
                                $<span>{{ $orderInfo->yearly_price }}</span><span>/yearly</span>
                            </span>
                            @endif

                        </div>

                        <div
                            class="flex justify-between block pt-2 pb-3 text-[16px] md:text-lg font-normal leading-[160%] text-[#606060]">
                            <span>Service Charge </span>
                            <span>
                                <input type="hidden" class="rounded w-full focus:ring-primary focus:border-primary"
                                    name="service_charge" id="serviceCharge" value="{{ '14.99' }}">
                                $<span>{{ '14.99' }}</span>
                            </span>
                        </div>

                    </div>

                    <div
                        class="flex justify-between block py-3 px-5 lg:px-[30px] bg-[#F6F6F6] text-lg text-opacity-90 font-medium text-black1">
                        <span>Total Payment</span>
                        <span>
                            <input type="hidden" class="rounded w-full focus:ring-primary focus:border-primary"
                                name="total_amount" id="totalAmount">
                            $<span id="total"></span>
                        </span>
                    </div>

                </div>
                {{-- credit card payment method --}}

                <input type="hidden" name="card_id"
                    value="{{ (!empty($orderInfo->card_id) ? $orderInfo->card_id : '') }}">
                <input type="hidden" name="order_id"
                    value="{{ (!empty($orderInfo->order_id) ? $orderInfo->order_id : '') }}">

                <label
                    class="space-y-4 md:space-y-0 text-black1 block md:flex items-center justify-between bg-[#F9F9F9] px-4 md:px-[30px] py-4 text-lg font-semibold leading-[160%] [&:has(input:checked)~#credit]:block rounded"
                    for="creditcard">

                    <div class="font-roboto">
                        <input class=" mr-3 focus:ring-[#0F1725]" type="radio" name="method" id="creditcard" {{
                            (!empty($orderInfo->method) ? (($orderInfo->method == "credit_card") ? "checked" : "") : "")
                        }} value="credit_card"/>
                        Pay With Credit Card
                    </div>

                    <span class="pl-6 md:pl-0 flex items-center gap-1">

                        <img class="h-8 w-[51px]" src="{{ asset('public') }}/images/billing/master.png" alt="" />

                        <img class="h-8 w-[51px]" src="{{ asset('public') }}/images/billing/visa.png" alt="" />

                        <img class="h-8 w-[51px]" src="{{ asset('public') }}/images/billing/discover.png" alt="" />

                        <img class="h-8 w-[51px]" src="{{ asset('public') }}/images/billing/american.png" alt="" />

                    </span>
                </label>

                <div id="credit" class="hidden space-y-[10px] mt-[14px]">

                    <input class="rounded w-full focus:ring-primary focus:border-primary" type="number" name="card_no"
                        value="{{ (!empty($orderInfo->card_no) ? $orderInfo->card_no : "") }}" id=""
                        placeholder="Card Number">

                    <span class="flex gap-[10px]">

                        <input class="rounded w-full focus:ring-primary focus:border-primary" type="date"
                            name="card_exp" value="{{ (!empty($orderInfo->card_exp) ? $orderInfo->card_exp : "") }}"
                            id="" placeholder="Card EXP">

                        <input class="rounded w-full focus:ring-primary focus:border-primary" type="number"
                            name="card_cvv" value="{{ (!empty($orderInfo->card_cvv) ? $orderInfo->card_cvv : "") }}"
                            id="" placeholder="Card CVV">

                    </span>
                </div>

                {{-- paypal card payment method --}}
                <label
                    class="text-black1 space-y-4 md:space-y-0  block md:flex items-center justify-between bg-[#F9F9F9] mt-7 px-[30px] py-4 text-lg font-semibold leading-[160%] [&:has(input:checked)~#paypal]:block rounded"
                    for="paypalcard">

                    <div class="font-roboto">
                        <input class=" mr-3 focus:ring-[#0F1725]" type="radio" name="method" id="paypalcard"
                            value="paypal" />
                        Pay With Paypal
                    </div>

                    <img src="{{ asset('public') }}/images/billing/paypal.png" alt="" />

                </label>

                <div id="paypal" class="hidden space-y-[10px] mt-[14px]">

                    <input class="rounded w-full focus:ring-primary focus:border-primary" type="number"
                        name="paypal_card_no" id="" placeholder="Card Number">

                    <span class="flex gap-[10px]">

                        <input class="rounded w-full focus:ring-primary focus:border-primary" type="date"
                            name="paypal_card_exp" id="" placeholder="Card EXP">

                        <input class="rounded w-full focus:ring-primary focus:border-primary" type="number"
                            name="paypal_card_cvv" id="" placeholder="Card CVV">

                    </span>
                </div>

                <p class="text-lg font-normal text-[#606060] mt-3">
                    Your personal data will be used to process your order, support your experience throughout this
                    website, and for other purposes described in our privacy policy.
                </p>

                <div class="mt-5 space-y-[10px]">
                    <label class="flex items-center gap-2 block" for="privacy">
                        <input class="rounded text-darkblue  focus:ring-darkblue" type="checkbox" {{
                            (($orderInfo->agreement == 1) ? "checked" : "") }} name="agreement" id="privacy" required>

                        <span class="text-[#606060] text-sm font-normal leading-[160%]">
                            I've read and agree with
                            <a class="underline" href="{{ url('privacy-policy') }}">Privacy Policy.</a>
                        </span>

                    </label>
                    <label class="block flex items-center gap-2" for="nextpayment">

                        <input class="rounded text-darkblue focus:ring-darkblue" type="checkbox" {{
                            (($orderInfo->remember_me == 1) ? "checked" : "") }} name="remember_me" id="nextpayment">

                        <span class="text-[#606060] text-sm font-normal leading-[160%]">
                            Save My Card For Next Payment.
                        </span>
                    </label>

                </div>

                <div class="w-full flex justify-end">
                    <button class="primary-btn w-2/6 text-center">
                        Update
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 20 20"
                            aria-hidden="true" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10.293 15.707a1 1 0 010-1.414L14.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                            <path fill-rule="evenodd"
                                d="M4.293 15.707a1 1 0 010-1.414L8.586 10 4.293 5.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection


@push('headerPartial')
<style>
    .primary-btn {
        justify-content: center;
    }

    input[type="radio"] {
        color: black;
    }

    input[type="radio"]:focus {
        border-color: black !important;
        color: black !important;
    }
</style>
@endpush
@push('footerPartial')
<script>
    var totalValue =0;

        var serviceCharge = document.getElementById('serviceCharge').value;

        var monthly = document.getElementById('monthly').value;
        totalValue += parseFloat(monthly);

        var yearly = document.getElementById('yearly').value;
        totalValue += parseFloat(yearly);

        totalValue += parseFloat(serviceCharge);

        document.getElementById('totalAmount').value = totalValue.toFixed(3);
        document.getElementById('total').innerHTML = totalValue.toFixed(3);
</script>
@endpush