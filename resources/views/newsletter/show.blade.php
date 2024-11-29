@extends('layouts.app')

@section('content')

@php
use Carbon\Carbon;

$createdAt = $info->created_at;
$formattedDate = Carbon::parse($createdAt)->format('F jS Y, h:i A');
@endphp

<div>
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Show Message</h3>
        <a href="{{ route('admin.inbox') }}" class="panelHeaderBtn">
            <i class="fa-solid fa-list-check"></i>
            All Message
        </a>
    </div>
    <!-- mail body s -->
    <div class="px-4 grid gap-5 max-w-6xl mx-auto py-8">
        <div class="flex items-center flex-wrap justify-between border-b border-dashed pb-3 ">
            <div class="flex items-center gap-2.5 ">
                <div
                    class="size-12 rounded-full text-xl font-bold text-white bg-primary flex items-center justify-center">
                    {{substr($info->first_name, 0, 1)}}
                </div>
                <div>
                    <p class="text-lg leading-none font-semibold text-gray-700">{{$info->first_name}}
                        {{$info->last_name}}
                    </p>
                    <small class="text-sm text-gray-600 leading-none">{{$info->email}}</small>
                </div>
            </div>
            <p class="text-lg text-gray-600">
                {{$formattedDate}}
            </p>
        </div>

        <div class="space-y-5">
            <h3 class="text-xl  text-gray-700"> <span class="font-medium">Subject:</span>
                {{$info->subject}}
            </h3>

            <p class="text-lg font-normal text-gray-600">
                {{$info->message}}
            </p>
        </div>


    </div>

</div>
@endsection