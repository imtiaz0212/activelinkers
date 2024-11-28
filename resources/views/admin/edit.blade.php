@extends('layouts.app')

@section('content')
<div>
    <!-- Blog Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Edit Admin</h3>
        <a href="{{ route('admin.user') }}" class="panelHeaderBtn">
            <i class="fa-solid fa-list-check"></i>
            All Admin
        </a>
    </div>


    <!-- Form -->
    <div class="shadow-md rounded p-5 grid gap-10">
        {{-- Update Information --}}
        <form action="{{ route('admin.user.update', $info->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="grid lg:grid-cols-[auto_300px] gap-10">
                <div class="grid gap-4">
                    <div class="grid gap-1.5">
                        <label for="name" class="inputLabel">Name</label>
                        <input id="name" type="text" name="name" value="{{ $info->name }}" placeholder="Full Name"
                            class="inputField" required />
                    </div>
                    <div class="grid gap-1.5">
                        <label for="email" class="inputLabel">Email</label>
                        <input id="email" type="email" name="email" value="{{ $info->email }}" placeholder="Email"
                            class="inputField" required />
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="grid gap-1.5">
                        <label for="mobile" class="inputLabel">Mobile</label>
                        <input id="mobile" type="tel" name="mobile" value="{{ $info->mobile }}" placeholder="Mobile"
                            class="inputField" />
                    </div>
                    <div class="grid gap-1.5">
                        <label for="address" class="inputLabel">Address</label>
                        <textarea id="address" name="address" placeholder="Address"
                            class="inputField h-20">{{ $info->address }}</textarea>
                    </div>
                    <div class="grid gap-1.5">
                        <label for="role" class="inputLabel">Role</label>
                        <select id="role" name="role" class="inputField" required>
                            <option value="" selected>Select Role</option>
                            @foreach ($roleList as $row)
                            <option value="{{ $row->name }}" {{ $row->name === $info->getRoleNames()->first() ?
                                'selected' : '' }}>
                                {{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-center justify-end">
                        <button type="submit" class="button">Update</button>
                    </div>
                </div>

                <!-- Avatar area -->
                <div class="w-full order-first lg:order-last">
                    <div id="displayAvatar"
                        class="relative border bg-center bg-contain bg-no-repeat bg-white aspect-[295/244] rounded w-full">
                    </div>
                    <label for="avatarImg" class="button button--secondary w-full mt-3">
                        <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"
                            height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        Upload Avatar
                    </label>
                    <input type="file" name="avatar" id="avatarImg" class="hidden" />
                </div>
            </div>
        </form>

        {{-- Update Password --}}
        <div class="grid lg:grid-cols-[auto_300px] gap-10">
            <div class="border rounded grid bg">
                <form action="{{ route('admin.user.update-password', $info->id) }}" method="post"
                    class="w-full grid gap-1.5">
                    @csrf

                    <div class="panelHeader bg-darkblue text-white">
                        <h3 class="panelHeaderTitle text-center lg:text-xl">Update Password</h3>
                    </div>

                    <div class="p-5">
                        <div class="grid xl:grid-cols-3 gap-1 md:gap-5 mb-3">
                            <div class="grid gap-1.5">
                                <label for="currentPassword" class="inputLabel">Current Password</label>
                                <input name="current_password" id="currentPassword" type="password"
                                    placeholder="********" class="inputField mt-2" autocomplete="off" required>
                            </div>
                            <div class="grid gap-1.5">
                                <label for="password" class="inputLabel">New Password</label>
                                <input name="password" id="password" type="password" placeholder="********"
                                    class="inputField mt-2" required>
                            </div>
                            <div class="grid gap-1.5">
                                <label for="passwordConfirm" class="inputLabel">Confirm New Password</label>
                                <input name="password_confirmation" id="passwordConfirm" type="password"
                                    placeholder="********" class="inputField mt-2" required>
                            </div>
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="button">Update Password</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="w-full"></div>
        </div>
    </div>
</div>
@endsection

@push('footerPartial')
<script>
    @if (!empty($info->avatar))
            const imagePath = "{{ asset($info->avatar) }}";
            document.getElementById('displayAvatar').style.backgroundImage = 'url(' + imagePath + ')';
        @endif

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

        document.getElementById("avatarImg").addEventListener("change", function() {
            readURL(this);
        });
</script>
@endpush