<?php
    $active = 'section';
    $title = 'Verbum - Edycja Działu: '.$section -> name;
    $lazy = true;
?>

@extends('layouts.app')
@section('content')
<article class="section section-create">
    <div class="operations">
        <a href="{{ url('/profile/sections') }}" class="button single">Wróć</a>
    </div>
    <h1>Edycja działu</h1>
    <section class="name">
        <form method="POST" action="{{ route('editSection') }}" autocomplete="off">
            @csrf
            <input type="hidden" name="section_id" id="section_id" value="{{ $section -> id }}">
            <input type="hidden" name="words" id="words">
            <div class="name-group group">
                <input type="text" name="name" id="name" placeholder="Nazwa działu" value="{{ $section -> name }}">
                <button type="submit"><i class="fas fa-plus"></i></button>
            </div>
        </form>
    </section>
    <h2>Dodane słowa</h2>
    @if (count($section -> words) == 0)
        <p class="empty">Nie dodano wystarczającej ilości słów</p>
        <section class="all-words added">
        </section>
    @else
        <p class="empty" style="display: none">Nie dodano wystarczającej ilości słów</p>
        <section class="all-words added">
            @foreach ($section -> words as $word)
                <section class="single-word" id="{{ 'n'.$word -> word_id }}">
                    <h3>{{ \App\Word::find($word -> word_id) -> word  }}</h3>
                    <p>{{ \App\Word::find($word -> word_id) -> translation  }}</p>
                </section>
            @endforeach
        </section>
    @endif
    <div id="app">
        <Editing></Editing>
    </div>
</article>
@endsection
