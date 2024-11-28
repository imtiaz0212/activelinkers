<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @php($siteInfo = getSiteInfo())
    <meta charset="utf-8">
    <meta name="description" content="{{ $siteInfo->meta_description }}">
    <meta name="author" content="{{ $siteInfo->site_name }}">
    <meta name='identifier-URL' content="{{ url('/') }}">

    <link rel="icon" type="image/x-icon" href="{{ asset($siteInfo->favicon) }}">

    <meta name='og:title' content="{{ $siteInfo->meta_title }}">

    <meta name='og:type' content="Tutorials">
    <meta name='og:url' content="{{ url('/') }}">
    <meta name='og:image' content="{{ asset($siteInfo->logo) }}">
    <meta name='og:site_name' content="{{ $siteInfo->site_name }}">
    <meta name='og:description' content="{{ $siteInfo->meta_description }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $siteInfo->site_name }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Flowbite JS cdn --}}
    <script src="{{ asset('public') }}/vendor/js/flowbite.min.js"></script>

    {{-- DatePicker --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


    <!-- Font awesome cdn -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">

    <!-- Jquery Cdn -->
    <script src="{{ asset('vendor/js/jquery.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        .sidebarHidden .main-content {
            padding-left: 0
        }

        .sidebar {
            left: 0;
            visibility: visible;
            opacity: 1;
        }

        .sidebarHidden .sidebar {
            left: -100%;
            visibility: hidden;
            opacity: 0;
        }


        @media (max-width: 1024px) {
            .sidebarHidden .sidebar {
                left: 0;
                visibility: visible;
                opacity: 1;
            }

            .sidebar {
                left: -100%;
                visibility: hidden;
                opacity: 0;
            }
        }
    </style>
    @stack('headerPartial')
</head>

<body class="overflow-x-hidden">
    {{-- Admin Layout --}}
    @if (Auth::check())
    @php($userData = Auth::user())
    <div class="flex relative">
        <!------------------------ Sidebar Start ------------------------>
        <div class="sidebar w-72 fixed z-[999] transition-all duration-500">
            <!-- Mobile Responsive Button -->
            <div
                class="flex justify-between lg:justify-center items-center border-b border-b-[#19213b] bg-[#232E51] h-20  text-3xl font-bold p-3">
                <a href="{{ route($userData->privilege . '.dashboard') }}">
                    <a href="{{ route('admin.dashboard') }}" class="text-darkblue">
                        @if (!empty($siteInfo->footer_logo))
                        <img class="max-w-[180px] md:max-w-52" src="{{ asset($siteInfo->footer_logo) }}"
                            alt="site logo">
                        @else
                        <div class="font-bold text-2xl">
                            {{ $siteInfo->site_name }}
                        </div>
                        @endif

                    </a>
                </a>

                <svg id="closeBtn" class="lg:hidden cursor-pointer" stroke="#ffffff" fill="none" stroke-width="0"
                    viewBox="0 0 15 15" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M11.7816 4.03157C12.0062 3.80702 12.0062 3.44295 11.7816 3.2184C11.5571 2.99385 11.193 2.99385 10.9685 3.2184L7.50005 6.68682L4.03164 3.2184C3.80708 2.99385 3.44301 2.99385 3.21846 3.2184C2.99391 3.44295 2.99391 3.80702 3.21846 4.03157L6.68688 7.49999L3.21846 10.9684C2.99391 11.193 2.99391 11.557 3.21846 11.7816C3.44301 12.0061 3.80708 12.0061 4.03164 11.7816L7.50005 8.31316L10.9685 11.7816C11.193 12.0061 11.5571 12.0061 11.7816 11.7816C12.0062 11.557 12.0062 11.193 11.7816 10.9684L8.31322 7.49999L11.7816 4.03157Z"
                        fill="#ffffff"></path>
                </svg>
            </div>
            <!------------------------ Include Sidebar List ------------------------>
            @include('layouts.backend-partial.sidebar-' . $userData->privilege)
        </div>
        <!------------------------ Sidebar End ------------------------>

        <!------------------------ Main Content Start ------------------------>
        <div class="main-content  pl-0 lg:pl-72 transition-all duration-500 w-full">
            @include('layouts.backend-partial.header')

            <div id="dashboardMain" class="m-2 md:m-8 border rounded min-h-[calc(100vh-224px)]">
                @yield('content')
            </div>

            <!------------------------ Include Footer ------------------------>
            @include('layouts.backend-partial.footer')
        </div>
        <!------------------------ Main Content End ------------------------>
    </div>
    @else

    {{-- Login Layout --}}
    <div style="background-image: url('{{ asset($siteInfo->login_bg) }}')"
        class="flex items-center justify-center h-screen bg-cover bg-no-repeat relative z-[1] after:absolute after:content-[''] after:left-0 after:top-0 after:right-0 after:bottom-0 after:bg-black/50 after:z-[-1] background_image">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @endif

    @stack('footerPartial')

    <script>
        flatpickr(".datepicker");
    </script>

    @if (Auth::check())
    <script src="{{ asset('js/backend.js') }}"></script>
    @endif
</body>

</html>