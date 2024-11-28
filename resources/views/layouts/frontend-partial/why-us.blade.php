@php
$chooseUsInfo = $sectionData->where('section', 'chooseUs')->first();
$chooseUsInfo = (!empty($chooseUsInfo->content) ? json_decode($chooseUsInfo->content) : '');
@endphp

@if (!empty($whyUs) && $whyUs->isNotEmpty())
<section id="whyUsPage" class="whyUs z-[1] relative overflow-hidden sectionGap bg-[#FFF4F3]">
    <div class="container">
        <div class="grid lg:grid-cols-2 gap-y-5 items-center">
            <div>
                <p class="sectionSub">{{!empty($chooseUsInfo->subtitle) ? $chooseUsInfo->subtitle : ''}}</p>
                <h2 class="sectionTitle">{!! !empty($chooseUsInfo->title) ? $chooseUsInfo->title : '' !!}</h2>

                <div class="grid sm:grid-cols-2 gap-4 md:gap-6 mt-5 md:mt-16 ">
                    @foreach ($whyUs as $key => $row)
                    <div class="relative flex items-start gap-4 p-4 rounded-xl border border-primary/40 bg-white">
                        <span class="shrink-0">
                    {!!$row->icon!!}
                        </span>
                        <div>
                            <h3 class="text-xl leading-[30px] text-black font-semibold ">
                                {{ !empty($row->title) ? $row->title : '' }}
                            </h3>
                            <p class="text-base">
                                {!! !empty($row->description) ? $row->description : '' !!}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div>
                @if (!empty($chooseUsInfo))
                <img src="{{ asset($chooseUsInfo->image) }}" class="!max-w-[495px] w-full mx-auto" width="495"
                    height="576" alt="Why choose us image">
                @endif
            </div>
        </div>
    </div>

    <div
        class="absolute z-[-1] bottom-0 right-0 translate-y-1/2 translate-x-1/2 size-80 bg-primary [filter:blur(180px)]">
    </div>
</section>
@endif