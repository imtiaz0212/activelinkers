@if (!empty($faq) && $faq->isNotEmpty())
<section class="sectionGap bg-[#F6F6F6] relative z-20">
    <img class="absolute left-5 top-8 hidden md:block -z-10" src="{{ asset('public') }}/images/icons/faqbg.svg"
        alt="faqbg">
    <div class="container">


        <div class="mx-auto max-w-[770px] overflow-hidden">
            <div class="gap-2 grid text-center">
                <p class=" sectionSub">Quick Answers</p>
                <h2 class="sectionTitle">
                    Find Answers to <span>Your Asked</span> Questions.
                </h2>
            </div>

            @foreach ($faq as $key => $row)
            <div class="bg-white border border-[#D9D9D9] rounded-[15px] px-4 md:px-6 py-3 md:py-5 my-3 md:my-6">
                <input
                    class="hidden [&:checked+label:after]:rotate-[270deg] [&:checked+label:after]:text-[#212121] [&:checked~.ansDesc]:max-h-96"
                    type="radio" name="accordion-2" id="faqAccordionHeading-{{ $key + 1 }}" {{ $key + 1==1 ? 'checked'
                    : '' }} />
                <label for="faqAccordionHeading-{{ $key + 1 }}"
                    class="flex cursor-pointer justify-between text-lg pr-1 md:pr-0 md:text-xl text-[#212121] leading-[30px] font-medium md:font-semibold relative after:absolute after:content-['\276F'] after:right-0 md:after:right-6 after:top-1 after:[transform:rotate(90deg)] after:text-base after:text-[#908E8E] after:transition-all after:duration-200  ">
                    {{ !empty($row->title) ? $row->title : '' }}
                </label>
                <div class="ansDesc max-h-0 overflow-hidden transition-all duration-500">
                    <p class="mt-4 text-base text-[#5A5858] font-medium leading-[24px]">
                        {!! !empty($row->description) ? $row->description : '' !!}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
</section>
@endif