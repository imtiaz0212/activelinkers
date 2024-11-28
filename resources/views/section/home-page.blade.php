@extends('layouts.app')

@section('content')
<div>
    <!-- Page Header -->
    <div class="panelHeader">
        <h3 class="panelHeaderTitle">Home Page</h3>
    </div>

    <!-- Form -->
    <div class=" shadow-md rounded p-5">


        <div class="grid gap-4 mb-4">
            <div class="panelHeader bg-darkblue text-white">
                <h3 class="panelHeaderTitle lg:text-xl">Hero Section</h3>
            </div>

            @php
            $heroInfo = $results->where('section', 'hero')->first();
            $heroContent = (!empty($heroInfo->content) ? json_decode($heroInfo->content) : '');
            $heroTitle = (!empty($heroContent->title) ? $heroContent->title : '');
            $heroSubtitle = (!empty($heroContent->subtitle) ? $heroContent->subtitle : '');
            $heroButtonText = (!empty($heroContent->button_text) ? $heroContent->button_text : '');
            $heroButtonLink = (!empty($heroContent->button_link) ? $heroContent->button_link : '');
            $heroImage = (!empty($heroContent->image) ? $heroContent->image : '');
            @endphp

            <form action="{{route('admin.home-page.updateHero')}}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="grid lg:grid-cols-[auto_300px] gap-10">
                    <div class="grid gap-4">
                        <div class="grid gap-1.5">
                            <label for="title" class="inputLabel">Title</label>
                            <input type="text" name="hero[title]" value="{{$heroTitle}}" id="title" placeholder="Title"
                                class="inputField" required />
                        </div>

                        <div class="grid gap-1.5">
                            <label for="subtitle" class="inputLabel">Subtitle</label>
                            <textarea class="inputField" name="hero[subtitle]">{{$heroSubtitle}}</textarea>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="grid gap-1.5">
                                <label for="subtitle" class="inputLabel">Button Text</label>
                                <input type="text" name="hero[button_text]" value="{{$heroButtonText}}"
                                    class="inputField">
                            </div>

                            <div class="grid gap-1.5">
                                <label for="subtitle" class="inputLabel">Button Link</label>
                                <input type="text" name="hero[button_link]" value="{{$heroButtonLink}}"
                                    placeholder="https://domain.com" class="inputField">
                            </div>
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="button">Update</button>
                        </div>
                    </div>

                    <div class="w-full order-first lg:order-last">
                        <div id="displayHeroImage"
                            class="relative border bg-center bg-contain bg-no-repeat bg-white aspect-[295/244] rounded w-full">
                        </div>
                        <label for="heroImage" class="button button--secondary w-full mt-3">
                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"
                                aria-hidden="true" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            Upload Image
                        </label>
                        <input type="file" name="heroImage" id="heroImage" class="hidden" />
                    </div>
                </div>
            </form>
        </div>

        <div class="grid gap-4 mb-4">
            <div class="panelHeader bg-darkblue text-white">
                <h3 class="panelHeaderTitle lg:text-xl">Statistics Section</h3>
            </div>

            @php
            $statisticsInfo = $results->where('section', 'statistics')->first();
            $statisticsContent = (!empty($statisticsInfo->content) ? json_decode($statisticsInfo->content) : '');
            $statisticsTitle = (!empty($statisticsContent->title) ? $statisticsContent->title : '');
            $statisticsSubtitle = (!empty($statisticsContent->subtitle) ? $statisticsContent->subtitle : '');
            $statisticsClientCapital = (!empty($statisticsContent->client_capital) ? $statisticsContent->client_capital
            : '');
            $statisticsFoundedSince = (!empty($statisticsContent->founded_since) ? $statisticsContent->founded_since :
            '');
            $statisticsTeamMembers = (!empty($statisticsContent->team_members) ? $statisticsContent->team_members : '');
            $statisticsActivePost = (!empty($statisticsContent->active_post) ? $statisticsContent->active_post : '');
            $statisticsImage = (!empty($statisticsContent->image) ? $statisticsContent->image : '');
            @endphp

            <form action="{{route('admin.home-page.updateStatistics')}}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="grid lg:grid-cols-[auto_300px] gap-10">
                    <div class="grid gap-4">
                        <div class="grid gap-1.5">
                            <label for="title" class="inputLabel">Title</label>
                            <input type="text" name="statistics[title]" value="{{$statisticsTitle}}" id="title"
                                placeholder="Title" class="inputField" required />
                        </div>

                        <div class="grid gap-1.5">
                            <label for="subtitle" class="inputLabel">Subtitle</label>
                            <textarea class="inputField" name="statistics[subtitle]">{{$statisticsSubtitle}}</textarea>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="grid gap-1.5">
                                <label for="subtitle" class="inputLabel">Client capital raised</label>
                                <input type="text" name="statistics[client_capital]"
                                    value="{{$statisticsClientCapital}}" class="inputField">
                            </div>

                            <div class="grid gap-1.5">
                                <label for="subtitle" class="inputLabel">Founded since</label>
                                <input type="text" name="statistics[founded_since]" value="{{$statisticsFoundedSince}}"
                                    class="inputField">
                            </div>

                            <div class="grid gap-1.5">
                                <label for="subtitle" class="inputLabel">Amazing team members</label>
                                <input type="text" name="statistics[team_members]" value="{{$statisticsTeamMembers}}"
                                    class="inputField">
                            </div>

                            <div class="grid gap-1.5">
                                <label for="subtitle" class="inputLabel">Active post and running</label>
                                <input type="text" name="statistics[active_post]" value="{{$statisticsActivePost}}"
                                    class="inputField">
                            </div>
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="button">Update</button>
                        </div>
                    </div>

                    <div class="w-full order-first lg:order-last">
                        <div id="displayStatisticsImage"
                            class="relative border bg-center bg-contain bg-no-repeat bg-white aspect-[295/244] rounded w-full">
                        </div>
                        <label for="statisticsImage" class="button button--secondary w-full mt-3">
                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"
                                aria-hidden="true" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            Upload Image
                        </label>
                        <input type="file" name="statisticsImage" id="statisticsImage" class="hidden" />
                    </div>
                </div>
            </form>
        </div>

        <div class="grid gap-4 mb-4">
            <div class="panelHeader bg-darkblue text-white">
                <h3 class="panelHeaderTitle lg:text-xl">Choose Us Section</h3>
            </div>

            @php
            $chooseUsInfo = $results->where('section', 'chooseUs')->first();
            $chooseUsContent = (!empty($chooseUsInfo->content) ? json_decode($chooseUsInfo->content) : '');
            $chooseUsTitle = (!empty($chooseUsContent->title) ? $chooseUsContent->title : '');
            $chooseUsSubtitle = (!empty($chooseUsContent->subtitle) ? $chooseUsContent->subtitle : '');
            $chooseUsImage = (!empty($chooseUsContent->image) ? $chooseUsContent->image : '');
            @endphp

            <form action="{{route('admin.home-page.updateChooseUs')}}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="grid lg:grid-cols-[auto_300px] gap-10">
                    <div class="grid gap-4">
                        <div class="grid gap-1.5">
                            <label for="title" class="inputLabel">Title</label>
                            <input type="text" name="chooseUs[title]" value="{{$chooseUsTitle}}" id="title"
                                placeholder="Title" class="inputField" required />
                        </div>

                        <div class="grid gap-1.5">
                            <label for="subtitle" class="inputLabel">Subtitle</label>
                            <textarea class="inputField" name="chooseUs[subtitle]">{{$chooseUsSubtitle}}</textarea>
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="button">Update</button>
                        </div>
                    </div>

                    <div class="w-full order-first lg:order-last">
                        <div id="displayChooseUsImage"
                            class="relative border bg-center bg-contain bg-no-repeat bg-white aspect-[295/244] rounded w-full">
                        </div>
                        <label for="chooseUsImage" class="button button--secondary w-full mt-3">
                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"
                                aria-hidden="true" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            Upload Image
                        </label>
                        <input type="file" name="chooseUsImage" id="chooseUsImage" class="hidden" />
                    </div>
                </div>
            </form>
        </div>

        <div class="grid gap-4 mb-4">
            <div class="panelHeader bg-darkblue text-white">
                <h3 class="panelHeaderTitle lg:text-xl">CTA Section</h3>
            </div>

            @php
            $ctaInfo = $results->where('section', 'cta')->first();
            $ctaContent = (!empty($ctaInfo->content) ? json_decode($ctaInfo->content) : '');
            $ctaTitle = (!empty($ctaContent->title) ? $ctaContent->title : '');
            $ctaButtonText = (!empty($ctaContent->button_text) ? $ctaContent->button_text : '');
            $ctaButtonLink = (!empty($ctaContent->button_link) ? $ctaContent->button_link : '');
            $ctaAverageIncrease = (!empty($ctaContent->average_increase) ? $ctaContent->average_increase : '');
            $ctaCertifiedTeam = (!empty($ctaContent->certified_team) ? $ctaContent->certified_team : '');
            $ctaResultsImproved = (!empty($ctaContent->results_improved) ? $ctaContent->results_improved : '');
            @endphp

            <form action="{{route('admin.home-page.updateCta')}}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="grid gap-4">
                    <div class="grid gap-1.5">
                        <label for="title" class="inputLabel">Title</label>
                        <input type="text" name="cta[title]" value="{{$ctaTitle}}" id="title" placeholder="Title"
                            class="inputField" required />
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="grid gap-1.5">
                            <label for="subtitle" class="inputLabel">Button Text</label>
                            <input type="text" name="cta[button_text]" value="{{$ctaButtonText}}" class="inputField">
                        </div>

                        <div class="grid gap-1.5">
                            <label for="subtitle" class="inputLabel">Button Link</label>
                            <input type="text" name="cta[button_link]" placeholder="https://domain.com"
                                value="{{$ctaButtonLink}}" class="inputField">
                        </div>

                        <div class="grid gap-1.5">
                            <label for="subtitle" class="inputLabel">Average increase</label>
                            <input type="text" name="cta[average_increase]" value="{{$ctaAverageIncrease}}"
                                class="inputField">
                        </div>

                        <div class="grid gap-1.5">
                            <label for="subtitle" class="inputLabel">Certified Team</label>
                            <input type="text" name="cta[certified_team]" value="{{$ctaCertifiedTeam}}"
                                class="inputField">
                        </div>

                        <div class="grid gap-1.5">
                            <label for="subtitle" class="inputLabel">Results Improved</label>
                            <input type="text" name="cta[results_improved]" value="{{$ctaResultsImproved}}"
                                class="inputField">
                        </div>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="button">Update</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
