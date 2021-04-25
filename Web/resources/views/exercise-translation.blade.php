<?php
    $active = 'exercises';

    if (!isset($section_id))
        $section_id = 0;

    if ($section_id != 0)
        $title = 'Verbum - Ćwiczenia | Tłumaczenie | '.\App\Section::find($section_id) -> name;
    else
        $title = 'Verbum - Ćwiczenia | Tłumaczenie';
    $lazy = True;
?>

@extends('layouts.app')
@section('content')
    <article class="exercise translation">
        <h4>Pozostały czas: <span class="timer">10</span></h4>
        @if ($section_id != 0)
            <h2>{{ \App\Word::find($word -> word_id) -> word }}</h2>
            <h3>{{ \App\Word::find($word -> word_id) -> translation }}</h3>
        @else
            <h2>{{ $word['word'] }}</h2>
            <h3 class="tn">{{ $word['translation'] }}</h3>
            <form action="{{ route('rememberWord') }}" method="POST">
                @csrf
                <input type="hidden" name="word" value="{{ $word['id'] }}">
                <button type="submit">Znam to słowo</button>
            </form>
        @endif
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
