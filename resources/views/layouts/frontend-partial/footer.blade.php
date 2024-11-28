@php
    $companyNav = [
    [
    'label' => 'About Us',
    'path' => url('about-us'),
    ],
    [
    'label' => 'Websites',
    'path' => url('websites'),
    ],
    [
    'label' => 'Blog',
    'path' => url('blog'),
    ],
    ];

    $socialData = [
    [
    'name' => 'Facebook',
    'image' => '<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 320 512" height="1em"
        width="1em" xmlns="http://www.w3.org/2000/svg">
        <path
            d="M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z">
        </path>
    </svg>',
    'url' => $siteInfo->facebook,
    'title' => 'Facebook',
    ],
    [
    'name' => 'Google',
    'image' => '<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 488 512" height="1em"
        width="1em" xmlns="http://www.w3.org/2000/svg">
        <path
            d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z">
        </path>
    </svg>',
    'url' => $siteInfo->google_plus,
    'title' => 'Google',
    ],
    [
    'name' => 'Linkedin',
    'image' => '<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512" height="1em"
        width="1em" xmlns="http://www.w3.org/2000/svg">
        <path
            d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z">
        </path>
    </svg>',
    'url' => $siteInfo->linkedin,
    'title' => 'LinkedIn',
    ],
    [
    'name' => 'Twitter',
    'image' => '<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em"
        width="1em" xmlns="http://www.w3.org/2000/svg">
        <path
            d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z">
        </path>
    </svg>',
    'url' => $siteInfo->twitter,
    'title' => 'Twitter',
    ],
    [
    'name' => 'Youtube',
    'image' => '<svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em"
        width="1em" xmlns="http://www.w3.org/2000/svg">
        <path
            d="M508.6 148.8c0-45-33.1-81.2-74-81.2C379.2 65 322.7 64 265 64h-18c-57.6 0-114.2 1-169.6 3.6C36.6 67.6 3.5 104 3.5 149 1 184.6-.1 220.2 0 255.8c-.1 35.6 1 71.2 3.4 106.9 0 45 33.1 81.5 73.9 81.5 58.2 2.7 117.9 3.9 178.6 3.8 60.8.2 120.3-1 178.6-3.8 40.9 0 74-36.5 74-81.5 2.4-35.7 3.5-71.3 3.4-107 .2-35.6-.9-71.2-3.3-106.9zM207 353.9V157.4l145 98.2-145 98.3z">
        </path>
    </svg>',
    'url' => $siteInfo->youtube,
    'title' => 'Youtube',
    ],
    ];

@endphp


