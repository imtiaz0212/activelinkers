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
                            <a href="{{ route('admin.email.template.edit', $row->id) }}" class="edit-action-btn">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                            @endif
                            @if (canAccess(['mail email templates delete']))
                            <a href="{{ route('admin.email.template.destroy', $row->id) }}"
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
