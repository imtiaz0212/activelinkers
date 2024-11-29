@extends('layouts.app')

@section('content')

<div>
    <!-- Blog Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Blog</h3>
        @if(canAccess(['blog create']))
        <a href="{{ route('admin.blog.create') }}" class="panelHeaderBtn">
            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            Create Blog
        </a>
        @endif
    </div>

    <!-- Blog Table -->
    <div class="custom-data-table">
        <table id="dataTable">
            <thead>
                <tr>
                    <th class="w-32">Date & Time</th>

                    <th>Title</th>

                    <th>Descrption</th>

                    <th class="w-20">Image</th>

                    <th>User</th>

                    <th class="!text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($info) && $info->isNotEmpty())
                @foreach ($info as $row)
                <tr>
                    <td>
                        {{-- <span class="whitespace-nowrap">{{ !empty($row->created) ? date('M d, Y',
                            strtotime($row->created)) : date('M d, Y') }}</span>
                        <br /> --}}

                        <span class="whitespace-nowrap">{{ \Carbon\Carbon::parse($row->created_at)->diffForhumans()
                            }}</span>
                        <br />
                        <span id="readingTime">{{ $row->read_time }} min Read</span>
                    </td>

                    <td>
                        <a href="{{ url('blog-details', $row->page_url) }}" target="_blank"
                            class="max-w-52 block hover:text-secondary hover:underline font-medium">
                            {{ !empty($row->title) ? $row->title : '' }}
                        </a>
                    </td>

                    <td>
                        {{ !empty($row->short_description) ? strLimit($row->short_description, 20) : '' }}
                    </td>

                    <td>
                        @if(!empty($row->featured_image))
                        <img src="{{ !empty($row->featured_image) ? asset($row->featured_image) : asset('/images/placeholder.webp') }}"
                            width="80px" alt="{{ !empty($row->title) ? $row->title : '' }}">
                        @else
                        <div class="size-[50px] bg-gray-100 flex items-center justify-center text-2xl">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
                                height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <g id="Image_On">
                                    <g>
                                        <path
                                            d="M18.435,3.06H5.565a2.5,2.5,0,0,0-2.5,2.5V18.44a2.507,2.507,0,0,0,2.5,2.5h12.87a2.507,2.507,0,0,0,2.5-2.5V5.56A2.5,2.5,0,0,0,18.435,3.06ZM4.065,5.56a1.5,1.5,0,0,1,1.5-1.5h12.87a1.5,1.5,0,0,1,1.5,1.5v8.66l-3.88-3.88a1.509,1.509,0,0,0-2.12,0l-4.56,4.57a.513.513,0,0,1-.71,0l-.56-.56a1.522,1.522,0,0,0-2.12,0l-1.92,1.92Zm15.87,12.88a1.5,1.5,0,0,1-1.5,1.5H5.565a1.5,1.5,0,0,1-1.5-1.5v-.75L6.7,15.06a.5.5,0,0,1,.35-.14.524.524,0,0,1,.36.14l.55.56a1.509,1.509,0,0,0,2.12,0l4.57-4.57a.5.5,0,0,1,.71,0l4.58,4.58Z">
                                        </path>
                                        <path
                                            d="M8.062,10.565a2.5,2.5,0,1,1,2.5-2.5A2.5,2.5,0,0,1,8.062,10.565Zm0-4a1.5,1.5,0,1,0,1.5,1.5A1.5,1.5,0,0,0,8.062,6.565Z">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        @endif
                    </td>

                    <td>
                        <div class="flexItemCenter gap-1">
                            <img class="rounded-full h-10 w-10"
                                src="{{ !empty($row->userList->avatar) ? asset($row->userList->avatar) : asset('/images/placeholder.webp') }}"
                                width="40" height="40" alt="Featured Image">
                            <span class="whitespace-nowrap">{{ !empty($row->userList->name) ? $row->userList->name : ''
                                }}</span>
                        </div>
                    </td>

                    <td>
                        <div class="flex items-center justify-end gap-1">
                            @if(canAccess(['blog edit']))
                            <a href="{{ route('admin.blog.edit', $row->id) }}" class="edit-action-btn">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                            @endif

                            @if(canAccess(['blog destroy']))
                            <a href="{{ route('admin.blog.destroy', $row->id) }}"
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
@endpush

@push('footerPartial')
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
<script>
    new DataTable('#dataTable', {
            scrollX: true,
            // Disable sorting
            "sort": false
        });
</script>
@endpush
