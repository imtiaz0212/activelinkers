@extends('layouts.app')
@section('content')

<div>
    <!-- Blog Header -->
    <div class="flex items-center justify-between bg-gray-50 p-5 border-b rounded">
        <h3 class="text-3xl font-semibold">Publishers</h3>
        <a href="{{route('admin.publisher.create')}}" class="primary-btn text-sm">
            Create Publishers
            <i class="fa-solid fa-plus"></i>
        </a>
    </div>


    <!-- User Table -->
    <div class="relative overflow-x-auto shadow-md rounded p-5">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500  border rounded">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 ">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Avatar
                    </th>
                    <th scope="col" class="px-6 py-3">
                        User name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Mobile
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Address
                    </th>
                    <th scope="col" class="px-6 py-3 text-right">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($results))
                @foreach($results as $key => $row)
                @php($avatar = (!empty($row->avatar) ? $row->avatar : 'public/images/chief-placeholder.webp'))
                <tr class="odd:bg-white  even:bg-gray-50 border-b dark:border-gray-700">

                    <td class="px-6 py-4">
                        <img src="{{asset($avatar)}}" class="w-14 h-auto object-contain" alt="User avatar" />
                    </td>

                    <th scope="row" class="px-6 py-4 whitespace-nowrap">
                        {{$row->name}}
                    </th>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="mailto:{{$row->email}}"
                            class="px-1 py-[2px] rounded text-error bg-error/10 whitespace-nowrap">{{$row->email}}</a>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="tel:{{$row->mobile}}"
                            class="px-1 py-[2px] rounded text-error bg-error/10 whitespace-nowrap">{{$row->mobile}}</a>
                    </td>

                    <td class="px-6 py-4">
                        {{$row->address}}
                    </td>

                    <td class="px-6 py-4">

                        <div class="flex items-center justify-end gap-1">

                            <a href="{{route('admin.publisher.edit', $row->id)}}"
                                class="h-8 w-8 rounded duration-300 flex items-center justify-center  bg-green-600/20 text-green-600  hover:bg-green-600 hover:text-white">
                                <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"
                                    stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </a>

                            <a href="{{route('admin.publisher.destroy', $row->id)}}"
                                onclick="return confirm('Do you want to delete this data?')"
                                class="h-8 w-8 rounded duration-300 flex items-center justify-center  bg-red-600/20 text-red-600 hover:bg-red-600 hover:text-white">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                                    height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"
                                        d="m112 112 20 320c.95 18.49 14.4 32 32 32h184c17.67 0 30.87-13.51 32-32l20-320">
                                    </path>
                                    <path stroke-linecap="round" stroke-miterlimit="10" stroke-width="32"
                                        d="M80 112h352"></path>
                                    <path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"
                                        d="M192 112V72h0a23.93 23.93 0 0 1 24-24h80a23.93 23.93 0 0 1 24 24h0v40m-64 64v224m-72-224 8 224m136-224-8 224">
                                    </path>
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