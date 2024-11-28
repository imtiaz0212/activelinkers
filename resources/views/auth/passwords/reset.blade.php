@extends('layouts.app')

@section('content')
<div class="bg-white w-[400px] border border-gray-50 p-7 rounded shadow-xl">
    <h3 class="text-center text-3xl mb-8 text-primary font-syne font-semibold">Reset Password</h3>
    <form method="POST" action="{{route('password.update')}}" class="w-full">
        @csrf

        <input type="hidden" name="token" value="{{$token}}">

        <div class="flex flex-col gap-2">
            <div class="w-full">
                <input id="newPassword" type="password" name="password" placeholder="New Password"
                    class="border border-gray-200 focus:ring-0 outline-none px-5 py-3 rounded w-full @error('newPassword') is-invalid @enderror"
                    name="newPassword" value="{{ old('newPassword') }}" required autocomplete="newPassword" autofocus>
                @error('newPassword')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="w-full">
                <input id="confirmPassword" type="password" name="password_confirmation" placeholder="Confirm Password"
                    class="border border-gray-200 focus:ring-0 outline-none px-5 py-3 rounded w-full @error('confirmPassword') is-invalid @enderror"
                    name="confirmPassword" value="{{ old('confirmPassword') }}" required autocomplete="confirmPassword"
                    autofocus>
                @error('confirmPassword')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <button type="submit"
                class="mt-4 rounded w-full block px-5 py-3 bg-[#3D3ACE] duration-300 hover:bg-[#031F41] text-white btn btn-primary font-medium">
                {{ __('Set New Password') }}
            </button>
            <a class="text-secondary font-semibold text-center" href="{{ route('admin.login') }}">Back to login</a>
        </div>
    </form>
</div>
@endsection
@push('headerPartial')
<style>
    .showHide::before {
        content: "";
        position: absolute;
        transform: rotate(125deg);
        width: 1px;
        height: 21px;
        top: -3px;
        left: 8px;
        background-color: black;
        transition: height .2s;
    }
</style>
@endpush