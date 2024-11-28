@extends('layouts.app')

@section('content')
<div>
    <!-- Blog Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Create Admin</h3>
        <a href="{{ route('admin.user') }}" class="button">
            <i class="fa-solid fa-list-check"></i>
            All Admin
        </a>
    </div>


    <!-- Form -->
    <div class="shadow-md rounded p-5">
        <form action="{{ route('admin.user.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="grid lg:grid-cols-[auto_300px] gap-10">
                <!-- Inputs Area -->
                <div class="grid gap-4">
                    <div class="grid gap-1.5">
                        <label for="name" class="inputLabel">Name</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Full Name"
                            class="inputField" required />
                    </div>
                    <div class="grid gap-1.5">
                        <label for="email" class="inputLabel">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email"
                            class="inputField" required />
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="grid gap-1.5">
                        <label for="mobile" class="inputLabel">Mobile</label>
                        <input type="tel" id="mobile" name="mobile" value="{{ old('mobile') }}" placeholder="Mobile"
                            class="inputField" />
                    </div>
                    <div class="grid gap-1.5">
                        <label for="address" class="inputLabel">Address </label>
                        <textarea id="address" name="address" placeholder="Address"
                            class="inputField h-20">{{ old('address') }}</textarea>
                    </div>

                    <div class="grid lg:grid-cols-2 gap-4">
                        <div class="grid gap-1.5">
                            <label for="password" class="inputLabel">Password</label>
                            <input type="password" id="password" name="password" placeholder="Password"
                                class="inputField mt-2" required />
                        </div>
                        <div class="grid gap-1.5">
                            <label for="passwordConfirm" class="inputLabel">Confirm Password</label>
                            <input type="password" id="passwordConfirm" name="password_confirmation"
                                placeholder="Confirm Password" class="inputField mt-2" required />
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="grid gap-1.5">
                        <label for="role" class="inputLabel">Role</label>
                        <select id="role" name="role" class="inputField" required>
                            <option value="" selected>Select Role</option>
                            @foreach ($roleList as $row)
                            <option value="{{ $row->name }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-center justify-end">
                        <button type="submit" class="button">Submit</button>
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

        document.getElementById("avatarImg").addEventListener("change", function() {
            readURL(this);
        });
</script>
@endpush