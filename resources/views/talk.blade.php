@extends('layouts.app')

@section('content')
    <div x-data="etalkShow({{ $talk->sounds->map->only('file', 'name') }})">

        <div id="wait" x-show="wait" x-transition x-transition.duration.500ms>

            <header>
                <h1>{{ $talk->title }}</h1>
                <h2>{{ $talk->author }} - {{ $talk->date->format('d.m.Y') }}</h2>
                <a @click="play()" href="#0" class="vidPlay">▶</a>
            </header>
            <nav>
                <h2>Sommaire</h2>
                @foreach ($talk->sounds as $i => $sound)
                    @if ('section' === $sound->chaptering)
                        <a href="#{{ $i }}">{{ $sound->section_title }}</a>
                    @endif
                @endforeach
            </nav>
        </div>



        {{-- <aside id="embed">
        <div>
            <div class="close">×</div>
            <h1>Intégrer cette présentation</h1>
            <input id="fShareURL" type="text" readonly="readonly"
                style="float:right;width:87%;border:1px solid #000;margin-top:-1px;">
            <label>URL:</label>
            <br>
            <textarea id="embed_code" readonly="readonly"></textarea>
            <form id="embed_customize" action="/">
                <fieldset>
                    <legend>Dimensions :</legend>
                    <div><input id="embed_w" type="text" value="720"> × <input id="embed_h" type="text"
                            value="405"> pixels</div>
                </fieldset>
                <fieldset>
                    <legend>Options:</legend>
                    <ul>
                        <li>
                            <input id="embed_desc" type="checkbox" checked="checked"><label for="embed_desc"> Description
                                sous la vidéo</label>
                        </li>
                        <li>
                            <input id="embed_link" type="checkbox" checked="checked"><label for="embed_link"> Lien permanent
                                dans la description</label>
                        </li>
                    </ul>
                </fieldset>
            </form>
        </div>
    </aside> --}}


        <div>
            <header class="fixed w-full bg-white flex justify-between py-2 px-4 shadow-xl">
                @if (!request()->embed)
                    <nav class="opacity-30">
                        <a href="{{ route('home') }}">
                            <img src="{{ url('i/back.png') }}" id="bBack" alt="Back" class="btn"
                                title="Retour à l’accueil" />
                        </a>
                    </nav>
                @endif

                <nav id="controls" class="flex opacity-30">
                    <img src="{{ url('i/loading.gif') }}" :class=" 'loading' == status ? 'inline' : 'hidden'" class="btn"
                        alt="" />

                    <img src="{{ url('i/share.png') }}" id="bShare" class="btn" alt="Share"
                        title="Partager / Intégrer" />

                    <img src="{{ url('i/audio_mute.png') }}" ù class="btn" alt="Mute" @click="toggleMute"
                        title="Activer/Couper le son" />

                    <img src="{{ url('i/mode_full.png') }}" @click="toggleMode" class="btn" alt="Transcript"
                        title="Afficher/Masquer le transcript" />

                    <img src="{{ url('i/prev.png') }}" @click="prev" class="btn" alt="◀︎◀︎" title="Précédent" />

                    <img src="{{ url('i/play.png') }}" :class=" 'play' == status ? 'hidden' : 'inline'" class="btn"
                        @click="play" alt="▶︎" title="Play" />

                    <img src="{{ url('i/pause.png') }}" :class="  'play' == status ? 'inline' : 'hidden'" @click="pause"
                        class="btn" alt="Pause" title="Pause" />

                    <img src="{{ url('i/stop.png') }}" @click="stop" class="btn" alt="◼︎" title="Stop" />

                    <img src="{{ url('i/ffw.png') }}" @click="next" class="btn" alt="▶︎▶︎" title="Suivant" />
                </nav>
            </header>



            <div style="background-image: url('{{ url('i/bg_dia.png') }}') " class="flex">

                <div id="viz" x-ref="viz" class="w-1/4 bg-white p-6" x-show="showTranscript" x-transition
                    x-transition.duration.500ms>
                    @foreach ($talk->sounds as $i => $sound)
                        <div class="sound" :class=" currentSnd == {{ $i }} ? 'current' : ''"
                            @click="setCurrentSnd({{ $i }}); play()">
                            @if ($sound->chaptering === 'section')
                                <h2>{{ $sound->section_title }}</h2>
                            @endif
                            {{ $sound->text }}
                        </div>
                    @endforeach
                </div>


                <div class="p-4 flex flex-col justify-between h-screen "
                    :class="showTranscript ? 'w-3/4 left-1/4 fixed top-10' : 'w-full mt-10'" x-transition
                    x-transition.duration.500ms>
                    <div class="text-center ">
                        <figure class="inline-block ">
                            <img x-ref="suondFigure" src="{{ url('storage/tmp/' . $talk->sounds[0]->file) }}"
                                alt="">
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


                <audio x-ref="player" preload="auto" src="{{ url('storage/data/' . $talk->sounds[0]->name) }}"
                    x-on:error="errorHandler" x-on:ended="endedPlay" x-on:loadstart="loadstart" x-on:canplay="canplay"
                    x-on:play="startedPlay">
                    <source src="{{ url('storage/data/' . $talk->sounds[0]->name) }}" type="audio/mp3">HTML5 Only!
                </audio>
            </div>
        </div>
    </div>
@endsection
