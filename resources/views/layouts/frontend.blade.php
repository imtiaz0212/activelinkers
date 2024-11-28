<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/x-icon" href="{{ asset($siteInfo->favicon) }}">









    @hasSection('headerMeta')
    @yield('headerMeta')
    @else
    @php
    $metaTitle = $metaDescription = $metaKeywords = strFilter(config('app.name'));
    $metaImage = 'images/website.png';
    if (!empty($siteInfo)) {
    $metaTitle = $siteInfo->meta_title;
    $metaDescription = $siteInfo->meta_description;
    $metaKeywords = $siteInfo->meta_tag;
    $metaImage       = !empty($siteInfo->meta_image) ? $siteInfo->meta_image : $metaImage;
    }
    @endphp

    <title>{{ $metaTitle }}</title>
    <meta name="title" content="{{ $metaTitle }}">
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="keywords" content="{{ $metaKeywords }}">

    <meta name='og:title' content="{{ $metaTitle }}">
    <meta name='og:image' content="{{ asset($metaImage) }}">
    <meta name='og:site_name' content="{{ $metaTitle }}">
    <meta name='og:description' content="{{ $metaDescription }}">
    @endif

    <meta name="author" content="Links Postiong">
    <meta name='og:url' content="{{ url('/') }}">
    <meta name='identifier-URL' content="{{ url('/') }}">


    <link fatchpriority="high" rel="preload" href="{{ !empty($aboutUs->images) ? asset($aboutUs->images) : '' }}"
        as="image" />

    <title>
        {{
        $siteInfo->site_name .
        (!empty($siteTitle) ? ' | ' . $siteTitle : '') .
        ' | ' .
        (!empty($info->page_url) ? str_replace('-', ' ', $info->page_url) : '')
        }}
    </title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        #toster-container {
            width: 450px;
        }

        .toast-title {
            font-size: 1.25rem;
        }

        .toast-message {
            font-size: 0.75rem;
        }

        .toast-top-right {
            top: 78px !important;
        }

        .prose-list li::after {
            background-image: url("{{ asset('public/images/check-mark.png') }}");
        }
    </style>

    {{-- Swiper css --}}
    <link rel="stylesheet" href="{{ asset('public') }}/vendor/css/swiper-bundle.min.css">

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('css/frontend.css') }}">



    @stack('headerPartial')
</head>

<body class="overflow-x-hidden">


    @include('layouts.frontend-partial.header')
    <main>
        @yield('content')
    </main>

    @if (!empty($brand_section) && $brand_section == 'active')
    @include('layouts.frontend-partial.brand')
    @endif

    <div onclick="whatsappChatFn('{{$siteInfo->whatsapp}}')"
        class="size-14 z-[99999] cursor-pointer fixed right-10 bottom-10 rounded-full bg-[#008000] flex text-white items-center justify-center shadow-lg">
        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512" height="30" width="30"
            xmlns="http://www.w3.org/2000/svg">
            <path
                d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z">
            </path>
        </svg>
    </div>

    @include('layouts.frontend-partial.footer')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
        var newsletterForm = document.getElementById('newslatter');
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(newsletterForm);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "{{ route('newslatter') }}", true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    var msg = response.msg;
                    var type = response.type;
                    if (type === 'success') {
                        toastr.success(msg, 'Success');
                        newsletterForm.reset();
                    } else {
                        toastr.error(msg, 'Warning');
                        newsletterForm.reset();
                    }
                }
            };
            xhr.send(JSON.stringify(Object.fromEntries(formData)));
        });
    });

    toastr.options = {
        "closeButton": true,
        "debug": true,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    </script>

    <!-- Flowbite -->
    <script src="{{ asset('public') }}/vendor/js/flowbite.min.js"></script>
    {{-- Swiper JS --}}
    <script src="{{ asset('public') }}/vendor/js/swiper-bundle.min.js"></script>

    <script>
        // ===================================
        // Open What's app function
        // ===================================
        function whatsappChatFn(number) {
            event.preventDefault();
            window.open(`https://wa.me/${number}`);
        }

        const header = document.querySelector(".header");
        const logoText = document.querySelector(".header .logo-text");
        const logoImg = document.querySelector(".header .logo-img");
        const allNavlink = document.querySelectorAll('.header .nav-link');

        const updateStickyHeader = () => {
            const isSticky = window.scrollY > 0;
            header.classList.toggle("headerSticky", isSticky);

            if (isSticky) {
                header.style.border = '1px solid rgb(223, 223, 223)';
                logoText.style.color = "#00005c";
                logoImg.src = "{{ asset($siteInfo->logo) }}";
                allNavlink.forEach(link => {
                    link.style.color = "#00005c"; // Example sticky color
                });


            } else {
                header.style.border = '1px solid transparent';
                logoText.style.color = "#00005c";
                logoImg.src = "{{ asset($siteInfo->logo) }}"
                allNavlink.forEach(link => {
                    link.style.color = "#00005c"; // Default color
                });
            }
        }
        
        updateStickyHeader()

        window.addEventListener("scroll", updateStickyHeader);
    </script>

    {{-- Custom js --}}
    <script src="{{ asset('public') }}/js/app.js"></script>
    @stack('footerPartial')
</body>

</html>
