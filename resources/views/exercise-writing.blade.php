<?php
    $active = 'exercises';
    $title = 'Verbum - Ćwiczenia | Pisanie';
    $lazy = True;
?>

@extends('layouts.app')
@section('content')
<article class="exercise writing">
    <h4>Pozostały czas: <span class="timer">10</span></h4>
    <form action="{{ route('checkWord') }}" method="POST" autocomplete="off">
        @csrf
        <div class="answer-group group">
            <label for="answer"><i class="fas fa-globe-americas"></i></label>
            <input type="answer" id="answer" name="answer" autofocus placeholder="Word">
        </div>
        <h3 class="tn">{{ $translation }}</h3>
        <input type="hidden" name="word" value="{{ $word }}">
        <input type="hidden" name="translation" value="{{ $translation }}">
        <button type="submit">Sprawdź</button>
    </form>
    @if (isset($result))
        <article class="dimmer">
            <section class="result-box">
                @if ($result == 'correct')
                    <h2><span style="color: #0eaf09">Gratulacje!</span></h2>
                    <p><span style="text-decoration: underline;">{{ $word }}</span> to poprawna odpowiedź.</p>
                @else
                    <h2><span style="color: #bb0909">Niestety!</span></h2>
                    <p><span style="text-decoration: underline;">{{ $word }}</span> to poprawna odpowiedź.</p>
                @endif
                <a href="{{ url('/exercises/writing') }}"><button class="next reverse-color">Dalej</button></a>
            </section>
        </article>
    @endif
</article>
@if (!isset($result))
    <script>
        let timer = 10;
        const countDownEl = $('.timer');
        let t = setInterval(showTime, 1000);

        function showTime() {
            timer--;
            countDownEl.text(timer);
            if (timer == 0) {
                clearInterval(t);
                $('button').click();
            }
        }
    </script>
@endif
@endsection
