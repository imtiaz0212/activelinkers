@extends('layouts.frontend')
@section('content')
    <div class="error-body">
        <h1 class="error-body__error-title"> @yield('code')</h1>
        <p class="error-body__error-message">@yield('title')</p>
        <p class="error-body__error-messageDetails">The page you are looking for doesn't exist.</p>
        <div class="goback-btn">
            <a class="btn back-btn" href="">Go back</a>
            <a class="btn home-btn" href="{{ route('home') }}">Home</a>
        </div>
    </div>
@endsection

@push('headerPartial')
    <style>
        .error-body {
            max-width: 500px;
            margin: 0 auto;
            padding: 100px 0;
            font-family: Urbanist;
            text-align: center;
        }

        .error-body__error-title {
            color: #000;
            font-size: 100px;
            font-weight: 100;
            line-height: 100%;
            margin-bottom: 0;

        }

        .error-body__error-message {
            color: #101828;
            font-size: 60px;
            font-weight: 600;
            line-height: 72px;
            letter-spacing: -1.2px;
            margin: 30px 0 20px;
        }

        .error-body__error-messageDetails {
            color: #627193;
            font-size: 20px;
            font-weight: 400;
            line-height: 30px;
            /* 150% */
        }

        .goback-btn {
            margin-top: 77px;
            display: flex;
            justify-content: center;
            gap: 20px;

        }

        .goback-btn a {
            text-decoration: none;

        }

        .btn {
            display: flex;
            padding: 16px 40px;
            justify-content: center;
            align-items: center;
            gap: 12px;
            border-radius: 8px;
            border: 1px solid #00005C;
            background: var(--color);
            font-size: 18px;
            font-style: normal;
            color: #627193;
            font-weight: 600;
            line-height: 28px;
            box-shadow: 0px 1px 2px 0px rgba(16, 24, 40, 0.05);
            transition: 0.3s;
        }

        .back-btn:hover,
        .home-btn:hover {
            background: #00005C;
            color: white;
        }
    </style>
@endpush




{{-- <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <style>
            *{
                padding: 0;
                margin: 0;
                box-sizing: border-box;
            }
            body {
                font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            }

            .backBtn{
                display:inline-block;
                padding: 14px 40px;
                border-radius:40px; 
                background-color: #FFC727;
                color: #000000;
                text-decoration: none;
                font-size: 20px;
                transition: .3s;
            }

            .backBtn:hover{
                background-color: #031F42;
                color: #ffffff;
            }

            @media (max-width: 768px) {
                .errorInner{
                    transform: scale(.50);
                }
            }
        </style>
    </head>
    <body style="height: 100vh;width: 100vw;display: flex;align-items:center; justify-content: center;flex-direction: column;overflow:hidden">
        <div class="errorInner" style="display:flex;flex-direction: column; align-items: center;">
            <div  style="position: relative; width: 600px">
                <img src="{{asset('public')}}/images/error.svg" width="600" style="height: auto;width: 100%" alt="Error" />
                <div style="position:absolute;left:88px;top: 150px;background: #ffc727;width:181px;text-align: center;color: #263238">
                    <div style="font-size: 80px;font-weight: bold;line-height: 1">
                        @yield('code')
                    </div>
                    <div style="font-weight: bold;text-transform:uppercase">
                        @yield('message')
                    </div>
                </div>
            </div>
            <a href="{{route('home')}}" class="backBtn">Back Home</a>
        </div>
    </body>
</html> --}}
