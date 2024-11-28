@extends('layouts.app')

@section('content')
<div class="bg-white w-[400px] border border-gray-50 p-7 rounded shadow-xl">
    <h3 class="text-center text-3xl mb-8 text-primary font-syne font-semibold">Forgot Password?</h3>
    <form method="POST" action="{{route('password.email')}}" class="w-full">
        @csrf
        <div class="flex flex-col gap-3">
            <div class="w-full">
                <input id="email" type="email" placeholder="Enter Your Email"
                    class="border border-gray-200 focus:ring-0 focus:border-primary outline-none px-5 py-3 rounded w-full @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <button type="submit" class="w-full  button button--secondary">
                {{ __('Send Reset Mail') }}
            </button>
            <a class="text-secondary font-medium hover:underline text-center" href="{{ route('admin.login') }}">Back to
                login</a>
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