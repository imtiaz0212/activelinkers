<section class="bg-[#f3eded]  relative z-[1]">
    <div class="flex flex-col items-center pt-20 md:pt-[130px] pb-16 lg:pb-20">
        <h2 class="sectionTitle text-darkblue">
            {{ $siteTitle }}</h2>
        <ul class="flexItemCenter gap-4 text-[#627193] leading-[188%]">
            <li>
                <a href="{{ route('home') }}">Home</a>
            </li>
            @if (!empty($breadcrumb))
            @foreach ($breadcrumb as $route => $title)
            <li>
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                    <g clip-path="url(#clip0_183_76235)">
                        <path
                            d="M7.7779 4.6098L3.32777 0.159755C3.22485 0.0567475 3.08745 0 2.94095 0C2.79445 0 2.65705 0.0567475 2.55412 0.159755L2.2264 0.487394C2.01315 0.700889 2.01315 1.04788 2.2264 1.26105L5.96328 4.99793L2.22225 8.73895C2.11933 8.84196 2.0625 8.97928 2.0625 9.1257C2.0625 9.27228 2.11933 9.4096 2.22225 9.51269L2.54998 9.84025C2.65298 9.94325 2.7903 10 2.9368 10C3.0833 10 3.2207 9.94325 3.32363 9.84025L7.7779 5.38614C7.88107 5.2828 7.93774 5.14484 7.93741 4.99817C7.93774 4.85094 7.88107 4.71305 7.7779 4.6098Z"
                            fill="#627193" />
                    </g>
                    <defs>
                        <clipPath id="clip0_183_76235">
                            <rect width="10" height="10" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
            </li>
            <li>
                <a href="{{ url($route) }}" class="capitalize">{{ $title }}</a>
            </li>
            @endforeach
            @endif
        </ul>
    </div>

    <div class="flex animate-scrolldown justify-content-center absolute bottom-0 translate-y-1/2 left-1/2 -translate-x-1/2 z-[2]"
        id="scroll-btn">
        <button type="button"
            class="w-10 h-20 rounded-full text-2xl border duration-300 border-gray-200 text-secondary bg-white hover:bg-secondary hover:text-white flex items-center justify-center">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="1em" width="1em"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1">
                </path>
            </svg>
        </button>
    </div>

    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div
            class="absolute z-[-2] inset-0 bg-[linear-gradient(to_right,#DFDFDF,transparent_1px),linear-gradient(to_bottom,#DFDFDF,transparent_1px)] bg-[size:20px_20px] sm:bg-[size:30px_30px] md:bg-[size:40px_40px] lg:bg-[size:50px_50px] bg-[position:-1px_-1px]">
        </div>
        <div
            class="absolute z-[-1] left-0 bottom-0 translate-y-1/2 -translate-x-1/2 size-40 sm:size-52 md:size-60 lg:size-72 bg-secondary  [filter:blur(120px)] md:[filter:blur(150px)] lg:[filter:blur(180px)]">
        </div>
        <div
            class="absolute z-[-1] top-0 right-0 -translate-y-1/2 translate-x-1/2 size-40 sm:size-52 md:size-60 lg:size-72 bg-primary [filter:blur(120px)] md:[filter:blur(150px)] lg:[filter:blur(180px)]">
        </div>
    </div>


</section>