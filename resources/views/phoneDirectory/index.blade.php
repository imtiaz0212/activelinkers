@extends('layouts.app')

@section('content')

<div>
    <!-- Phone Directory Header -->
    <div class="flex items-center justify-between bg-gray-50 p-5 border-b rounded">
        <h3 class="text-3xl font-semibold">Phone Directory</h3>
        <button data-modal-target="createModal" data-modal-toggle="createModal" class="text-sm primary-btn">
            Create New
            <i class="fa-solid fa-plus"></i>
        </button>
    </div>


    <!-- Phone Directory Table -->
    <div class="relative overflow-x-auto shadow-md rounded p-5">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500  border rounded">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50  ">
                <tr>
                    <th class="px-6 py-3 w-[50px]">
                        SL
                    </th>
                    <th class="px-6 py-3">
                        Photo
                    </th>
                    <th class="px-6 py-3">
                        Category
                    </th>
                    <th class="px-6 py-3">
                        Designation
                    </th>
                    <th class="px-6 py-3">
                        Phone
                    </th>
                    <th class="px-6 py-3">
                        Mobile
                    </th>
                    <th class="px-6 py-3">
                        Fax
                    </th>
                    <th class="px-6 py-3">
                        Email
                    </th>
                    <th class="px-6 py-3 w-[150px]">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($results as $key => $row)
                @php($avatar = !empty($row->avatar) ? $row->avatar : 'public/images/chief-placeholder.webp')
                <tr class="odd:bg-white  even:bg-gray-50  border-b ">
                    <td scope="row" class="px-6 py-2">
                        {{ $results->firstItem() + $key }}
                    </td>
                    <td class="px-6 py-2">
                        <img src="{{ asset($avatar) }}" alt="Avatar" width="50px" height="50px">
                    </td>
                    <td class="px-6 py-2">
                        {{ $row->category->name }}
                    </td>
                    <td class="px-6 py-2">
                        {{ $row->designation }}
                    </td>
                    <td class="px-6 py-2">
                        {{ $row->phone }}
                    </td>
                    <td class="px-6 py-2">
                        {{ $row->mobile }}
                    </td>
                    <td class="px-6 py-2">
                        {{ $row->fax }}
                    </td>
                    <td class="px-6 py-2">
                        {{ $row->email }}
                    </td>
                    <td class="px-6 py-2">
                        <div class="flex items-center gap-2">
                            <span data-modal-target="updateModal" data-modal-toggle="updateModal"
                                onclick="getDataFn('{{ $row->id }}')"
                                class="font-medium text-blue-600  hover:underline cursor-pointer">Edit</span>

                            <a href="{{ route('admin.phone-directory.destroy', $row->id) }}"
                                onclick="return confirm('Do you want to delete this data?')"
                                class="text-error">Delete</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $results->onEachSide(2)->links() }}
    </div>


    <!-- Create Notice Modal -->
    <div id="createModal" tabindex="-1" aria-hidden="true"
        class="bg-black/70 z-[99999999] hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                    <h3 class="text-2xl font-semibold text-gray-900 ">Create New</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center "
                        data-modal-hide="createModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class=" shadow-md rounded p-5">
                    <form action="{{ route('admin.phone-directory.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-col gap-1.5">

                            <select name="category_id" class="inputField" required>
                                <option value="" selected>Select Category (*)</option>
                                @if (!empty($categoryList) && $categoryList->isNotEmpty())
                                @foreach ($categoryList as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                                @endif
                            </select>

                            <input type="text" name="designation" placeholder="Designation (*)" class="inputField"
                                required />
                            <input type="text" name="phone" placeholder="Phone" class="inputField" />
                            <input type="text" name="mobile" placeholder="Mobile" class="inputField" />
                            <input type="text" name="fax" placeholder="Fax" class="inputField" />
                            <input type="text" name="email" placeholder="Email" class="inputField" />
                            <input type="file" name="avatar" placeholder="Photo" class="inputField" />


                            <div class="flex items-center gap-3 justify-end">
                                <span data-modal-hide="createModal" class="primary-btn bg-[#DC0000]">
                                    Cancel
                                </span>
                                <button type="submit" class="primary-btn"> Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Update Notice Modal -->
    <div id="updateModal" tabindex="-1" aria-hidden="true"
        class="bg-black/70 z-[99999999] hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                    <h3 class="text-2xl font-semibold text-gray-900 ">Update Hot Line</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center "
                        data-modal-hide="updateModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class=" shadow-md rounded p-5">
                    <form action="{{ route('admin.phone-directory.update') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-col gap-1.5">

                            <input type="hidden" name="id" id="phoneDirId">

                            <select name="category_id" id="categoryId" class="inputField" required>
                                <option value="" selected>Select Category (*)</option>
                                @if (!empty($categoryList) && $categoryList->isNotEmpty())
                                @foreach ($categoryList as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                                @endif
                            </select>

                            <input type="text" name="designation" id="phoneDirDesignation" placeholder="Designation (*)"
                                class="inputField" required />
                            <input type="text" name="phone" id="phoneDirPhone" placeholder="Phone" class="inputField" />
                            <input type="text" name="mobile" id="phoneDirMobile" placeholder="Mobile"
                                class="inputField" />
                            <input type="text" name="fax" id="phoneDirFax" placeholder="Fax" class="inputField" />
                            <input type="text" name="email" id="phoneDirEmail" placeholder="Email" class="inputField" />
                            <div id="imageContainer"></div>
                            <input type="file" name="avatar" placeholder="Photo" class="inputField" />

                            <div class="flex items-center gap-3 justify-end">
                                <span data-modal-hide="updateModal" class="primary-btn bg-[#DC0000]">
                                    Cancel
                                </span>
                                <button type="submit" class="primary-btn"> Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footerPartial')
<script>
    function getDataFn(id) {

            $('#phoneDirId').val();
            $('#phoneDirDesignation').val();
            $('#phoneDirPhone').val();
            $('#phoneDirMobile').val();
            $('#phoneDirFax').val();
            $('#phoneDirEmail').val();
            $('#imageContainer').empty();

            $("#categoryId option:selected").removeAttr("selected");

            if (id) {
                $.post('{{ route('admin.phone-directory.edit') }}', {
                    id: id,
                    _token: '{{ csrf_token() }}'
                }).done(function(response) {
                    console.log(response);
                    if (response) {

                        $('#phoneDirId').val(response.id);
                        $('#phoneDirDesignation').val(response.designation);
                        $('#phoneDirPhone').val(response.phone);
                        $('#phoneDirMobile').val(response.mobile);
                        $('#phoneDirFax').val(response.fax);
                        $('#phoneDirEmail').val(response.email);

                        const categoryIdSelector = '#categoryId option[value="' + response.category_id + '"]';
                        $(categoryIdSelector).attr('selected', 'selected');

                        if (response.avatar) {
                            const image = $('<img>').attr('src', "{{ asset('/') }}" + response.avatar).height(
                                60).width(60);
                            $('#imageContainer').append(image);
                        }
                    }
                })
            }
        }
</script>
@endpush