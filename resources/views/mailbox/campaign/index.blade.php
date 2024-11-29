@extends('layouts.app')

@section('content')

<div>
    <!-- Pages Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">My Campaigns</h3>
        <!-- Modal toggle -->
        @if (canAccess(['mail my campaigns create']))
        <a href="{{ route('admin.email') }}" class="button">
            <i class="fa-solid fa-plus"></i>
            Create Campaign
        </a>
        @endif
    </div>

    <div class="mb-4 px-4">
        <div class="relative mt-5 ">
            <div class="grid sm:grid-cols-2 gap-8">

                <a href="{{route('admin.email.pending')}}"
                    class="p-8 text-white flex flex-col gap-1 rounded overflow-hidden relative !bg-[#f7fee7] dashboardCard">
                    <span class="text-xl font-syne font-medium firstLetter before:!text-[#d9e3c0] text-gray-700">Pending
                        Mail</span>
                    <span class="text-3xl font-bold [letter-spacing:2px] text-darkblue">{{$pendingMail}}</span>
                </a>

                <a href="{{route('admin.email.failed')}}"
                    class="p-8  text-white flex flex-col gap1  rounded overflow-hidden relative !bg-[#ecfeff] dashboardCard">
                    <span class="text-xl font-syne font-medium firstLetter before:!text-[#c9e0e1] text-gray-700">Failed
                        Mail</span>
                    <span class="text-3xl font-bold [letter-spacing:2px] text-darkblue">{{$failedMail}}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Blog Table -->
    <div class="custom-data-table">
        <table class="table" id="dataTable">
            <thead>
                <tr>
                    <th>SL</th>

                    <th>Date</th>

                    <th>Category</th>

                    <th>From</th>

                    <th>Subject</th>

                    <th>Template</th>

                    <th class="!w-[180px]">Total Email</th>

                    <th class="!text-right" width="30">Action</th>
                </tr>
            </thead>

            <tbody>

                @if (!empty($results))
                @foreach ($results as $key => $row)
                <tr>
                    <th>{{ ++$key }}</th>

                    <td>{{ dateFormat($row->created, 'M d, Y') }}</td>

                    <td>{{ strFilter($row->name) }}</td>

                    <td>{{ strFilter($row->email_name) }}</td>

                    <td>{{ strFilter($row->subject) }}</td>

                    <td>{{ strFilter($row->template_name) }}</td>

                    @php
                    $total = 100 / $row->total_email * $row->total_send;
                    @endphp

                    <td class="!w-[180px]">
                        <div class="w-full bg-gray-100 rounded-full relative overflow-hidden">
                            <div class="h-5 bg-green-400 text-xs font-semibold text-black text-center p-0.5 leading-none rounded-full"
                                style="width: {{$total}}%">
                                <span
                                    class="absolute left-1/2 top-1/2 text-center block left-0 right-0 -translate-y-1/2 -translate-x-1/2">{{$row->total_send}}/{{$row->total_email}}</span>
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="flex items-center justify-end gap-1">
                            {{--@if (canAccess(['mail my campaigns edit']))
                            <a href="{{ route('admin.email.campaign.edit', $row->id) }}"
                                class="h-8 w-8 rounded duration-300 flex items-center justify-center  bg-green-600/20 text-green-600  hover:bg-green-600 hover:text-white">
                                <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"
                                    stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </a>
                            @endif--}}
                            @if (canAccess(['mail my campaigns delete']))
                            <a href="{{ route('admin.email.campaign.destroy', $row->id) }}"
                                onclick="return confirm('Do you want to delete this data?')" class="delete-action-btn">
                                <i class="fa-regular fa-trash-can"></i>
                            </a>
                            @endif
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

@push('headerPartial')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.dataTables.css">
<link rel="stylesheet" href="{{ asset('public/css/custom-data-table.css') }}">
<style>
    .firstLetter::before {
        content: attr(data-capitalized-text);
        font-weight: bold;
        color: #f788208a;
        position: absolute;
        right: 25px;
        bottom: 25px;
        font-size: 55px;
    }
</style>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
@endpush

@push('footerPartial')
<script>
    new DataTable('#dataTable', {
            scrollX: true,
            // Disable sorting
            "sort": false
        });
        document.addEventListener('DOMContentLoaded', () => {
            const spanElements = document.querySelectorAll('.firstLetter');
            spanElements.forEach(spanElement => {
                let textContent = spanElement.textContent.trim();
                let firstLetter = textContent.charAt(0).toUpperCase();

                spanElement.setAttribute('data-capitalized-text', firstLetter);
            });
        });
</script>
@endpush
