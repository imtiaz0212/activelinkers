@php
$statisticInfo = $sectionData->where('section', 'statistics')->first();
$statisticInfo = (!empty($statisticInfo->content) ? json_decode($statisticInfo->content) : '');
@endphp


<section class="sectionGap  bg-[#F8F8FA] relative z-[1]">
    <img class="absolute animate-updown right-14 z-[-1] top-12 opacity-5 hidden xl:block"
        src="{{ asset('public') }}/images/about/advantage-up.png" alt="advantage us top image" loading="lazy">

    <img class="absolute animate-updown right-14 z-[-1] top-[168px] opacity-5 hidden xl:block"
        src="{{ asset('public') }}/images/about/advantage-down.png " alt="advantage us top image" loading="lazy">

    <img draggable="false" (dragstart)="false;"
        class="stopdraggable absolute -left-12 z-[-1] md:-right-8 -bottom-12 w-[30%] md:w-[30%] lg:w-auto animate-updown hidden xl:block"
        src="{{ asset('public') }}/images/rocket.webp" alt="rocket Image" loading="lazy">

    <div class="container">
        <div
            class="lg:grid grid-cols-12 gap-[30px] justify-items-center pb-5 md:pb-[61px] border-b-[1px] border-black border-opacity-10 space-y-5 lg:space-y-0">
            <div class="col-start-1 col-end-7 space-y-4 lg:mr-[-10px]">
                <p class="sectionSub">{{$statisticInfo->subtitle}}</p>
                <h1 class="sectionTitle">{{$statisticInfo->title}}</h1>
            </div>

            <div class="col-start-8 col-end-13">
                @if (!empty($statisticInfo->image))
                <div class="rounded-[10px] overflow-hidden aspect-[470/251]">
                    <img class=" h-full w-full" src="{{ asset($statisticInfo->image) }}" width="470" height="251"
                        alt="sustainable image" loading="lazy">
                </div>
                @endif
            </div>
        </div>

        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 pt-11 gap-6 lg:gap-auto">
            <div class="statictics-details ">
                <div class="statistic">
                    <h2 class="font-sans">
                        $<strong
                            data-target='{{ !empty($statisticInfo->client_capital) ? $statisticInfo->client_capital : 0 }}'
                            class="count">0</strong><span>m</span>
                    </h2>
                    <p>Client capital raised</p>
                </div>
            </div>
            <div class="statictics-details ">
                <div class="statistic">
                    <h2 class="font-sans">
                        <strong
                            data-target="{{ !empty($statisticInfo->founded_since) ? $statisticInfo->founded_since : 0 }}"
                            class="count">0</strong><span>Y</span>
                    </h2>
                    <p>Founded since 2016</p>
                </div>
            </div>
            <div class="statictics-details ">
                <div class="statistic">
                    <h2 class="font-sans">
                        <strong
                            data-target="{{ !empty($statisticInfo->team_members) ? $statisticInfo->team_members : 0 }}"
                            class="count">0</strong><span>+</span>
                    </h2>
                    <p>Amazing team members</p>
                </div>
            </div>
            <div class="statictics-details ">
                <div class="statistic">
                    <h2 class="font-sans">
                        <strong
                            data-target="{{ !empty($statisticInfo->active_post) ? $statisticInfo->active_post : 0 }}"
                            id="activePost" class="count">0</strong><span>+</span>
                    </h2>
                    <p>Active post and running</p>
                </div>
            </div>
        </div>
    </div>
</section>




@push('footerPartial')
<script>
    function respondToVisibility(element, callback) {
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        observer.disconnect();
                        callback();
                    }
                });
            }, {
                root: null
            });
            observer.observe(element);
        }
        const speed = 200;
        document.querySelectorAll('.count').forEach(counter => {
            respondToVisibility(counter, () => {
                const target = parseInt(counter.getAttribute('data-target'));
                const increment = Math.max(Math.trunc(target / speed), 1);

                (async function update() {
                    const count = parseInt(counter.innerText);
                    if (count < target) {
                        counter.innerText = count + increment;
                        await new Promise(resolve => requestAnimationFrame(resolve));
                        await update();
                    } else {
                        counter.innerText = target;
                    }
                })();
            });
        });
</script>
@endpush