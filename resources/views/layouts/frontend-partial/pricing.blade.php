@php($packages = $info->packages)
@if (!empty($packages) && $packages->isNotEmpty())
<div class="bg-[#FAF9F9]">
    <div class="container">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 xl:gap-12 py-10 md:py-24">
            @foreach ($packages as $key => $row)
            <div
                class="relative pb-[72px] {{ $row->is_recommended == 1 ? 'bg-[#0B121F] hover:' : 'bg-[#FFF]' }} border border-1 border-[#E0E0E0]  rounded-[30px] pt-[30px] pb-[42px] px-6 lg:px-4 xl:px-[30px]  hover:translate-y-[-10px] transition duration-700 group">
                <span
                    class="{{ $row->is_recommended == 1 ? 'border-[#1B263C] text-[#FFF]' : 'border-[#EBEBEB] text-[#212121]' }}   text-[14px] font-medium leading-[22px] px-5 py-2 border border-1  rounded-[11px] transition h-9">
                    {{ strFilter($row->type) }}
                </span>
                <div class="relative pt-[72px] space-y-3 mb-4">
                    @if ($row->is_recommended == 1)
                    <div class="absolute top-4">
                        <span
                            class="text-secondary py-[5px] px-[14px] rounded-[14px] bg-secondary bg-opacity-10 text-[12px] ">
                            Recommended
                        </span>
                    </div>
                    @endif
                    <span
                        class="text-[58px] font-extrabold {{ $row->is_recommended == 1 ? 'text-white ' : 'text-[#212121] ' }}">
                        @if ($row->yearly > 0.0)
                        ${{ $row->yearly }}
                        <span class="text-xs text-[#908E8E]">/year</span>
                        @else
                        ${{ $row->monthly }}
                        <span class="text-xs text-[#908E8E]">/monthly</span>
                        @endif
                    </span>

                    <p class="text-[#908E8E] pt-4 text-[14px] font-medium leading-normal">
                        {{ $row->title }}
                    </p>
                </div>
                <ul class="space-y-[14px] pb-[72px]">
                    @if (!empty($row->features))
                    @php($allFeatures = json_decode($row->features))
                    @foreach ($allFeatures as $feature)
                    <li class="flex gap-3 items-center text-[#908E8E] font-medium ">
                        <span>
                            <svg class="fill-secondary" xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                viewBox="0 0 22 22" fill="none">
                                <g opacity="0.5">
                                    <rect width="22" height="22" rx="7" />
                                    <path d="M6 10.8001L9.66133 14.0002L16 7.00024" stroke="white" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </g>
                            </svg>
                        </span>
                        {{ $feature }}
                    </li>
                    @endforeach
                    @endif
                </ul>
                <a href="{{ url('contact') }}"
                    class="absolute bottom-2 left-4 w-[calc(100%-30px)] pricing-btn {{ $row->is_recommended == 1 ? 'bg-transparent text-secondary border-secondary group-hover:bg-secondary group-hover:text-white group-hover:border-secondary ' : 'bg-white text-primary group-hover:bg-primary group-hover:text-white' }} ">
                    Choose Plan
                </a>
            </div>
            @endforeach

        </div>
    </div>
</div>
@endif