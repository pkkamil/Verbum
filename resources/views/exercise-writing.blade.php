<?php
    $active = 'exercises';
    $title = 'Verbum - Ćwiczenia | Pisanie';
    $lazy = True;
?>

@extends('layouts.app')
@section('content')
<article class="exercise writing">
    <h4>Pozostały czas: <span class="timer">10</span></h4>
    <form action="{{ route('checkWord') }}" method="POST"">
        @csrf
        <div class="answer-group group">
            <label for="answer"><i class="fas fa-globe-americas"></i></label>
            <input type="answer" id="answer" name="answer" autofocus placeholder="Word">
        </div>
        <h3 class="tn">{{ $word -> translation }}</h3>
        <input type="hidden" name="word" value="{{ $word -> word }}">
        <button type="submit">Sprawdź</button>
    </form>
</article>
<script>
    let timer = 10;
    const countDownEl = $('.timer');
    let t = setInterval(showTime, 1000);

    function showTime() {
        timer--;
        countDownEl.text(timer);
        if (timer == 0) {
            clearInterval(t);
            window.location.reload()
        }
    }
</script>
@endsection
