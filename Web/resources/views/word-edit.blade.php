<?php
    $active = 'word';
    $title = 'Verbum - Edycja słów | '.strtoupper($word -> word);
    $lazy = true;
?>

@extends('layouts.app')
@section('content')
    <article class="word-edit">
        <section class="left-part">
            @if ($errors -> all())
                <div class="errors">
                    @foreach ($errors->all() as $message)
                        <span class="error">{{ $message }}</span>
                    @endforeach
                </div>
            @endif
            <h1>Edycja słowa</h1>
            <form method="POST" action="{{ route('changeWordDetails') }}">
                @csrf
                <input type="hidden" name="word_id" id="word_id" value="{{ $word -> id }}">
                <div class="word-group group">
                    <label for="word">En</label>
                    <input type="text" id="word" name="word" value="{{ $word -> word }}" required autocomplete="word" autofocus placeholder="Word">
                </div>
                <div class="translation-group group">
                    <label for="translation">Pl</label>
                    <input type="text" id="translation" name="translation" value="{{ $word -> translation }}" required placeholder="Tłumaczenie">
                </div>
                <section class="operations">
                    <button type="submit">Zapisz</button>
                    <a href="{{ url()->previous() }}" class="button">Wróć</a>
                </section>
            </form>
        </section>
        <section class="right-part">
        </section>
    </article>
@endsection
