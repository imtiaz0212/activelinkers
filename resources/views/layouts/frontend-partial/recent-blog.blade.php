@if (!empty($recentBlog) && $recentBlog->isNotEmpty())
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-[30px]">
    @foreach ($recentBlog as $blog)
    <div>
        <a href="{{ url('blog-details/' . $blog->page_url) }}"
            class="aspect-[370/251] block rounded-[20px] overflow-hidden">
            <img class="w-full h-full object-cover" src="{{ asset($blog->featured_image) }}" width="370" height="251"
                alt="{{ $blog->title }}">
        </a>
        <div class="text-sm flex gap-4 mt-3 lg:mt-6">
            <span class="flex items-center gap-2">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.66699 1.66675V4.16675" stroke="#908E8E" stroke-width="1.5" stroke-miterlimit="10"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M13.333 1.66675V4.16675" stroke="#908E8E" stroke-width="1.5" stroke-miterlimit="10"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M2.91699 7.57495H17.0837" stroke="#908E8E" stroke-width="1.5" stroke-miterlimit="10"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M17.5 7.08341V14.1667C17.5 16.6667 16.25 18.3334 13.3333 18.3334H6.66667C3.75 18.3334 2.5 16.6667 2.5 14.1667V7.08341C2.5 4.58341 3.75 2.91675 6.66667 2.91675H13.3333C16.25 2.91675 17.5 4.58341 17.5 7.08341Z"
                        stroke="#908E8E" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M13.0791 11.4167H13.0866" stroke="#908E8E" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M13.0791 13.9167H13.0866" stroke="#908E8E" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M9.99607 11.4167H10.0036" stroke="#908E8E" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M9.99607 13.9167H10.0036" stroke="#908E8E" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M6.91209 11.4167H6.91957" stroke="#908E8E" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M6.91209 13.9167H6.91957" stroke="#908E8E" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <span>{{ !empty($blog->created) ? date('M d, Y', strtotime($blog->created)) : date('M d, Y') }}</span>
            </span>
            {{-- <span class="flex items-center gap-2">
                <svg stroke="currentColor" fill="none" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12 19C10.067 19 8.31704 18.2165 7.05029 16.9498L12 12L12 5C15.866 5 19 8.13401 19 12C19 15.866 15.866 19 12 19Z"
                        fill="currentColor"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12ZM21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                        fill="currentColor"></path>
                </svg>
                <span>{{ \Carbon\Carbon::parse($blog->created_at)->diffForhumans() }}</span>
            </span> --}}
            <span class="flex items-center gap-2">
                <svg class="h-5 w-5" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
                    height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12.5 7.25a.75.75 0 0 0-1.5 0v5.5c0 .27.144.518.378.651l3.5 2a.75.75 0 0 0 .744-1.302L12.5 12.315V7.25Z">
                    </path>
                    <path
                        d="M12 1c6.075 0 11 4.925 11 11s-4.925 11-11 11S1 18.075 1 12 5.925 1 12 1ZM2.5 12a9.5 9.5 0 0 0 9.5 9.5 9.5 9.5 0 0 0 9.5-9.5A9.5 9.5 0 0 0 12 2.5 9.5 9.5 0 0 0 2.5 12Z">
                    </path>
                </svg>
                <span>{{ $blog->read_time }} min read</span>
            </span>

        </div>
        <a href="{{ url('blog-details/' . $blog->page_url) }}"
            class="text-xl font-semibold leading-[30px] my-2 lg:mt-4 lg:mb-5 text-[#212121] block">
            {{ $blog->title }}
        </a>
        <div class="flex items-center gap-[10px] text-sm">
            <img src="{{ asset($blog->userList->avatar) }}" alt="{{ $blog->userList->name }}" width="35" height="35"
                class="rounded-full">
            <span class="text-[#212121] text-sm font-semibold leading-[22px]">{{ $blog->userList->name }}</span>
        </div>
    </div>
    @endforeach
</div>
@endif