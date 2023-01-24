@extends('layouts.app')

@section('content')
    <div x-data="etalkShow({{ $talk->sounds->map->only('id','file', 'filepath') }})">

        <div id="wait" :class="wait ? 'wait' : 'dontWait'">
            <div class="flex">
                <header>
                    <h1>{{ $talk->title }}</h1>
                    <h2>{{ $talk->author }} - {{ $talk->date->format('d.m.Y') }}</h2>
                    <a @click="play()" href="#0" class="vidPlay">▶</a>
                </header>
                <nav>
                    <h2>Sommaire</h2>
                    @foreach ($talk->sounds as $i => $sound)
                        @if ('section' === $sound->chaptering)
                            <a href="#{{ $i }}"
                                @click="setCurrentSnd({{ $i }}); play()">{{ $sound->section_title }}</a>
                        @endif
                    @endforeach
                </nav>

            </div>

        </div>


        <div>
            <header class="fixed w-full bg-white flex justify-between py-2 px-4 shadow-xl top-0 z-10">
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

                    <img src="{{ url('i/share.png') }}" id="bShare" class="btn" alt="Share" data-bs-toggle="modal"
                        data-bs-target="#shareUrlModal" title="Partager / Intégrer" />

                    <img src="{{ url('i/audio_mute.png') }}" class="btn" alt="Mute" @click="toggleMute"
                        title="Activer/Couper le son" />

                    <img :src="showTranscript ? '{{ url('i/mode_full.png') }}' : '{{ url('i/mode_list.png') }}'"
                        @click="toggleMode" class="btn" alt="Transcript" title="Afficher/Masquer le transcript" />

                    <img src="{{ url('i/prev.png') }}" @click="prev" class="btn" alt="◀︎◀︎" title="Précédent" />

                    <img src="{{ url('i/play.png') }}" :class=" 'play' == status ? 'hidden' : 'inline'" class="btn"
                        @click="play" alt="▶︎" title="Play" />

                    <img src="{{ url('i/pause.png') }}" :class="  'play' == status ? 'inline' : 'hidden'" @click="pause"
                        class="btn" alt="Pause" title="Pause" />

                    <img src="{{ url('i/stop.png') }}" @click="stop" class="btn" alt="◼︎" title="Stop" />

                    <img src="{{ url('i/ffw.png') }}" @click="next" class="btn" alt="▶︎▶︎" title="Suivant" />
                </nav>
            </header>



            <div style="background-image: url('{{ url('i/bg_dia.png') }}') " class="lg:flex"
                :class=" wait ? 'blur-sm' : ''">

                <div id="viz" x-ref="viz" :class="showTranscript ? 'withTranscript' : 'withOutTranscript'">
                    @foreach ($talk->sounds as $i => $sound)
                        <div class="sound" data-debug="id_{{ $sound->id }}"
                            :class=" currentSnd == {{ $i }} ? 'current' : ''" x-ref="sound_{{ $i }}"
                            @click="setCurrentSnd({{ $i }}); play()">
                            @if ($sound->chaptering === 'section')
                                <h2>{{ $sound->section_title }}</h2>
                            @endif

                            <figure class="sm:hidden mt-10 mb-2">
                                <img src="{{ $sound->getFirstMediaUrl() }}" alt="">
                                <figcaption></figcaption>
                            </figure>
                            {{ $sound->text }}
                        </div>
                    @endforeach
                </div>


                <div id="dia" :class="showTranscript ? 'withTranscript' : 'withOutTranscript'">
                    <div class="text-center ">
                        <figure class="inline-block">
                            <img x-ref="suondFigure" class="transition-opacity duration-5"
                                src="{{ $talk->sounds[0]->getFirstMediaUrl() }}" alt="">
                            <figcaption></figcaption>
                        </figure>
                    </div>
                    <div class="bg-white mb-12 rounded p-0 text-center text-gray-500 text-sm">
                        <span class="absolute left-0">References</span>
                        <a href="{{ $talk->sounds[0]->entities }}">
                            <img src="{{ url('i/link.png') }}" class="inline" alt="">
                            https:
                        </a>
                    </div>
                </div>


                <audio x-ref="player" preload="auto" src="{{ url('storage/' . $talk->sounds[0]->filepath) }}"
                    x-on:error="errorHandler" x-on:ended="endedPlay" x-on:loadstart="loadstart" x-on:canplay="canplay"
                    x-on:play="startedPlay">
                    <source src="{{ url('storage/' . $talk->sounds[0]->filepath) }}" type="audio/mp3">HTML5 Only!
                </audio>
            </div>
        </div>





        <!-- Modal SHARE -->
        <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
            id="shareUrlModal" tabindex="-1" aria-labelledby="shareUrlModalLabel" aria-hidden="true">
            <div class="modal-dialog relative w-auto pointer-events-none">
                <div
                    class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                    <div class="modal-body relative p-4">
                        <div class="flex items-center">
                            <div class="pr-3">URL:</div>
                            <div class="grow">
                                <input class="w-full" type="text" x-model="currentUrl" readonly="readonly">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
