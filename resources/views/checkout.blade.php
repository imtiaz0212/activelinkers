@extends('layouts.frontend')
@section('content')

    @include('layouts.frontend-partial.breadcrumb')

    {{-- ================================
    cart section begins here
    ================================= --}}
    <section class="sectionGap">
        <div class="container max-w-6xl">
            <form action="{{route('cart.stripe.payment')}}" method="POST" class="grid md:grid-cols-2 gap-10 items-start w-full">
                @csrf

                <div class="border rounded-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-secondary/20 via-transparent to-primary/20 text-center p-4">
                        <h4 class="text-2xl font-medium text-darkblue">Billing Details</h4>
                    </div>
                    <div class="p-5">
                        <div class="w-full">
                            <div class="mb-4 flex flex-wrap -mx-2">
                                <div class="w-full md:w-1/2 px-2 mb-4 md:mb-0">
                                    <label class="block text-sm font-medium mb-2" for="first-name">
                                        First name <span class="text-red-500">*</span>
                                    </label>
                                    <input class="inputField py-2 border-gray-300" id="first-name" name="first_name"
                                           type="text" required>
                                </div>
                                <div class="w-full md:w-1/2 px-2">
                                    <label class="block text-sm font-medium mb-2" for="last-name">
                                        Last name <span class="text-red-500">*</span>
                                    </label>
                                    <input class="inputField py-2 border-gray-300" id="last-name" name="last_name"
                                           type="text" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2" for="company">
                                    Company name (optional)
                                </label>
                                <input class="inputField py-2 border-gray-300" id="company" name="company_name"
                                       type="text">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2" for="country">
                                    Country / Region <span class="text-red-500">*</span>
                                </label>
                                <select class="inputField py-2 border-gray-300" id="country" name="country_id" required>
                                    @if(!empty($countryList))
                                        @foreach($countryList as $row)
                                            <option value="{{$row->id}}">{{$row->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2" for="street-address">
                                    Street address <span class="text-red-500">*</span>
                                </label>
                                <input class="inputField py-2 border-gray-300 mb-2" id="street-address" name="address"
                                       type="text"
                                       placeholder="House number and street name" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2" for="city">
                                    Town / City <span class="text-red-500">*</span>
                                </label>
                                <input class="inputField py-2 border-gray-300" id="city" name="city" type="text"
                                       required>
                            </div>
                            <div class="mb-4 flex flex-wrap -mx-2">
                                <div class="w-full md:w-1/2 px-2 mb-4 md:mb-0">
                                    <label class="block text-sm font-medium mb-2" for="state">
                                        State <span class="text-red-500">*</span>
                                    </label>
                                    <input class="inputField py-2 border-gray-300" id="state" name="state" type="text"
                                           required>
                                </div>
                                <div class="w-full md:w-1/2 px-2">
                                    <label class="block text-sm font-medium mb-2" for="zip">
                                        ZIP/Post Code <span class="text-red-500">*</span>
                                    </label>
                                    <input class="inputField py-2 border-gray-300" id="zip" name="zip_code" type="text"
                                           required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2" for="phone">
                                    Phone <span class="text-red-500">*</span>
                                </label>
                                <input class="inputField py-2 border-gray-300" id="phone" name="phone" type="tel"
                                       required>
                            </div>
                            <div class="mb-6">
                                <label class="block text-sm font-medium mb-2" for="email">
                                    Email address <span class="text-red-500">*</span>
                                </label>
                                <input class="inputField py-2 border-gray-300" id="email" name="email" type="email"
                                       required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-10">
                    <div class="border rounded-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-secondary/20 via-transparent to-primary/20 text-center p-4">
                            <h4 class="text-2xl font-medium text-darkblue">Your order</h4>
                        </div>
                        <div id="accordion-collapse" data-accordion="collapse">
                            @php($orderType = [1 => 'Link insertion', 2 => 'Guest posting'])
                            @php($slNo = 0)
                            @foreach ($cart as $id => $row)
                                @php($row = (object)$row)
                                <div class="border-b px-5 py-3">
                                    <div class="flex items-center justify-between">
                                        <h2 id="accordion-collapse-heading-{{++$slNo}}">
                                            <button type="button"
                                                    class="flex text-sm md:text-base items-center justify-between text-left w-full font-medium  text-gray-500 bg-transparent"
                                                    data-accordion-target="#accordion-collapse-body-{{$slNo}}"
                                                    aria-expanded="true"
                                                    aria-controls="accordion-collapse-body-{{$slNo}}">
                                                <span>{{$row->title}} × 1</span>
                                            </button>
                                        </h2>
                                        <span>${{$row->price}}</span>
                                    </div>
                                    <div id="accordion-collapse-body-{{$slNo}}" class="hidden"
                                         aria-labelledby="accordion-collapse-heading-{{$slNo}}">
                                        <ul
                                            class="text-sm md:text-base mt-2 space-y-1 [&>li]:grid [&>li]:grid-cols-[120px_1fr] [&>li]:lg:grid-cols-[220px_1fr] [&>li]:items-center [&>li]:pl-4 [&>li]:relative [&>li]:after:absolute [&>li]:after:size-2.5 [&>li]:after:rounded-full [&>li]:after:bg-secondary [&>li]:after:left-0">
                                            <li>
                                                <span>Order type</span>
                                                <span>
                                            <span
                                                class="bg-secondary text-sm text-white font-normal px-2.5 py-0.5 rounded-full inline-block">{{$orderType[$row->billing_type]}}</span>
                                        </span>
                                            </li>
                                            <li>
                                                <span>Base price</span>
                                                <span>{{$row->general_price}}</span>
                                            </li>
                                            @if($row->niche == "others")
                                                <li>
                                                    <span>Others price</span>
                                                    <span>{{$row->other_price}}</span>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="border-b px-5 py-3 flex items-center justify-between">
                            <span>Subtotal</span>
                            <span>${{number_format($subtotal, 2)}}</span>
                        </div>
                        <div class="border-b px-5 py-3 flex items-center justify-between">
                            <span>Discount</span>
                            <span>${{number_format($discount, 2)}}</span>
                        </div>
                        <div class="px-5 py-3 flex items-center justify-between">
                            <span>Total</span>
                            <span>${{number_format($totalAmount, 2)}}</span>
                        </div>
                    </div>

                    <div class="border rounded-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-secondary/20 via-transparent to-primary/20 text-center p-4">
                            <h4 class="text-2xl font-medium text-darkblue">Payment Method</h4>
                        </div>
                        <div class="p-5 ">
                            <h4 class="text-xl text-darkblue">Stripe</h4>
                            <p>Pay via Stripe.</p>
                            <p class="my-3">
                                Your personal data will be used to process your order, support your experience
                                throughout
                                this website, and for other purposes described in our privacy policy.
                            </p>
                            <button type="submit" class="bg-[#6772E4] block w-full py-2 rounded">
                                <img src="{{asset('public')}}/images/stripe.jpg" alt="Stripe" class="h-7 mx-auto">
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    {{-- ================================
    cart section ends here
    ================================= --}}
@endsection


@push('headerPartial')
@endpush