@push('headerPartial')
<style>
    .inputField[type="file"] {
        padding: 0 !important
    }
</style>
@endpush

@push('footerPartial')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    $('#blogDesc').summernote({
            placeholder: 'Page Description',
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onInit: function () {
                    $('.note-editor').addClass('prose');
                }
            }
        });


        //   Display Blog Thumbnail
        function readURL(input, selector) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById(selector).style.backgroundImage = 'url(' + e.target.result + ')';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Hero Image
        const heroImageUrl = "{{asset($heroImage)}}";
        document.getElementById('displayHeroImage').style.backgroundImage = 'url(' + heroImageUrl + ')';

        document.getElementById("heroImage").addEventListener("change", function () {
            readURL(this, "displayHeroImage");
        });

        // Statistics Image
        const statisticsImageUrl = "{{asset($statisticsImage)}}";
        document.getElementById('displayStatisticsImage').style.backgroundImage = 'url(' + statisticsImageUrl + ')';

        document.getElementById("statisticsImage").addEventListener("change", function () {
            readURL(this, "displayStatisticsImage");
        });

        // Choose US Image
        const chooseUsImageUrl = "{{asset($chooseUsImage)}}";
        document.getElementById('displayChooseUsImage').style.backgroundImage = 'url(' + chooseUsImageUrl + ')';

        document.getElementById("chooseUsImage").addEventListener("change", function () {
            readURL(this, "displayChooseUsImage");
        });
</script>
@endpush