@extends('layouts.app')
@section('content')
<div>
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Create Role</h3>
        <a href="{{ route('admin.role') }}" class="button">
            <i class="fa-solid fa-list-check"></i>
            All Role
        </a>
    </div>

    <div class="shadow-md rounded p-5">
        <form action="{{ route('admin.role.store') }}" method="post" enctype="multipart/form-data" id="roleForm">
            @csrf

            <div class="flex flex-col gap-2 pb-2">
                <label class="text-lg font-medium" for="role">
                    Role
                </label>

                <input type="text" name="role" id="role" placeholder="Role" class="inputField">
            </div>

            <div class="my-3">
                <label class="my-3 inline-flex cursor-pointer items-center">
                    <input type="checkbox" value="all" class="peer sr-only" id="allChecked" />
                    <div
                        class="peer-checked:bg-backendPrimary peer relative h-6 w-11 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-blue-300 rtl:peer-checked:after:-translate-x-full">
                    </div>
                    <span class="ms-1  font-medium text-gray-900  text-xl">All Permissions</span>
                </label>
                @foreach ($results as $label => $permissions)
                <div class="grid gap-3 md:gap-4 py-3">
                    <div class="px-4 py-2 bg-gray-100">
                        <h3 class="font-medium text-lg">{{ $label }}</h3>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        @foreach ($permissions as $key => $row)
                        <label class="inline-flex cursor-pointer items-center  relative" for="{{ $row->id }}">
                            <input type="checkbox" name="permissions[]" value="{{ $row->name }}" id="{{ $row->id }}"
                                class="peer sr-only itemChecked">
                            <div
                                class="peer-checked:bg-backendPrimary peer relative h-6 w-11 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-blue-300 rtl:peer-checked:after:-translate-x-full">
                            </div>
                            <span class="ms-2 text-sm font-medium text-gray-900 ">
                                {{ $row->name }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="button">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('footerPartial')
<script>
    $('#roleForm').on('change', '.itemChecked', function() {
            if ($('.itemChecked:checked').length == $('.itemChecked').length) {
                $('#allChecked').prop('checked', true);
            } else {
                $('#allChecked').prop('checked', false);
            }
        });

        $('#allChecked').on('click', function(e) {
            $('.itemChecked').not(this).prop('checked', this.checked);
        });
</script>
@endpush