<?php
    $active = 'suggestion';
    $title = 'Verbum - Edycja słów do zatwierdzenia | '.strtoupper($suggestion -> word);
    $lazy = true;
?>

@extends('layouts.app')
@section('content')
    <article class="suggestion-edit">
        <section class="left-part">
            @if ($errors -> all())
                <div class="errors">
                    @foreach ($errors->all() as $message)
                        <span class="error">{{ $message }}</span>
                    @endforeach
                </div>
            @endif
            <h1>{{ __('Edycja propozycji') }}</h1>
            <form method="POST" action="{{ route('changeSuggestionDetails') }}">
                @csrf
                <input type="hidden" name="suggestion_id" id="suggestion_id" value="{{ $suggestion -> id }}">
                <div class="word-group group">
                    <label for="word">En</label>
                    <input type="text" id="word" name="word" value="{{ $suggestion -> word }}" required autocomplete="word" autofocus placeholder="Word">
                </div>
                <div class="translation-group group">
                    <label for="translation">Pl</label>
                    <input type="text" id="translation" name="translation" value="{{ $suggestion -> translation }}" required placeholder="Tłumaczenie">
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
