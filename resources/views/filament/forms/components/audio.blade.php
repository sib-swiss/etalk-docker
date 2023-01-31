@if($getRecord())
<div>
    <audio controls="controls" preload="none" src="{{ url('storage/' . $getRecord()->filepath) }}">
        <source src="{{ url('storage/' . $getRecord()->filepath) }}" type="audio/mp3">HTML5 Only!
    </audio>
</div>
@endif
