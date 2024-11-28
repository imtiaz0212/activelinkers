@extends('layouts.app')
@section('content')
<div class="border border-[#E8E8E8] rounded-[4px] py-6 px-[30px]">
    <!-- Update Account Details -->
    <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
        @csrf
        <h5 class="px-[30px] py-2 rounded-[4px] bg-[#F6F6F6] text-[#2B2B2B] font-semibold uppercase mb-5 text-xl">
            UPDATE YOUR ACCOUNT DETAILS
        </h5>
        <div class="flex flex-col gap-1.5">
            <div class="grid grid-cols-2 gap-[10px] items-start">
                <div>
                    <input name="name" type="text" value="{{ $info->name }}" placeholder="Display name"
                        class="inputField" required>
                    <span class="mt-1 block text-[#606060] text-sm italic">How your name will be displayed in the
                        account section and in reviews</span>
                </div>

                <label class="flexItemCenter gap-2 inputField">
                    <img loading="lazy" src="{{ asset('public') }}/images/icons/upload.svg" alt="Upload Icon">
                    <span class="text-[#AFAFAF]"> Profile Picture</span>
                    <input name="avatar" type="file" class="hidden">
                </label>
            </div>

            <input type="email" value="{{ $info->email }}" placeholder="Email address" class="inputField" readonly>
            <input type="tel" name="mobile" value="{{ $info->mobile }}" placeholder="Phone Number" class="inputField"
                required>
            <input type="text" name="address" value="{{ $info->address }}" placeholder="Full Address" class="inputField"
                required>
        </div>

        <button class="bg-[#2F80ED] py-[15px] primary-btn text-white font-lg font-medium mt-5 border-[#2F80ED] text-lg"
            type="submit">
            Update Profile
        </button>
    </form>

    <!-- Update Password -->
    <form method="POST" action="{{ route('user.profile.update-password') }}" class="mt-[60px]">
        @csrf
        <h5 class="px-[30px] py-2 rounded-[4px] bg-[#F6F6F6] text-[#2B2B2B] font-semibold uppercase mb-5 text-xl">
            UPDATE YOUR PASSWORD
        </h5>

        <div class="flex flex-col gap-1.5">
            <input name="current_password" type="password" placeholder="Current Password" class="inputField"
                autocomplete="off" required>
            <input name="password" type="password" placeholder="New Password" class="inputField" required>
            <input name="password_confirmation" type="password" placeholder="Confirm New Password" class="inputField"
                required>
        </div>

        <button class="bg-[#2F80ED] py-[15px] primary-btn text-white font-lg font-medium mt-5 border-[#2F80ED] text-lg"
            type="submit">
            Update Password
        </button>
    </form>
</div>
@endsection