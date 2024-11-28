@extends('layouts.app')

@section('content')
<div>

    <!-- Slider Header -->
    <div class="flex items-center justify-between bg-gray-50 p-5 border-b rounded">
        <h3 class="text-3xl font-semibold">Slider</h3>
        <button data-modal-target="createModal" data-modal-toggle="createModal" class="text-sm primary-btn">
            Create Slider
            <i class="fa-solid fa-plus"></i>
        </button>
    </div>


    <!-- Slider Table -->
    <div class="relative overflow-x-auto shadow-md rounded p-5">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500  border rounded">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50  ">
                <tr>
                    <th class="px-6 py-3 w-[50px]">
                        SL
                    </th>
                    <th class="px-6 py-3">
                        Image
                    </th>
                    <th class="px-6 py-3">
                        Title
                    </th>

                    <th class="px-6 py-3">
                        Link
                    </th>

                    <th class="px-6 py-3 w-[150px]">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($results as $key => $row)
                <tr class="odd:bg-white  even:bg-gray-50  border-b ">
                    <td scope="row" class="px-6 py-4">
                        {{ $key + $results->firstItem() }}
                    </td>
                    <td class="px-6 py-4">
                        <a data-fslightbox="gallery" href="{{ asset($row->image_path) }}">
                            <img src="{{ asset($row->image_path) }}" width="45" alt="PDF Icon">
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        {{ $row->title }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $row->link }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <span data-modal-target="updateModal" data-modal-toggle="updateModal"
                                onclick="getDataFn('{{ $row->id }}')"
                                class="font-medium text-blue-600  hover:underline cursor-pointer">Edit</span>
                            <a href="{{ route('admin.slider.destroy', $row->id) }}"
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
                    <h3 class="text-2xl font-semibold text-gray-900 ">Create Slider</h3>
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
                    <form action="{{ route('admin.slider.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-col gap-1.5">

                            <textarea name="title" class="inputField" placeholder="Title"></textarea>
                            <p>Image Size (800X400)px</p>
                            <input type="file" name="image_path" placeholder="" class="inputField" required />
                            <input type="text" name="link" placeholder="Link" class="inputField" />

                            <div class="flex items-center gap-3 justify-end">
                                <span data-modal-hide="createModal" class="primary-btn bg-[#DC0000]">
                                    Cancel
                                </span>
                                <button type="submit" class="primary-btn">Submit</button>
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
                    <h3 class="text-2xl font-semibold text-gray-900 ">Update Notice</h3>
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
                    <form action="{{ route('admin.slider.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-col gap-1.5">

                            <input type="hidden" name="id" id="sliderId" />

                            <textarea name="title" class="inputField" id="sliderTitle" placeholder="Title"></textarea>
                            <div id="imageContainer"></div>
                            <p>Image Size (800X400)px</p>
                            <input type="file" name="image_path" placeholder="" class="inputField" />
                            <input type="text" name="link" id="sliderLink" placeholder="Link" class="inputField" />

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
<!-- fslightbox  -->
<script src="{{ asset('public') }}/vendor/js/fslightbox.js"></script>

<script>
    function getDataFn(id) {

            $('#sliderId').val();
            $('#sliderLink').val();
            $('#sliderTitle').val();
            $('#imageContainer').empty();

            if (id) {
                $.post('{{ route('admin.slider.edit') }}', {
                    id: id,
                    _token: '{{ csrf_token() }}'
                }).done(function(response) {
                    if (response) {
                        $('#sliderId').val(response.id);
                        $('#sliderTitle').val(response.title);
                        $('#sliderLink').val(response.link);

                        if (response.image_path) {
                            const image = $('<img>').attr('src', "{{ asset('/') }}" + response.image_path)
                                .height(60).width(60);
                            $('#imageContainer').append(image);
                        }
                    }
                })
            }
        }
</script>
@endpush