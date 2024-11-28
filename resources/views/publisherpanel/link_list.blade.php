@extends('layouts.app')

@section('content')

<div>
    <!-- Link List Header -->
    <div class="flex items-center justify-between bg-gray-50 p-5 border-b rounded">
        <h3 class="text-3xl font-semibold">Link Placement</h3>
    </div>
    <!-- Link List Table -->
    <div class="relative overflow-x-auto shadow-md rounded p-5">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500  border rounded" id="dataTable">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 ">
                <tr>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        Website URL
                    </th>

                    <th scope="col" class="px-6 py-3">
                        DA
                    </th>

                    <th scope="col" class="px-6 py-3">
                        PA
                    </th>

                    <th scope="col" class="px-6 py-3">
                        DR
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Niche
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Traffic
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Organic Keyword
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Price
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Link Insertion Price
                    </th>

                    <th scope="col" class="px-6 py-3 text-right">
                        Action
                    </th>
                </tr>
            </thead>

            <tbody>
                @if (!empty($results))
                @foreach ($results as $key => $row)
                <tr
                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">

                    <td class="px-6 py-4">
                        <a href="{{ url($row->url) }}" target="_blank"
                            class="px-1 py-[2px] rounded text-error bg-error/10 whitespace-nowrap">{{
                            removeHttp($row->url) }}</a>
                    </td>

                    <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $row->da }}%
                    </th>

                    <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $row->pa }}%
                    </th>

                    <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $row->dr }}%
                    </th>

                    <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        @php($nicheItems = json_decode($row->niche))
                        @foreach ($nicheItems as $niche)
                        {{ $nicheList->where('id', $niche)->first()->name . ', ' }}
                        @endforeach
                    </th>

                    <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $row->traffic }}
                    </th>

                    <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $row->organic_keyword }}
                    </th>

                    <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        ${{ $row->linkPrice->owner_price }}
                    </th>

                    <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        ${{ $row->linkPrice->regular_price }}
                    </th>

                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('publisher.link_list.show', $row->id) }}"
                                class="h-8 w-8 rounded duration-300 flex items-center justify-center  bg-blue-600/20 text-blue-600 hover:bg-blue-600 hover:text-white">
                                <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"
                                    stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </a>
                        </div>
                    </td>

                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('footerPartial')
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
<script>
    new DataTable('#dataTable', {
        scrollX: true
    });
</script>
@endpush
