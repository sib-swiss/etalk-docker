<div>
    <audio controls="controls" preload="none" src="{{ url('storage/data/'.$getRecord()->name) }}">
        <source src="{{ url('storage/data/'.$getRecord()->name) }}" type="audio/mp3">HTML5 Only!
    </audio>
    {{ $getRecord()->name }}
</div>
