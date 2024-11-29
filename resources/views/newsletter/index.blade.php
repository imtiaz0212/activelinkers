@extends('layouts.app')

@section('content')

<div>
    <!-- Pages Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Newsletter</h3>
    </div>

    <!-- Blog Table -->
    <div class="custom-data-table">
        <table id="dataTable">
            <thead>
                <tr>
                    <th>SL</th>

                    <th>Email</th>

                    <th>Subscription Date</th>

                    <th class="!text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($results))
                @foreach ($results as $key => $row)
                <tr>
                    <th>{{ ++$key }}</th>

                    <th>{{ $row->email }}</th>

                    <td> {{ !empty($row->created) ? date('d F, Y', strtotime($row->created)) : '' }}</td>

                    <td>
                        <div class="flex items-center justify-end gap-1.5">
                            @if (canAccess(['newsletter destroy']))
                            <a href="{{ route('admin.newsletter.destroy', $row->id) }}"
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