<footer class="bg-secondary footer mt-14">
    <div class="container relative -translate-y-14 ">
        <div
            class="bg-white grid gap-8 lg:gap-0 lg:grid-cols-3 rounded-md md:rounded-xl lg:rounded-2xl p-6 md:p-8 lg:p-10 shadow-lg border">
            <div class="lg:pr-6">
                <a href="{{ route('home') }}" class="text-darkblue">
                    @if (!empty($siteInfo->logo))
                        <img class="max-w-[180px] md:max-w-[270px]" src="{{ asset($siteInfo->logo) }}"
                             alt="site logo">
                    @else
                        <div class="font-bold text-2xl">
                            {{ $siteInfo->site_name }}
                        </div>
                    @endif
                </a>

                <p class="text-base md:text-lg py-3 md:mt-4 md:mb-8">{{ $siteInfo->about_us }}</p>

                <div class="grid sm:grid-cols-2 gap-y-4 text-base font-inter">
                    <div class="grid gap-2">
                        <div class="flex items-center gap-2">
                            <span class="font-medium">Review On</span>
                            <div class="text-red-600 flex items-center text-lg">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.2"
                                     baseProfile="tiny" viewBox="0 0 24 24" height="1em" width="1em"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9.362 9.158l-5.268.584c-.19.023-.358.15-.421.343s0 .394.14.521c1.566 1.429 3.919 3.569 3.919 3.569-.002 0-.646 3.113-1.074 5.19-.036.188.032.387.196.506.163.119.373.121.538.028 1.844-1.048 4.606-2.624 4.606-2.624l4.604 2.625c.168.092.378.09.541-.029.164-.119.232-.318.195-.505l-1.071-5.191 3.919-3.566c.14-.131.202-.332.14-.524s-.23-.319-.42-.341c-2.108-.236-5.269-.586-5.269-.586l-2.183-4.83c-.082-.173-.254-.294-.456-.294s-.375.122-.453.294l-2.183 4.83z">
                                    </path>
                                </svg>
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.2"
                                     baseProfile="tiny" viewBox="0 0 24 24" height="1em" width="1em"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9.362 9.158l-5.268.584c-.19.023-.358.15-.421.343s0 .394.14.521c1.566 1.429 3.919 3.569 3.919 3.569-.002 0-.646 3.113-1.074 5.19-.036.188.032.387.196.506.163.119.373.121.538.028 1.844-1.048 4.606-2.624 4.606-2.624l4.604 2.625c.168.092.378.09.541-.029.164-.119.232-.318.195-.505l-1.071-5.191 3.919-3.566c.14-.131.202-.332.14-.524s-.23-.319-.42-.341c-2.108-.236-5.269-.586-5.269-.586l-2.183-4.83c-.082-.173-.254-.294-.456-.294s-.375.122-.453.294l-2.183 4.83z">
                                    </path>
                                </svg>
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.2"
                                     baseProfile="tiny" viewBox="0 0 24 24" height="1em" width="1em"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9.362 9.158l-5.268.584c-.19.023-.358.15-.421.343s0 .394.14.521c1.566 1.429 3.919 3.569 3.919 3.569-.002 0-.646 3.113-1.074 5.19-.036.188.032.387.196.506.163.119.373.121.538.028 1.844-1.048 4.606-2.624 4.606-2.624l4.604 2.625c.168.092.378.09.541-.029.164-.119.232-.318.195-.505l-1.071-5.191 3.919-3.566c.14-.131.202-.332.14-.524s-.23-.319-.42-.341c-2.108-.236-5.269-.586-5.269-.586l-2.183-4.83c-.082-.173-.254-.294-.456-.294s-.375.122-.453.294l-2.183 4.83z">
                                    </path>
                                </svg>
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.2"
                                     baseProfile="tiny" viewBox="0 0 24 24" height="1em" width="1em"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9.362 9.158l-5.268.584c-.19.023-.358.15-.421.343s0 .394.14.521c1.566 1.429 3.919 3.569 3.919 3.569-.002 0-.646 3.113-1.074 5.19-.036.188.032.387.196.506.163.119.373.121.538.028 1.844-1.048 4.606-2.624 4.606-2.624l4.604 2.625c.168.092.378.09.541-.029.164-.119.232-.318.195-.505l-1.071-5.191 3.919-3.566c.14-.131.202-.332.14-.524s-.23-.319-.42-.341c-2.108-.236-5.269-.586-5.269-.586l-2.183-4.83c-.082-.173-.254-.294-.456-.294s-.375.122-.453.294l-2.183 4.83z">
                                    </path>
                                </svg>
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.2"
                                     baseProfile="tiny" viewBox="0 0 24 24" height="1em" width="1em"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9.362 9.158l-5.268.584c-.19.023-.358.15-.421.343s0 .394.14.521c1.566 1.429 3.919 3.569 3.919 3.569-.002 0-.646 3.113-1.074 5.19-.036.188.032.387.196.506.163.119.373.121.538.028 1.844-1.048 4.606-2.624 4.606-2.624l4.604 2.625c.168.092.378.09.541-.029.164-.119.232-.318.195-.505l-1.071-5.191 3.919-3.566c.14-.131.202-.332.14-.524s-.23-.319-.42-.341c-2.108-.236-5.269-.586-5.269-.586l-2.183-4.83c-.082-.173-.254-.294-.456-.294s-.375.122-.453.294l-2.183 4.83z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <img src="{{asset('public')}}/images/clutch-logo.svg" class="!h-5 md:!h-6"
                                 alt="Clutch logo"/>
                            <span class="font-normal ">(50 reviews)</span>
                        </div>
                    </div>
                    <div class="grid gap-2">
                        <div class="flex items-center gap-2">
                            <span class="font-medium">Review On</span>
                            <div class="text-yellow-400 flex items-center text-lg">
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.2"
                                     baseProfile="tiny" viewBox="0 0 24 24" height="1em" width="1em"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9.362 9.158l-5.268.584c-.19.023-.358.15-.421.343s0 .394.14.521c1.566 1.429 3.919 3.569 3.919 3.569-.002 0-.646 3.113-1.074 5.19-.036.188.032.387.196.506.163.119.373.121.538.028 1.844-1.048 4.606-2.624 4.606-2.624l4.604 2.625c.168.092.378.09.541-.029.164-.119.232-.318.195-.505l-1.071-5.191 3.919-3.566c.14-.131.202-.332.14-.524s-.23-.319-.42-.341c-2.108-.236-5.269-.586-5.269-.586l-2.183-4.83c-.082-.173-.254-.294-.456-.294s-.375.122-.453.294l-2.183 4.83z">
                                    </path>
                                </svg>
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.2"
                                     baseProfile="tiny" viewBox="0 0 24 24" height="1em" width="1em"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9.362 9.158l-5.268.584c-.19.023-.358.15-.421.343s0 .394.14.521c1.566 1.429 3.919 3.569 3.919 3.569-.002 0-.646 3.113-1.074 5.19-.036.188.032.387.196.506.163.119.373.121.538.028 1.844-1.048 4.606-2.624 4.606-2.624l4.604 2.625c.168.092.378.09.541-.029.164-.119.232-.318.195-.505l-1.071-5.191 3.919-3.566c.14-.131.202-.332.14-.524s-.23-.319-.42-.341c-2.108-.236-5.269-.586-5.269-.586l-2.183-4.83c-.082-.173-.254-.294-.456-.294s-.375.122-.453.294l-2.183 4.83z">
                                    </path>
                                </svg>
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.2"
                                     baseProfile="tiny" viewBox="0 0 24 24" height="1em" width="1em"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9.362 9.158l-5.268.584c-.19.023-.358.15-.421.343s0 .394.14.521c1.566 1.429 3.919 3.569 3.919 3.569-.002 0-.646 3.113-1.074 5.19-.036.188.032.387.196.506.163.119.373.121.538.028 1.844-1.048 4.606-2.624 4.606-2.624l4.604 2.625c.168.092.378.09.541-.029.164-.119.232-.318.195-.505l-1.071-5.191 3.919-3.566c.14-.131.202-.332.14-.524s-.23-.319-.42-.341c-2.108-.236-5.269-.586-5.269-.586l-2.183-4.83c-.082-.173-.254-.294-.456-.294s-.375.122-.453.294l-2.183 4.83z">
                                    </path>
                                </svg>
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.2"
                                     baseProfile="tiny" viewBox="0 0 24 24" height="1em" width="1em"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9.362 9.158l-5.268.584c-.19.023-.358.15-.421.343s0 .394.14.521c1.566 1.429 3.919 3.569 3.919 3.569-.002 0-.646 3.113-1.074 5.19-.036.188.032.387.196.506.163.119.373.121.538.028 1.844-1.048 4.606-2.624 4.606-2.624l4.604 2.625c.168.092.378.09.541-.029.164-.119.232-.318.195-.505l-1.071-5.191 3.919-3.566c.14-.131.202-.332.14-.524s-.23-.319-.42-.341c-2.108-.236-5.269-.586-5.269-.586l-2.183-4.83c-.082-.173-.254-.294-.456-.294s-.375.122-.453.294l-2.183 4.83z">
                                    </path>
                                </svg>
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.2"
                                     baseProfile="tiny" viewBox="0 0 24 24" height="1em" width="1em"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9.362 9.158l-5.268.584c-.19.023-.358.15-.421.343s0 .394.14.521c1.566 1.429 3.919 3.569 3.919 3.569-.002 0-.646 3.113-1.074 5.19-.036.188.032.387.196.506.163.119.373.121.538.028 1.844-1.048 4.606-2.624 4.606-2.624l4.604 2.625c.168.092.378.09.541-.029.164-.119.232-.318.195-.505l-1.071-5.191 3.919-3.566c.14-.131.202-.332.14-.524s-.23-.319-.42-.341c-2.108-.236-5.269-.586-5.269-.586l-2.183-4.83c-.082-.173-.254-.294-.456-.294s-.375.122-.453.294l-2.183 4.83z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <img src="{{asset('public')}}/images/google-logo.svg" class="!h-5 md:!h-6"
                                 alt="google logo"/>
                            <span class="font-normal ">(50 reviews)</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:border-x flex items-center flex-col gap-2">
                <img src="{{asset('public')}}/images/testimonial-2.png" class="rounded-full" alt="Profile">
                <p>Talk to our growth expert</p>
                <a class="font-inter text-2xl font-bold text-black" href="tel:{{ $siteInfo->mobile }}">{{
                    $siteInfo->mobile }}</a>

                <p class="underline">Talk To Social Media</p>

                <div class="flex items-center gap-5 mt-4">
                    @foreach ($socialData as $row)
                        @if (!empty($row['url']))
                            <a href="{{ $row['url'] }}" target="_blank" title="{{ $row['title'] }}"
                               class="hover:text-primary">
                                {!! $row['image'] !!}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <div id="subscribers" class="flex flex-col gap-3 md:gap-7 lg:pl-6">
                <h2 class="text-lg sm:text-xl md:text-2xl font-semibold text-darkblue">Subscribe to Our Newsletter</h2>

                <form id="newslatter"
                      class="flex justify-between md:w-[408px] bg-white rounded-lg overflow-hidden border">
                    @csrf
                    <input type="email" name="email"
                           class="email text-[#2A2A2A] outline-none border-none text-lg placeholder:text-[#2A2A2A] placeholder:text-opacity-50 rounded w-[90%] focus:ring-0"
                           placeholder="Your Email Address"/>

                    <button aria-label="Send mail address" type="submit"
                            class="flexCenter md:text-lg  bg-darkblue text-white group hover:bg-primary rounded-lg p-3 m-1">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                 fill="none">
                                <path
                                    d="M12.9027 7.12172L8.53023 11.6042C8.20939 11.9342 7.70523 12.0076 7.3019 11.7876L2.02189 8.90005C1.24272 8.47839 1.33441 7.34172 2.15941 7.03922L17.1102 1.58505C17.9261 1.29172 18.7236 2.08005 18.4302 2.89588L13.1044 17.8009C12.8111 18.6167 11.7111 18.7267 11.2619 17.9934L9.27273 14.7392"
                                    class="fill-darkblue group-hover:fill-primary"/>
                                <path
                                    d="M12.9027 7.12172L8.53023 11.6042C8.20939 11.9342 7.70523 12.0076 7.3019 11.7876L2.02189 8.90005C1.24272 8.47839 1.33441 7.34172 2.15941 7.03922L17.1102 1.58505C17.9261 1.29172 18.7236 2.08005 18.4302 2.89588L13.1044 17.8009C12.8111 18.6167 11.7111 18.7267 11.2619 17.9934L9.27273 14.7392"
                                    stroke="white" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </button>
                </form>


            </div>
        </div>
    </div>

    <div class="sectionGap pt-0">
        <div class="container">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 items-start gap-8 md:gap-0">
                <div class="grid gap-6 items-start">
                    <h4 class="footerNavTitle">
                        Services
                    </h4>
                    <ul class="space-y-2">
                        @if(!empty($headerServiceList))
                            @php($services = $headerServiceList->take(3))
                            @foreach ($services as $service)
                                <li>
                                    <a href="{{ url('service', $service->page_url) }}" class="footerNavLink">
                                        <span>{{ $service->serviceCategory->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <div class="grid gap-6 items-start">
                    <h4 class="footerNavTitle">
                        Services
                    </h4>
                    <ul class="space-y-2">
                        @if(!empty($headerServiceList))
                            @php($services = $headerServiceList->skip(3))
                            @foreach ($services as $service)
                                <li>
                                    <a href="{{ url('service', $service->page_url) }}" class="footerNavLink">
                                        <span>{{ $service->serviceCategory->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                        <li>
                            <a href="{{ url('contact') }}" class="footerNavLink">
                                <span>Contact</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="grid gap-6 items-start">
                    <h4 class="footerNavTitle">
                        Company
                    </h4>
                    <ul class="space-y-2">
                        @foreach ($companyNav as $companyRow)
                            <li>
                                <a href="{{ $companyRow['path'] }}" class="footerNavLink">
                                    <span>{{ $companyRow['label'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="grid gap-6 items-start">
                    <h4 class="footerNavTitle">
                        Terms & Conditions
                    </h4>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ url('privacy-policy') }}" class="footerNavLink">Privacy Policy</a>
                        </li>
                        <li>
                            <a href="{{ url('terms-of-service') }}" class="footerNavLink">Terms & Conditions</a>
                        </li>
                        <li>
                            <a href="{{ url('refund-policy') }}" class="footerNavLink">Refund Policy</a>
                        </li>
                        <li>
                            <a href="{{ url('dmca') }}" class="footerNavLink">DMCA</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="py-8 border-t border-t-white/20 rounded-t-3xl">
        <div class="container">
            <div class="flex items-center justify-between flex-wrap gap-y-4">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                         class="text-2xl md:text-3xl lg:text-4xl" viewBox="0 0 33 33">
                        <g>
                            <path
                                d="M26.0803 20.4417C25.4047 19.7383 24.5898 19.3622 23.7262 19.3622C22.8695 19.3622 22.0477 19.7313 21.3442 20.4348L19.1433 22.6287C18.9622 22.5312 18.7811 22.4407 18.607 22.3501C18.3563 22.2248 18.1195 22.1063 17.9175 21.981C15.8559 20.6716 13.9823 18.9652 12.1854 16.7573C11.3148 15.6569 10.7297 14.7305 10.3049 13.7903C10.876 13.2679 11.4053 12.7247 11.9207 12.2023C12.1157 12.0073 12.3108 11.8053 12.5058 11.6103C13.9684 10.1477 13.9684 8.25321 12.5058 6.79058L10.6044 4.88917C10.3885 4.67326 10.1656 4.45038 9.95664 4.22751C9.53874 3.79569 9.09996 3.34993 8.64724 2.93204C7.97165 2.26341 7.16372 1.9082 6.31401 1.9082C5.46429 1.9082 4.64244 2.26341 3.94595 2.93204C3.93899 2.939 3.93899 2.939 3.93202 2.94597L1.56396 5.33492C0.672459 6.22643 0.164023 7.31295 0.0525852 8.57359C-0.114572 10.6073 0.484407 12.5018 0.944089 13.7415C2.0724 16.7852 3.7579 19.606 6.27222 22.6287C9.32283 26.2713 12.9933 29.1478 17.1862 31.1746C18.7881 31.9338 20.9263 32.8323 23.3153 32.9855C23.4615 32.9924 23.6148 32.9994 23.7541 32.9994C25.3629 32.9994 26.7141 32.4213 27.7728 31.2721C27.7798 31.2582 27.7937 31.2512 27.8006 31.2373C28.1628 30.7985 28.5807 30.4015 29.0195 29.9767C29.319 29.6911 29.6254 29.3916 29.9249 29.0782C30.6145 28.3608 30.9766 27.525 30.9766 26.6683C30.9766 25.8047 30.6075 24.9759 29.904 24.2794L26.0803 20.4417ZM28.5737 27.7758C28.5668 27.7758 28.5668 27.7827 28.5737 27.7758C28.3021 28.0683 28.0235 28.3329 27.724 28.6255C27.2713 29.0573 26.8116 29.51 26.3798 30.0184C25.6764 30.7707 24.8475 31.1259 23.761 31.1259C23.6565 31.1259 23.5451 31.1259 23.4406 31.1189C21.3721 30.9866 19.4498 30.1786 18.008 29.4891C14.0659 27.5807 10.6044 24.8714 7.72788 21.4377C5.35286 18.5752 3.76486 15.9285 2.71317 13.0868C2.06543 11.3526 1.82863 10.0014 1.9331 8.72682C2.00275 7.91193 2.31617 7.23633 2.89425 6.65825L5.26928 4.28323C5.61056 3.96284 5.97273 3.78872 6.32794 3.78872C6.76673 3.78872 7.12193 4.05339 7.34481 4.27626C7.35177 4.28323 7.35874 4.29019 7.3657 4.29716C7.79056 4.69415 8.19452 5.10508 8.61938 5.54387C8.83529 5.76675 9.05817 5.98962 9.28104 6.21946L11.1825 8.12087C11.9207 8.85915 11.9207 9.54171 11.1825 10.28C10.9805 10.482 10.7855 10.6839 10.5835 10.879C9.99843 11.4779 9.44124 12.0351 8.83529 12.5784C8.82136 12.5923 8.80743 12.5993 8.80047 12.6132C8.20149 13.2122 8.31293 13.7972 8.43829 14.1942C8.44526 14.2151 8.45222 14.236 8.45919 14.2569C8.9537 15.4549 9.65018 16.5832 10.7088 17.9274L10.7158 17.9344C12.6381 20.3024 14.6649 22.1481 16.9006 23.562C17.1862 23.7431 17.4787 23.8894 17.7573 24.0287C18.008 24.154 18.2448 24.2724 18.4468 24.3978C18.4747 24.4117 18.5025 24.4326 18.5304 24.4465C18.7672 24.5649 18.9901 24.6207 19.2199 24.6207C19.798 24.6207 20.1602 24.2585 20.2786 24.1401L22.6606 21.7581C22.8974 21.5213 23.2735 21.2357 23.7123 21.2357C24.1441 21.2357 24.4993 21.5074 24.7152 21.7442C24.7222 21.7511 24.7222 21.7511 24.7291 21.7581L28.5668 25.5958C29.2842 26.3062 29.2842 27.0375 28.5737 27.7758Z">
                            </path>
                            <path
                                d="M17.834 7.8506C19.6588 8.15705 21.3164 9.0207 22.6398 10.344C23.9631 11.6673 24.8198 13.325 25.1332 15.1498C25.2098 15.6095 25.6068 15.9299 26.0595 15.9299C26.1152 15.9299 26.164 15.9229 26.2197 15.9159C26.7351 15.8323 27.0764 15.3448 26.9928 14.8294C26.6167 12.6215 25.572 10.6087 23.977 9.01373C22.3821 7.41877 20.3692 6.37404 18.1614 5.99794C17.646 5.91436 17.1654 6.25564 17.0748 6.76408C16.9843 7.27251 17.3186 7.76702 17.834 7.8506Z">
                            </path>
                            <path
                                d="M32.9617 14.557C32.3418 10.9213 30.6285 7.61301 27.9957 4.98029C25.363 2.34757 22.0547 0.634209 18.419 0.0143347C17.9106 -0.0762086 17.43 0.272035 17.3395 0.780471C17.2559 1.29587 17.5972 1.77645 18.1126 1.86699C21.3582 2.41722 24.3183 3.95645 26.6724 6.30362C29.0265 8.65774 30.5588 11.6178 31.109 14.8634C31.1857 15.3231 31.5827 15.6435 32.0354 15.6435C32.0911 15.6435 32.1398 15.6365 32.1956 15.6296C32.704 15.553 33.0522 15.0654 32.9617 14.557Z">
                            </path>
                        </g>
                    </svg>
                    <div class="grid">
                        <span class="text-sm text-black">Call Any Time</span>
                        <a href="tel:{{ $siteInfo->mobile }}"
                           class="text-white text-sm sm:text-base md:text-lg font-inter">{{ $siteInfo->mobile
                            }}</a>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                         class="text-2xl md:text-3xl lg:text-4xl" viewBox="0 0 33 33">
                        <g>
                            <path
                                d="M16.4999 0C9.77802 0 4.30957 5.46845 4.30957 12.1904C4.30957 14.4033 5.30201 16.7832 5.3436 16.8836C5.66413 17.6445 6.2966 18.8262 6.75266 19.5189L15.1109 32.1832C15.453 32.7024 15.9592 33 16.4999 33C17.0406 33 17.5469 32.7024 17.8889 32.184L26.2479 19.5189C26.7047 18.8262 27.3364 17.6445 27.657 16.8836C27.6986 16.784 28.6903 14.404 28.6903 12.1904C28.6903 5.46845 23.2218 0 16.4999 0ZM26.3347 16.3272C26.0486 17.0091 25.4598 18.1084 25.0504 18.7294L16.6914 31.3945C16.5265 31.6447 16.4741 31.6447 16.3092 31.3945L7.95018 18.7294C7.54073 18.1084 6.95201 17.0084 6.66589 16.3265C6.6537 16.2971 5.74373 14.1064 5.74373 12.1904C5.74373 6.25939 10.569 1.43416 16.4999 1.43416C22.4309 1.43416 27.2561 6.25939 27.2561 12.1904C27.2561 14.1093 26.344 16.3057 26.3347 16.3272Z">
                            </path>
                            <path
                                d="M16.5001 5.7373C12.9412 5.7373 10.0464 8.63287 10.0464 12.191C10.0464 15.7492 12.9412 18.6447 16.5001 18.6447C20.059 18.6447 22.9538 15.7492 22.9538 12.191C22.9538 8.63287 20.059 5.7373 16.5001 5.7373ZM16.5001 17.2106C13.7329 17.2106 11.4805 14.9589 11.4805 12.191C11.4805 9.42309 13.7329 7.17146 16.5001 7.17146C19.2673 7.17146 21.5197 9.42309 21.5197 12.191C21.5197 14.9589 19.2673 17.2106 16.5001 17.2106Z">
                            </path>
                        </g>
                    </svg>
                    <div class="grid">
                        <span class="text-sm text-black">Address</span>
                        <span class="text-white text-sm sm:text-base md:text-lg">{{ $siteInfo->location }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                         class="text-2xl md:text-3xl lg:text-4xl" viewBox="0 0 33 33">
                        <g>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M32.9891 1.18398C33.0171 0.995671 32.9925 0.803292 32.918 0.628097C32.8435 0.452902 32.722 0.301711 32.567 0.191227C32.4121 0.0808885 32.2296 0.0155543 32.0399 0.00245033C31.8501 -0.0106536 31.6604 0.0289832 31.4918 0.116977L0.554265 16.2732C0.376261 16.3673 0.229594 16.5113 0.132265 16.6876C0.0349358 16.8638 -0.00882138 17.0646 0.00636356 17.2654C0.0215485 17.4662 0.0950149 17.6581 0.217747 17.8177C0.340478 17.9773 0.507135 18.0976 0.697265 18.1639L9.29789 21.1036L27.6143 5.44235L13.4408 22.5185L27.8549 27.4451C27.9979 27.4932 28.1497 27.5094 28.2997 27.4926C28.4496 27.4758 28.5941 27.4265 28.723 27.348C28.8519 27.2696 28.962 27.1639 29.0458 27.0384C29.1296 26.9129 29.1849 26.7706 29.2079 26.6215L32.9891 1.18398ZM28.2196 26.469C28.2195 26.4693 28.2196 26.4688 28.2196 26.469L32 1.03696C32.0009 1.03102 32.0001 1.02494 31.9978 1.0194M28.2196 26.469C28.2187 26.4738 28.2167 26.4792 28.214 26.4833C28.2112 26.4876 28.2074 26.4912 28.203 26.4939C28.1986 26.4965 28.1937 26.4982 28.1885 26.4988C28.1837 26.4993 28.1788 26.4989 28.1741 26.4974C28.1739 26.4973 28.1744 26.4975 28.1741 26.4974L15.1365 22.0413L28.3837 6.08103L26.9644 4.68231L9.08156 19.9729L1.02623 17.2195C1.02595 17.2194 1.02651 17.2196 1.02623 17.2195C1.02033 17.2173 1.01432 17.2131 1.01047 17.2081C1.00643 17.2029 1.00401 17.1966 1.00352 17.19C1.00302 17.1834 1.00445 17.1768 1.00766 17.171C1.01073 17.1654 1.01531 17.1608 1.02086 17.1577C1.02064 17.1578 1.02109 17.1576 1.02086 17.1577L31.9544 1.00355C31.9543 1.00357 31.9544 1.00352 31.9544 1.00355C31.9594 1.00093 31.9653 0.999681 31.971 1.00007M13.0314 30.5897C13.0316 30.5963 13.0337 30.6027 13.0376 30.6081C13.0417 30.6136 13.0473 30.6177 13.0538 30.6199C13.0603 30.622 13.0674 30.622 13.0739 30.6199C13.0802 30.6179 13.0857 30.6141 13.0898 30.6089C13.0896 30.6091 13.0899 30.6087 13.0898 30.6089L16.011 26.6335L13.0314 25.6152V30.5897ZM12.0314 24.2166V30.5939C12.0324 30.8106 12.1017 31.0215 12.2292 31.1967C12.3568 31.3719 12.5363 31.5025 12.7422 31.5701C12.9482 31.6376 13.1702 31.6386 13.3767 31.573C13.5833 31.5073 13.764 31.3784 13.8931 31.2044L17.6235 26.1279L12.0314 24.2166Z">
                            </path>
                        </g>
                    </svg>
                    <div class="grid">
                        <span class="text-sm text-black">Say Hello</span>
                        <a href="mailto:{{ $siteInfo->email }}" class="text-white text-sm sm:text-base md:text-lg">{{
                            $siteInfo->email }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white py-8 rounded-t-3xl">
        <div class="container">
            <div
                class="flex items-center text-sm sm:text-base lg:text-lg gap-y-2.5 font-normal flex-col lg:flex-row lg:justify-between">
                <p class="text-center lg:text-left">
                    {{$siteInfo->copyright ? $siteInfo->copyright : 'All right reserved by' . $siteInfo->site_name}}
                </p>
                <div class="flex items-center gap-2.5">
                    <h4>We accepts</h4>
                    <img src="{{ asset('public/images/we-accpect.png') }}" draggable="false" class="h-8 sm:h-10 w-auto"
                         alt="paypal.png">
                </div>
            </div>
        </div>
    </div>
</footer>
