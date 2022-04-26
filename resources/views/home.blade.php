@extends('layouts.app')

@section('content')
    @include('navbar')

    @include('carousel')


    <div>
        Search input
    </div>

    <div>
        @foreach ($talks as $talk)
            <article class="container mx-auto flex justify-start mb-10 bg-white p-6">
                <div class="w-1/4">
                    <a href="#" target="_blank" rel="noopener noreferrer">
                        <img src="{{ url('storage/tmp/' . $talk->sounds[0]->file) }}" alt="image">
                    </a>
                </div>

                <div class="pt-1 px-6 flex-grow">
                    <h2 class="text-3xl font-weight-bolder mb-2">
                        <a href="{{ route('talk.show', $talk) }}" target="_blank" rel="noopener noreferrer">
                            {{ $talk->title }}
                        </a>
                    </h2>



                    <div class="text-gray-400">
                        {{ $talk->author }} |
                        <a href="#">eTalk</a> |
                        {{ $talk->duration }} |
                        {{ $talk->date->format('F d, Y') }}
                        <br>
                        Metadata: <a href="{{ $talk->external_id }}" target="_blank">{{ $talk->external_id }}</a>


                    </div>


                    <div class="float-right">
                        <a class="inline-block bg-[#511C69] text-white p-4" href="#" target="_blank"
                            rel="noopener noreferrer">Read eTalk</a>
                    </div>

                </div>
            </article>
        @endforeach
    </div>
@endsection
