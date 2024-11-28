@php($menu = !empty($menu) ? $menu : '')
<header
    class="header fixed top-0  z-[99999] w-full  py-4 duration-500 [&.headerSticky]:bg-[#FEFFF9] [&.headerSticky]:py-2 [&:has(#nav-toggle[aria-expanded='true'])]:!bg-[#0B121F]">
    <div class="container">
        <nav>
            <div class="flex flex-wrap items-center justify-between">
                <div class="logo whitespace-nowrap text-[30px] font-bolds">
                    <a href="{{ route('home') }}" class="logo-text text-white">
                        @if (!empty($siteInfo->logo))
                            <img class="max-w-[180px] md:max-w-[270px] logo-img" src="{{ asset($siteInfo->logo) }}"
                                 alt="site logo">
                        @else
                            {{ $siteInfo->site_name }}
                        @endif
                    </a>
                </div>
                <div class="flex md:order-2 space-x-3 md:space-x-0 ">
                    <a href="{{ url('contact') }}" data-text="Contact Us" class="primary-btn">
                        Contact Us
                    </a>

                    <button data-collapse-toggle="navbar-sticky" type="button"
                            class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden bg-gray-100 hover:text-secondary"
                            aria-controls="navbar-sticky" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 17 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M1 1h15M1 7h15M1 13h15"/>
                        </svg>
                    </button>
                </div>
                <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                    <ul
                        class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 md:flex-row md:mt-0 md:border-0 md:bg-transparent">
                        <li>
                            <a class="nav-link {{ $menu == 'home' ? '!text-primary ' : '' }}"
                               href="{{ route('home') }}">
                                Home
                            </a>
                        </li>
                        <li>
                            <a class="nav-link {{ $menu == 'about-us' ? '!text-primary ' : '' }}"
                               href="{{ url('about-us') }}">
                                About Us
                            </a>
                        </li>

                        <li>
                            <button id="serviceDropdownLink" data-dropdown-toggle="serviceDropdown"
                                    data-dropdown-trigger="hover"
                                    class="nav-link inline-flex !py-0 items-center gap-1">Services
                                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>
                            <div id="serviceDropdown"
                                 class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 ">
                                <ul class="py-2 text-sm text-gray-700 " aria-labelledby="dropdownLargeButton">
                                    @if(!empty($headerServiceList))
                                        @foreach ($headerServiceList as $service)
                                            <li>
                                                <a href="{{ url('service', $service->page_url) }}"
                                                   class="block px-4 py-2 hover:bg-gray-100 {{ $menu == $service->page_url ? '!text-primary ' : '' }}">
                                                    {{ $service->serviceCategory->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="{{ url('blog') }}" class="nav-link {{ $menu == 'blog' ? '!text-primary ' : '' }}">
                                Blog
                            </a>
                        </li>

                        <li>
                            <a class="nav-link {{ $menu == 'siteList' ? '!text-primary ' : '' }}"
                               href="{{ url('websites') }}">
                                Websites
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
