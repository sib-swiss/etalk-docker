@extends('layouts.app')

@section('content')
    <header class="fixed w-full bg-white flex justify-between py-2 px-4 ">
        @if (!request()->embed)
            <nav class="opacity-30">
                <a href="{{ route('home') }}">
                    <img src="{{ url('i/back.png') }}" id="bBack" alt="Back" class="btn"
                        title="Retour à l’accueil" />
                </a>
            </nav>
        @endif

        <nav id="controls" class="flex opacity-30">
            <img src="{{ url('i/loading.gif') }}" id="loading" class="btn" alt="" />
            <img src="{{ url('i/share.png') }}" id="bShare" class="btn" alt="Share"
                title="Partager / Intégrer" />
            <img src="{{ url('i/audio_mute.png') }}" id="bMute" class="btn" alt="Mute"
                title="Activer/Couper le son" />
            <img src="{{ url('i/mode_full.png') }}" id="bMode" class="btn" alt="Transcript"
                title="Afficher/Masquer le transcript" />
            <img src="{{ url('i/prev.png') }}" id="bPrev" class="btn" alt="◀︎◀︎" title="Précédent" />
            <img src="{{ url('i/play.png') }}" id="bPlay" class="btn" alt="▶︎" title="Play" />
            <img src="{{ url('i/pause.png') }}" id="bPause" class="btn" alt="Pause" title="Pause" />
            <img src="{{ url('i/stop.png') }}" id="bStop" class="btn" alt="◼︎" title="Stop" />
            <img src="{{ url('i/ffw.png') }}" id="bNext" class="btn" alt="▶︎▶︎" title="Suivant" />
        </nav>
    </header>



    <div style="background-image: url('{{ url('i/bg_dia.png') }}') " class="flex">

        <div class="w-1/4 bg-white p-6">
            @foreach ($talk->sounds as $sound)
                <div class="pb-6">
                    <h2 class="text-2xl font-bold mb-6">{{ $sound->section_title }}</h2>
                    {{ $sound->text }}
                </div>
            @endforeach

        </div>


        <div class="w-3/4 p-4 flex flex-col justify-between h-screen fixed left-1/4 top-10">
            <div class="text-center ">
                <figure class="inline-block ">
                    <img src="{{ url('storage/tmp/' . $talk->sounds[0]->file) }}" alt="">
                    <figcaption></figcaption>
                </figure>
            </div>


            <div class="bg-white mb-10 rounded-sm p-4 flex">
                <span>References</span>
                <a class="flex" href="{{ $talk->sounds[0]->entities }}">
                    <img src="{{ url('i/link.png') }}" alt="">
                    https:
                </a>
            </div>
        </div>


        <audio id="player" preload="auto" src="{{ url('storage/data/' . $talk->sounds[0]->name) }}"
            onerror="alert('The sound file \''+this.src+'\' could not be loaded.');" onended="endedPlay();"
            onloadstart="document.getElementById('loading').style.display='inline';"
            oncanplay="document.getElementById('loading').style.display='none';" onplay="startedPlay();">
            <source src="{{ url('storage/data/' . $talk->sounds[0]->name) }}" type="audio/mp3">HTML5 Only!
        </audio>
    </div>
@endsection
