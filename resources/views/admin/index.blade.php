@extends('layouts.app')
@section('content')

<div>
    <!-- Blog Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">All Admin</h3>
        @if(canAccess(['admins create']))
        <a href="{{ route('admin.user.create') }}" class="panelHeaderBtn">
            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            Create Admin
        </a>
        @endif
    </div>

    <!-- User Table -->
    <div class="custom-data-table">
        <table id="dataTable">
            <thead>
                <tr>
                    <th>Avatar</th>

                    <th>User name</th>

                    <th>Email</th>

                    <th>Mobile</th>

                    <th>Address</th>

                    <th>Role</th>

                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($results))
                @foreach ($results as $key => $row)
                @php($role = $row->getRoleNames()->first())
                @php($avatar = !empty($row->avatar) ? $row->avatar : 'public/images/chief-placeholder.webp')
                <tr>
                    <td>
                        <img src="{{ asset($avatar) }}" class="w-14 h-auto object-contain" alt="User avatar" />
                    </td>

                    <th>{{ $row->name }}</th>

                    <td>
                        <a href="mailto:{{ $row->email }}"
                            class="px-1 py-[2px] rounded text-error bg-error/10 whitespace-nowrap">{{ $row->email }}</a>
                    </td>

                    <td>
                        <a href="tel:{{ $row->mobile }}"
                            class="px-1 py-[2px] rounded text-error bg-error/10 whitespace-nowrap">{{ $row->mobile
                            }}</a>
                    </td>

                    <td>{{ $row->address }}</td>

                    <td>{{ $role }}</td>

                    <td>
                        <div class="flex items-center justify-end gap-1">
                            @if(canAccess(['admins edit']))
                            <a href="{{ route('admin.user.edit', $row->id) }}" class="edit-action-btn">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>
                            @endif

                            @if(canAccess(['admins destroy']))
                            <a href="{{ route('admin.user.destroy', $row->id) }}"
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
