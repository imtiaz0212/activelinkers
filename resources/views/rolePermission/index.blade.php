@extends('layouts.app')
@section('content')
<div>
    <!-- Blog Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Role & Permission</h3>
        @if (canAccess(['role and permission create']))
        <a href="{{ route('admin.role.create') }}" class="panelHeaderBtn">
            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            New Role
        </a>
        @endif
    </div>

    <!-- User Table -->
    <div class="custom-data-table">
        <table id="dataTable">
            <thead>
                <tr>
                    <th width="30">SL</th>

                    <th width="80">Role Name</th>

                    <th>Permissions</th>

                    <th width="80" class="text-right">Action</th>
                </tr>
            </thead>

            <tbody>
                @if (!empty($results))
                @foreach ($results as $key => $row)
                <tr>
                    <td>{{ ++$key }}</td>

                    <td>{{ $row->name }}</td>

                    <td>
                        <div class="min-w-[450px]">
                            @if ($row->name == 'Super Admin')
                            <span class="badge badge-danger mb-2">All Permissions</span>
                            @else
                            @foreach ($row->permissions as $permission)
                            <span class="badge badge-success mb-2" style="text-transform: none;">{{ $permission->name
                                }}</span>
                            @endforeach
                            @endif
                        </div>
                    </td>

                    <td>
                        @if ($row->name != 'Super Admin')
                        <div class="flex items-center justify-end gap-1">
                            @if (canAccess(['role and permission edit']))
                            <a href="{{ route('admin.role.edit', $row->id) }}" class="edit-action-btn">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                            @endif

                            @if (canAccess(['role and permission destroy']))
                            <a href="{{ route('admin.role.destroy', $row->id) }}"
                                onclick="return confirm('Do you want to delete this data?')" class="delete-action-btn">
                                <i class="fa-regular fa-trash-can"></i>
                            </a>
                            @endif
                        </div>
                        @endif
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
            scrollX: true
        });
</script>
@endpush
