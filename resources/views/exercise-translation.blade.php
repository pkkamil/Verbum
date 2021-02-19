<?php
    $active = 'exercises';
    $title = 'Verbum - Ćwiczenia | Tłumaczenie';
    $lazy = True;
?>

@extends('layouts.app')
@section('content')
    <article class="exercise translation">
        <h4>Pozostały czas: <span class="timer">10</span></h4>
        <h2>{{ $word -> word }}</h2>
        <h3 class="tn">{{ $word -> translation }}</h3>
        <form action="{{ route('rememberWord') }}" method="POST"">
            @csrf
            <input type="hidden" name="word" value="ridiculous">
            <button type="submit">Znam to słowo</button>
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
