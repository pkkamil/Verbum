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
                @else
                    <a href="{{ url('/admin/words') }}" class="button">Wróć</a>
                @endif
                <a href="{{ url()->current().'/edit' }}" class="button">Edytuj</a>
                <a href="{{ url()->current().'/delete' }}" class="button danger">Usuń</a>
            </section>
        </section>
    </article>
@endsection
