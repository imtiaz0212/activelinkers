@extends('layouts.app')

@section('content')

<div>
    <!-- Pages Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">All Services</h3>

        <?php /*
            @if (canAccess(['services create']))
            <a href="{{ route('admin.service.create') }}" class="panelHeaderBtn">
                Create Services
                <i class="fa-solid fa-plus"></i>
            </a>
            @endif
            */?>
    </div>

    <!-- Blog Table -->
    <div class="custom-data-table">
        <table id="dataTable">
            <thead>
                <tr>
                    <th>SL</th>

                    <th>Featured Image</th>

                    <th>Service Name</th>

                    <th>Title</th>

                    <!-- <th>Description</th> -->

                    <th>Reach</th>

                    <th>Reach Percent</th>

                    <th class="!text-right">Action</th>
                </tr>

            </thead>
            <tbody>
                @if (!empty($results))
                @foreach ($results as $key => $row)
                <tr>
                    <th>{{ ++$key }}</th>

                    <th>
                        @if(!empty($row->images))
                        <img src="{{ asset($row->images) }}" width="50px" height="50px" alt="Featured Image">
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
                    </th>

                    <td>{{ strFilter($row->serviceCategory->name) }}</td>

                    <th>
                        <a href="{{ url('service', $row->page_url) }}" target="_blank"
                            class="px-1 py-[2px] rounded text-error bg-error/10 whitespace-nowrap">
                            {{ strLimit($row->title, 10) }}
                        </a>
                    </th>

                    <!-- <td >{!-- strLimit($row->description, 20) --}</td> -->

                    <td>{{ strFilter($row->reach) }}</td>

                    <td>{{ strFilter($row->reach_percent) }}</td>

                    <td>
                        <div class="flex items-center justify-end gap-1">
                            @if (canAccess(['services edit']))
                            <a href="{{ route('admin.service.edit', $row->id) }}" class="edit-action-btn">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                            @endif
                            @if (canAccess(['services destroy']))
                            <a href="{{ route('admin.service.destroy', $row->id) }}"
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
