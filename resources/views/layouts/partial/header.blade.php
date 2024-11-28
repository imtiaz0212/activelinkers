<header class="border-b border-b-[#E8E8E8] h-[80px] sticky top-0 z-[99999] bg-white">
    <div class="px-[55px] flex h-full items-center justify-end">


        <div class="pl-[30px]">
            <div class="flex items-center gap-2 text-[#606060] cursor-pointer" id="profileDropdown" data-dropdown-toggle="dropdown">

                @php($userAvatar = (!empty($userData->avatar) ? $userData->avatar : '/images/user.png'))
                
                <img src="{{asset($userAvatar)}}" alt="User image" class="rounded-full h-[50px] w-[50px]" />

                <h3 class="text-xl">{{$userData->name}}</h3>

                <img src="{{asset('public')}}/images/icons/down-arrow.svg" alt="Down arrow" />

            </div>

            <div id="dropdown" class="z-10 hidden bg-white  rounded shadow-[0_0_14px_0px_rgba(0,0,0,0.05)] w-56">
                <ul class="py-2 text-lg text-gray-700 divide-y divide-gray-100" aria-labelledby="profileDropdown">
                    <li>
                        <a href="{{route('admin.dashboard')}}"
                            class="block px-4 py-2 flex items-center gap-2 hover:bg-gray-100">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
                                height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path fill="none" d="M0 0h24v24H0z"></path>
                                <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.settings')}}"
                            class="block px-4 py-2 flex items-center gap-2 hover:bg-gray-100">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                                height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M256 176a80 80 0 1080 80 80.24 80.24 0 00-80-80zm172.72 80a165.53 165.53 0 01-1.64 22.34l48.69 38.12a11.59 11.59 0 012.63 14.78l-46.06 79.52a11.64 11.64 0 01-14.14 4.93l-57.25-23a176.56 176.56 0 01-38.82 22.67l-8.56 60.78a11.93 11.93 0 01-11.51 9.86h-92.12a12 12 0 01-11.51-9.53l-8.56-60.78A169.3 169.3 0 01151.05 393L93.8 416a11.64 11.64 0 01-14.14-4.92L33.6 331.57a11.59 11.59 0 012.63-14.78l48.69-38.12A174.58 174.58 0 0183.28 256a165.53 165.53 0 011.64-22.34l-48.69-38.12a11.59 11.59 0 01-2.63-14.78l46.06-79.52a11.64 11.64 0 0114.14-4.93l57.25 23a176.56 176.56 0 0138.82-22.67l8.56-60.78A11.93 11.93 0 01209.94 26h92.12a12 12 0 0111.51 9.53l8.56 60.78A169.3 169.3 0 01361 119l57.2-23a11.64 11.64 0 0114.14 4.92l46.06 79.52a11.59 11.59 0 01-2.63 14.78l-48.69 38.12a174.58 174.58 0 011.64 22.66z">
                                </path>
                            </svg>
                            Settings
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.user.edit', '1')}}"
                            class="block px-4 py-2 flex items-center gap-2 hover:bg-gray-100">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512"
                                height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M224 256A128 128 0 1 1 224 0a128 128 0 1 1 0 256zM209.1 359.2l-18.6-31c-6.4-10.7 1.3-24.2 13.7-24.2H224h19.7c12.4 0 20.1 13.6 13.7 24.2l-18.6 31 33.4 123.9 36-146.9c2-8.1 9.8-13.4 17.9-11.3c70.1 17.6 121.9 81 121.9 156.4c0 17-13.8 30.7-30.7 30.7H285.5c-2.1 0-4-.4-5.8-1.1l.3 1.1H168l.3-1.1c-1.8 .7-3.8 1.1-5.8 1.1H30.7C13.8 512 0 498.2 0 481.3c0-75.5 51.9-138.9 121.9-156.4c8.1-2 15.9 3.3 17.9 11.3l36 146.9 33.4-123.9z">
                                </path>
                            </svg>
                            Profile
                        </a>
                    </li>
                    <li>
                        <a href="{{route('logout')}}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="block px-4 py-2 flex items-center gap-2 hover:bg-gray-100">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                                height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32V256c0 17.7 14.3 32 32 32s32-14.3 32-32V32zM143.5 120.6c13.6-11.3 15.4-31.5 4.1-45.1s-31.5-15.4-45.1-4.1C49.7 115.4 16 181.8 16 256c0 132.5 107.5 240 240 240s240-107.5 240-240c0-74.2-33.8-140.6-86.6-184.6c-13.6-11.3-33.8-9.4-45.1 4.1s-9.4 33.8 4.1 45.1c38.9 32.3 63.5 81 63.5 135.4c0 97.2-78.8 176-176 176s-176-78.8-176-176c0-54.4 24.7-103.1 63.5-135.4z">
                                </path>
                            </svg>
                            Sign out
                        </a>
                    </li>
                </ul>
            </div>
        </div>


    </div>
</header>