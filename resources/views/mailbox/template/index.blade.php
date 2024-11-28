@extends('layouts.app')

@section('content')

<div>
    <!-- Pages Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Email Templates</h3>
        <!-- Modal toggle -->
        @if (canAccess(['mail email templates create template']))
        <a href="{{ route('admin.email.template.create') }}" class="button">
            <i class="fa-solid fa-plus"></i>
            Create Template
        </a>
        @endif
    </div>

    <!-- Blog Table -->
    <div class="custom-data-table">
        <table class="table" id="dataTable">
            <thead>
                <tr>
                    <th>
                        SL
                    </th>

                    <th>
                        Name
                    </th>
                    <th>
                        Subject
                    </th>

                    <th>
                        Description
                    </th>

                    <th>
                        Status
                    </th>

                    <th class="!text-right">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($results))
                @foreach ($results as $key => $row)
                <tr>
                    <th>
                        {{ ++$key }}
                    </th>

                    <td>
                        {{ strFilter($row->name) }}
                    </td>

                    <td>
                        {{ strFilter($row->subject) }}
                    </td>

                    <td>
                        {!! $row->description !!}
                    </td>

                    <td>
                        <span class="badge {{ $row->status == 1 ? ' badge-success' : 'badge-danger' }}">
                            {{ $row->status == 1 ? 'Active' : 'Inactive' }}
                        </span>
                    </td>

                    <td>
                        <div class="flex items-center justify-end gap-1">
                            @if (canAccess(['mail email templates edit']))
                            <a href="{{ route('admin.email.template.edit', $row->id) }}"
                                class="h-8 w-8 rounded duration-300 flex items-center justify-center  bg-green-600/20 text-green-600  hover:bg-green-600 hover:text-white">
                                <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"
                                    stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </a>
                            @endif
                            @if (canAccess(['mail email templates delete']))
                            <a href="{{ route('admin.email.template.destroy', $row->id) }}"
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
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
@endpush

@push('footerPartial')
<script>
    new DataTable('#dataTable', {
            scrollX: true,
            // Disable sorting
            "sort": false
        });
</script>
@endpush