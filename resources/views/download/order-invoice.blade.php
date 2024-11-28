@extends('layouts.frontend')
@section('content')
<section>
    <div class="container p-0 border rounded my-24">

        <div class="w-100% bg-darkblue">
            <div class="flex items-start justify-between py-6 px-16 bg-darkblue rounded-t border border-darkblue">
                <h4 class="text-white text-3xl font-medium font-inter">
                    {{ $siteInfo->site_name }}
                </h4>
                <h4 class="text-white text-3xl font-medium font-inter">Order No. #<span style="font-size: 70%;">{{
                        $orderInfo->order_no }}</span>
            </div>
        </div>

        <div class="grid sm:grid-cols-2 md:grid-cols-5 px-16 pt-6 gap-3">

            <div class="md:col-span-3">

                <table class="w-full border-collapse">
                    <tr>
                        <td class="px-2 py-1">
                            @if(!empty($siteInfo->logo))
                            <img src="{{ asset($siteInfo->logo) }}" alt="Logo" height="34">
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td class="px-2 py-1 text-xl font-bold">
                            {{ (!empty($orderInfo->name) ? strFilter($orderInfo->name) : $orderInfo->company) }}
                        </td>
                    </tr>

                    <tr>
                        <td class="px-2 py-1">
                            <span class="font-bold">Email :</span>
                            {{ $orderInfo->email }}
                        </td>
                    </tr>

                    <tr>
                        <td class="px-2 py-1">
                            <span class="font-bold">Date :</span>
                            {{ !empty($orderInfo->created) ? date('d F, Y', strtotime($orderInfo->created)) : date('d F,
                            Y') }}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="md:col-span-2">
                <table class="w-full border-collapse text-right">

                    <tr>
                        <td class="px-2 py-3">
                            <a href="{{ url('download-order-invoice', $orderInfo->order_no) }}" target="_blank"
                                class="py-3 bg-blue-600 text-blue-600 hover:bg-blue-600/50 hover:text-black transition duration-700 ease-in-out text-center rounded px-16 py-4 text-white">
                                Download as PDF
                            </a>
                        </td>
                    </tr>

                    {{-- <tr>
                        <td class="px-2 py-1">
                            <span class="font-bold">Order No :</span>
                            #{{ $orderInfo->order_no }}
                        </td>
                    </tr> --}}

                    {{-- <tr>
                        <td class="px-2 py-1">
                            <span class="font-bold">Email :</span>
                            {{ $orderInfo->email }}
                        </td>
                    </tr> --}}

                    <tr>
                        <td class="px-2 py-1">
                            <span class="font-bold">Mobile :</span>
                            {{ (!empty($orderInfo->mobile) ? $orderInfo->mobile : '01XXXXXXXXX') }}
                        </td>
                    </tr>

                    <tr>
                        <td class="px-2 py-1">
                            <span class="font-bold">Delivery Date :</span>
                            {{ !empty($orderInfo->delivery_date) ? date('d F, Y', strtotime($orderInfo->delivery_date))
                            : date('d F, Y') }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="px-16 py-6">
            <table class="w-full border-collapse border border-gray-200">
                <thead class="bg-darkblue text-white">
                    <tr class="border">
                        <th class="border border-gray-200 px-2 py-3">Live URL</th>
                        <th class="border border-gray-200 px-2 py-3 w-[90px]">Price</th>
                        <th class="border border-gray-200 px-2 py-3 w-[120px]">Other Price</th>
                        <th class="border border-gray-200 px-2 py-3 w-[150px] whitespance-nowrap">Article Writing</th>
                        <th class="border border-gray-200 px-2 py-3 w-[110px]">Amount</th>
                    </tr>
                </thead>

                <tbody>
                    @if(!empty($orderInfo->orderItem))
                    @foreach($orderInfo->orderItem as $key => $row)
                    <tr>
                        <td class="border border-gray-200 px-2 py-3">{{ $row->live_url }}</td>
                        <td class="border border-gray-200 px-2 py-3 text-center">${{ $row->url_price }}</td>
                        <td class="border border-gray-200 px-2 py-3 text-center">${{ $row->other_price }}</td>
                        <td class="border border-gray-200 px-2 py-3 text-center">${{ $row->artical }}</td>
                        <td class="border border-gray-200 px-2 py-3 text-center">$<span>{{ $row->total }}</span></td>
                    </tr>
                    @endforeach
                    @endif

                    <tr>
                        <th class="border border-gray-200 text-indigo-600/20 px-2 py-3" rowspan="4" colspan="2">
                            @if(!empty($orderInfo->status))
                            <span>
                                {{ strFilter($orderInfo->status) }}
                            </span>
                            @endif
                        </th>
                        <th class="border border-gray-200 px-2 py-3 text-right" colspan="2">Subtotal </th>
                        <th class="border border-gray-200 px-2 py-3">${{ $orderInfo->subtotal }}</th>
                    </tr>

                    <tr>
                        <th class="border border-gray-200 px-2 py-3 text-right" colspan="2">Service Charge </th>
                        <th class="border border-gray-200 px-2 py-3">${{ $orderInfo->service_charge }}</th>
                    </tr>

                    <tr>
                        <th class="border border-gray-200 px-2 py-3 text-right" colspan="2">Tax </th>
                        <th class="border border-gray-200 px-2 py-3">${{ $orderInfo->tax }}</th>
                    </tr>

                    <tr>
                        <th class="border border-gray-200 px-2 py-3 text-right" colspan="2">Discount </th>
                        <th class="border border-gray-200 px-2 py-3">${{ $orderInfo->discount }}</th>
                    </tr>
                </tbody>

                <tfoot>
                    <tr>
                        <th class="border border-gray-200 px-2 py-3 text-right" colspan="4">Total </th>
                        <th class="border border-gray-200 px-2 py-3">${{ $orderInfo->grand_total }}</th>
                    </tr>
                </tfoot>
            </table>

        </div>

        <div class="footer mt-16 px-16 py-6">
            <div class="w-[30%]">
                <div class="border-t-2">
                    <p><span class="font-bold"> {{ (!empty($orderInfo->admin->name) ? $orderInfo->admin->name : "") }}
                        </span></p>
                    <p> {{ (!empty($siteInfo->site_name) ? $siteInfo->site_name : "") }} </p>
                    <p><span class="font-bold">Email :</span> {{ (!empty($orderInfo->emailFrom->email) ?
                        $orderInfo->emailFrom->email : "") }} </p>
                </div>
            </div>

        </div>

        <div class="w-100% bg-darkblue text-white py-4 px-16">
            <p> {{ (!empty($siteInfo->location) ? $siteInfo->location : "") }} </p>
        </div>

    </div>
</section>

@endsection

@push('headerPartial')
@endpush

@push('footerPartial')
@endpush