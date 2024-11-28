@extends('layouts.app')

@section('content')
<div class="bg-white w-[400px] border border-gray-50 p-7 rounded shadow-xl">
    <h3 class="text-center text-3xl mb-8 text-primary font-syne font-semibold">Login Here</h3>
    <form method="POST"
        action="{{ $url == 'admin' ? route('admin.login') : ($url == 'publisher' ? route('publisher.login') : route('login')) }}"
        class="w-full">
        @csrf
        <div class="flex flex-col gap-4">
            <div class="w-full">
                <input id="email" type="email" placeholder="Enter Your Email"
                    class="border border-gray-200 focus:ring-0 outline-none autofill:!bg-transparent focus:border-primary px-5 py-3 rounded w-full @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div>
                <div class="relative">
                    <input id="password" type="password" placeholder="Your Password"
                        class="border border-gray-200 focus:ring-0 focus:border-primary outline-none px-5 py-3 rounded w-full @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password">
                    <div id="passShowHide" class=" absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer ">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 576 512"
                            height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                            </path>
                        </svg>
                    </div>
                </div>
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <div>
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
                @if (Route::has('password.request'))
                <a class="btn btn-link text-secondary font-medium hover:underline"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
                @endif
            </div>

            <button type="submit" class="w-full  button button--secondary">
                {{ __('Login') }}
            </button>
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
@push('footerPartial')
<script>
    const passordField = document.getElementById('password');
        const showHideEyeIcon = document.getElementById('passShowHide');
        showHideEyeIcon.addEventListener('click', function() {
            if (passordField.type === 'password') {
                passordField.type = 'text';
                showHideEyeIcon.classList.toggle('showHide')

            } else {
                passordField.type = 'password';
                showHideEyeIcon.classList.toggle('showHide')
            }

        })
</script>
@endpush