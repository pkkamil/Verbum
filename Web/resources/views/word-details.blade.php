<?php
    $active = 'word';
    $title = 'Verbum - Lista słów | '.strtoupper($word -> word);
    $lazy = true;
?>

@extends('layouts.app')
@section('content')
    <article class="word-details">
        <section class="box">
            <h3>{{ $word -> word }}</h3>
            <p>{{ $word -> translation }}</p>
            <section class="down">
                <h4><b>Utworzono:</b> {{ date('d.m.Y H:i:s', strtotime($word -> created_at)) }}</h4>
                <h4><b>Zmodyfikowano:</b> {{ date('d.m.Y H:i:s', strtotime($word -> updated_at)) }}</h4>
            </section>
            <section class="operations">
                @if (str_contains(url()->previous(), 'suggestions/'))
                    <a href="{{ url()->previous() }}" class="button">Wróć</a>
                @elseif (str_contains(url()->previous(), '/words?page'))
                    <a href="{{ url()->previous() }}" class="button">Wróć</a>
                @else
                    <a href="{{ url('/admin/words') }}" class="button">Wróć</a>
                @endif
                <a href="{{ url()->current().'/edit' }}" class="button">Edytuj</a>
                <button class="danger">Usuń</button>
            </section>
        </section>
        <article class="dimmer hider">
            <section class="result-box">
                    <h2>Czy na pewno chcesz usunąć słowo <span class="w">{{ $word -> word }}</span>?</h2>
                    <form method="POST" action="{{ route('deleteWord') }}">
                        @csrf
                        <input type="hidden" name="word_id" id="word_id" value="{{ $word -> id }}">
                        <button type="submit" class="danger">Usuń</button>
                        <button type="button" class="reverse-color">Anuluj</button>
                    </form>
            </section>
        </article>
    </article>
    <script>
        let click = document.querySelector('.danger');
        let dimmer = document.querySelector('.dimmer');

        click.addEventListener('click', (e) => {
            dimmer.style.display = 'flex';
        });

        document.querySelector('.reverse-color').addEventListener('click', () => {
            dimmer.style.display = 'none';
        })
    </script>
@endsection
