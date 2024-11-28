@extends('layouts.app')

@section('content')
<div>
    <!-- User Header -->
    <div class="flex items-center justify-between bg-gray-50 p-5 border-b rounded">
        <h3 class="text-3xl font-semibold">Edit User</h3>
        @if (Auth::user()->privilege == 'admin')
        <a href="{{ route('admin.users') }}" class="primary-btn text-sm">
            All Users
            <i class="fa-solid fa-list-check"></i>
        </a>
        @endif
    </div>


    <!-- Form -->
    <div class="shadow-md rounded p-5 flex flex-col gap-10">
        {{-- Update Information --}}
        <form action="{{ route('user.user.update', $info->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-[auto_300px] gap-10">
                <div class="flex flex-col gap-1.5">
                    <input type="text" name="name" value="{{ $info->name }}" placeholder="Full Name" class="inputField"
                        required />
                    <input type="email" name="email" value="{{ $info->email }}" placeholder="Email" class="inputField"
                        required />

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    <input type="tel" name="mobile" value="{{ $info->mobile }}" placeholder="Mobile"
                        class="inputField" />
                    <textarea name="address" placeholder="Address"
                        class="inputField h-20">{{ $info->address }}</textarea>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="primary-btn">
                            Update Profile
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

        {{-- Update Password --}}
        <form action="{{ route('user.user.update-password', $info->id) }}" method="post"
            class="max-w-[1110px] flex flex-col gap-1.5">
            @csrf
            <div class="bg-gray-100 py-4 px-6 rounded text-xl font-medium">
                Update Password
            </div>
            <input name="current_password" type="password" placeholder="Current Password" class="inputField"
                autocomplete="off" required>
            <input name="password" type="password" placeholder="New Password" class="inputField" required>
            <input name="password_confirmation" type="password" placeholder="Confirm New Password" class="inputField"
                required>

            <div class="flex items-center justify-end">
                <button type="submit" class="primary-btn">
                    Update Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('footerPartial')
<script>
    const imagePath = "{{ asset($info->avatar) }}";
        document.getElementById('displayAvatar').style.backgroundImage = 'url(' + imagePath + ')';

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('displayAvatar').style.backgroundImage = 'url(' + e.target.result + ')';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.getElementById("avatarImg").addEventListener("change", function() {
            readURL(this);
        });
</script>
@endpush