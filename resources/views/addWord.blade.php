<?php
    $active = 'add';
    $title = 'Verbum - Dodawanie nowych słów';
    $lazy = True;
?>

@extends('layouts.app')
@section('content')
<article class="adding-words">
    <section class="left-part">
        @if ($errors -> all())
            <div class="errors">
                @foreach ($errors->all() as $message)
                    <span class="error">{{ $message }}</span>
                @endforeach
            </div>
        @endif
        <h1>{{ __('Dodawanie nowego słowa') }}</h1>
        <form method="POST" action="{{ route('addWord') }}" autocomplete="on">
            @csrf
            <input type="hidden" id="action" name="action" value="">
            <div class="word-group group">
                <label for="word">En</label>
                <input type="text" id="word" name="word" value="{{ old('word') }}" required autocomplete="word" autofocus placeholder="Word">
            </div>
            <div class="translation-group group">
                <label for="translation">Pl</label>
                <input type="text" id="translation" name="translation" value="{{ old('translation') }}" required placeholder="Tłumaczenie">
            </div>
            <button type="submit" class="exit">Dodaj i Wyjdź</button>
            <button type="submit" class="continue">Dodaj następne</button>
        </form>
    </section>
    <section class="right-part">
    </section>
</article>
<script>
    $('.exit').click((e) => {
        $('#action').val('exit');
    });
    $('.continue').click((e) => {
        $('#action').val('continue');
    });
</script>
@endsection
