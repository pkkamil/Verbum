<?php
    $active = 'section';
    $title = 'Verbum - Tworzenie nowego działu';
    $lazy = true;
?>

@extends('layouts.app')
@section('content')
<article class="section section-create">
    <h1>Tworzenie nowego działu</h1>
    <section class="name">
        <form method="POST" action="{{ route('createSection') }}" autocomplete="off">
            @csrf
            <input type="hidden" name="words" id="words">
            <div class="name-group group">
                <input type="text" name="name" id="name" placeholder="Nazwa działu">
                <button type="submit" class="disabled" disabled><i class="fas fa-plus"></i></button>
            </div>
        </form>
    </section>
    <h2>Dodane słowa</h2>
    <p class="empty">Nie dodano żadnych słów</p>
    <section class="all-words added">
    </section>
    <div id="app">
        <Adding></Adding>
    </div>
</article>
@endsection
