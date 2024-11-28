@extends('layouts.app')

@section('content')
<div>
    <!-- Blog Header -->
    <div class="flex items-center justify-between bg-gray-50 p-5 border-b rounded">
        <h3 class="text-3xl font-semibold">Create Publisher</h3>
        <a href="{{ route('admin.publisher') }}" class="primary-btn text-sm">
            All Publisher
            <i class="fa-solid fa-list-check"></i>
        </a>
    </div>


    <!-- Form -->
    <div class="shadow-md rounded p-5">
        <form action="{{ route('admin.publisher.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-[auto_300px] gap-10">
                <!-- Inputs Area -->
                <div class="flex flex-col gap-1.5">
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Full Name" class="inputField"
                        required />
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="inputField"
                        required />

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    <input type="tel" name="mobile" value="{{ old('mobile') }}" placeholder="Mobile"
                        class="inputField" />
                    <textarea name="address" placeholder="Address"
                        class="inputField h-20">{{ old('address') }}</textarea>
                    <div class="grid lg:grid-cols-2 gap-[10px]">
                        <input type="password" name="password" placeholder="Password" class="inputField" />
                        <input type="password" name="password_confirmation" placeholder="Confirm Password"
                            class="inputField" />
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="flex items-center justify-end">
                        <button type="submit" class="primary-btn">
                            Submit
                        </button>
                    </div>
                </div>

                <!-- Avatar area -->
                <div class="w-full">
                    <div id="displayAvatar"
                        class="border-gray-200 bg-center bg-contain bg-no-repeat bg-gray-200 aspect-[295/244] rounded w-full">
                    </div>
                    <label for="avatarImg" class="primary-btn justify-center mt-3">
                        Upload Avatar
                        <i class="fa-solid fa-upload"></i>
                    </label>
                    <input type="file" name="avatar" id="avatarImg" class="hidden" />
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('footerPartial')
<script>
    // Display User Avatar
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById('displayAvatar').style.backgroundImage = 'url(' + e.target.result + ')';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        document.getElementById('avatarImg').addEventListener('change', function() {
            readURL(this);
        });
</script>
@endpush