@extends('layouts.frontend')
@section('content')

    @include('layouts.frontend-partial.breadcrumb')

    {{-- ================================
    cart section begins here
    ================================= --}}
    <section class="sectionGap">
        <div class="container">
            <table class="border border-gray-300 w-full">
                <thead class="bg-secondary text-white">
                <tr>
                    <th class="border border-gray-300 p-4 font-syne text-center w-16">SL</th>
                    <th class="border border-gray-300 p-4 font-syne">Details</th>
                    <th class="border border-gray-300 p-4 font-syne w-36">Final Price</th>
                </tr>
                </thead>
                <tbody>
                @php($orderType = [1 => 'Link insertion', 2 => 'Guest posting'])
                @php($slNo = 0)
                @foreach ($cart as $id => $row)
                    @php($row = (object)$row)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center">{{++$slNo}}</td>
                        <td class="border border-gray-300 px-4 py-2">
                        <span class="space-y-6 block">
                            <h3 class="text-darkblue text-xl font-medium">{{$row->title}}</h3>
                            <ul
                                class="text-lg space-y-2 [&>li]:grid [&>li]:grid-cols-[220px_1fr] [&>li]:items-center [&>li]:pl-4 [&>li]:relative [&>li]:after:absolute [&>li]:after:size-2.5 [&>li]:after:rounded-full [&>li]:after:bg-secondary [&>li]:after:left-0">
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
                                    <span>+${{$row->other_price}}</span>
                                </li>
                                @endif
                            </ul>
                            <button
                                class="inline-flex items-center gap-2 text-red-600 font-medium mt-2 remove-from-cart"
                                data-id="{{$id}}">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                                     height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M331.3 308.7L278.6 256l52.7-52.7c6.2-6.2 6.2-16.4 0-22.6-6.2-6.2-16.4-6.2-22.6 0L256 233.4l-52.7-52.7c-6.2-6.2-15.6-7.1-22.6 0-7.1 7.1-6 16.6 0 22.6l52.7 52.7-52.7 52.7c-6.7 6.7-6.4 16.3 0 22.6 6.4 6.4 16.4 6.2 22.6 0l52.7-52.7 52.7 52.7c6.2 6.2 16.4 6.2 22.6 0 6.3-6.2 6.3-16.4 0-22.6z">
                                    </path>
                                    <path
                                        d="M256 76c48.1 0 93.3 18.7 127.3 52.7S436 207.9 436 256s-18.7 93.3-52.7 127.3S304.1 436 256 436c-48.1 0-93.3-18.7-127.3-52.7S76 304.1 76 256s18.7-93.3 52.7-127.3S207.9 76 256 76m0-28C141.1 48 48 141.1 48 256s93.1 208 208 208 208-93.1 208-208S370.9 48 256 48z">
                                    </path>
                                </svg>
                                Remove item
                            </button>
                        </span>
                        </td>
                        <td class="border border-gray-300 px-4 py-2">${{$row->price}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="border border-gray-300 p-4">
                        <form class="">
                            <input type="text" id="couponCode" placeholder="Coupon code" autocomplete="off"
                                   class="inputField w-auto h-[52px] inline-block border-gray-300">
                            <button type="submit" class="primary-btn" id="applyCoupon" data-text="Apply coupon">Apply
                                coupon
                            </button>
                            <button type="button" class="secondary-btn" id="removeCoupon" data-text="Cancel cart">Cancel
                                cart
                            </button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="border border-gray-300 p-4 text-right text-secondary text-lg">
                        Subtotal
                    </td>
                    <td class="border border-gray-300 p-4 text-right text-secondary text-lg">
                        $<span id="cartSubtotal">{{number_format($subtotal, 2)}}</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="border border-gray-300 p-4 text-right text-secondary text-lg">
                        Discount
                    </td>
                    <td class="border border-gray-300 p-4 text-right text-secondary text-lg">
                        $<span id="cartDiscount">{{number_format($discount, 2)}}</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="border border-gray-300 p-4 text-2xl text-right text-darkblue">
                        Total Amount
                    </td>
                    <td class="p-4 text-right text-2xl text-darkblue">
                        $<span id="cartTotal">{{number_format($totalAmount, 2)}}</span>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="text-right mt-6">
                <a href="{{route('checkout')}}" class="primary-btn  " data-text="Proceed to checkout">Proceed to
                    checkout
                </a>
            </div>
        </div>
    </section>
    {{-- ================================
    cart section ends here
    ================================= --}}
@endsection


@push('footerPartial')
    <script>
        @if(!empty($coupon->code))
        $('#couponCode').val('{{$coupon->code}}').attr('readonly', true);
        $('#applyCoupon').hide();
        $('#removeCoupon').show();
        @else
        $('#couponCode').val('').removeAttr('readonly');
        $('#applyCoupon').show();
        $('#removeCoupon').hide();
        @endif

        $(document).ready(function () {

            // Remove Item
            $('.remove-from-cart').on('click', function () {
                const productId = $(this).data('id');
                $.ajax({
                    url: "{{ route('cart.remove') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
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


            // Apply Coupon
            $('#applyCoupon').on('click', function (e) {
                e.preventDefault();
                const couponCode = $('#couponCode').val().trim();

                if (couponCode.length > 0) {

                    $.ajax({
                        url: "{{ route('cart.applyCoupon') }}",
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            coupon_code: couponCode
                        },
                        success: function (response) {
                            if (response.success) {
                                $('#cartSubtotal').text(response.subtotal.toFixed(2));
                                $('#cartDiscount').text(response.discount.toFixed(2));
                                $('#cartTotal').text(response.total.toFixed(2));

                                $('#couponCode').val(response.coupon.code).attr('readonly', true);
                                $('#applyCoupon').hide();
                                $('#removeCoupon').show();
                            }

                            toastr.success(response.message, 'Success')
                        },
                        error: function () {
                            //console.log('Failed to apply coupon code.');
                            toastr.error('Failed to apply coupon code.', 'Error')
                        }
                    });
                }
            });


            // Remove Coupon
            $('#removeCoupon').on('click', function (e) {
                e.preventDefault();
                const couponCode = $('#couponCode').val();

                if (couponCode.length > 0) {

                    $.ajax({
                        url: "{{ route('cart.removeCoupon') }}",
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            coupon_code: couponCode
                        },
                        success: function (response) {
                            if (response.success) {
                                $('#cartSubtotal').text(response.subtotal.toFixed(2));
                                $('#cartDiscount').text(response.discount.toFixed(2));
                                $('#cartTotal').text(response.total.toFixed(2));

                                $('#couponCode').val('').removeAttr('readonly');
                                $('#applyCoupon').show();
                                $('#removeCoupon').hide();

                                toastr.success(response.message, 'Success')
                            }
                        },
                        error: function () {
                            //console.log('Failed to apply coupon code.');
                            toastr.error('Failed to remove coupon code.', 'Error')
                        }
                    });
                }
            });
        });
    </script>
@endpush
