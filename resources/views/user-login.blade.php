@extends('layouts.frontend')
@section('content')

<section>
    <div class="container">
        <div class="construction">
            <figure class="w-full">
                <img draggable="false" (dragstart)="false;" src="{{ asset('public/websites-under-construction-pages.jpg') }}" alt="Under Construction Pages">
                {{-- <figcaption>This website Under Construction</figcaption> --}}
            </figure>
        </div>
    </div>
</section>

@endsection

@push('headerPartial')
    <style>
        .construction {
            padding-top: 100px;
            height: 76vh;
            position: relative;
        }
        .construction img {
            width: 100%;
        }
        figure:before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 9;
            background: rgba(240,232,214,0.1);
        }
    </style>
@endpush
