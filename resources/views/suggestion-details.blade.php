<?php
    $active = 'suggestion';
    $title = 'Verbum - Słowa do zatwierdzenia |'.strtoupper($suggestion -> word);
    $lazy = true;
?>

@extends('layouts.app')
@section('content')
    <article class="suggestion-details">
        <section class="box">
            <h3>{{ $suggestion -> word }}</h3>
            <p>{{ $suggestion -> translation }}</p>
            <section class="down">
                <h4><b>Dodano:</b> {{ date('d.m.Y H:i:s', strtotime($suggestion -> added_at)) }}</h4>
                <h4><b>Przez:</b> {{ \App\User::find($suggestion -> user_id) -> name }}</h4>
            </section>
            @if ($duplicate)
                <section class="duplicate">
                    <h2><span style="color: #AA1A1A">UWAGA:</span> To słowo znajduje się już w bazie!</h2>
                </section>
            @endif
            <section class="operations">
                <a href="{{ url('/admin/suggestions')}}" class="button">Wróć</a>
                @if ($duplicate)
                    <a href="{{ url('/admin/words/'.$duplicate -> id) }}" class="button">Podgląd</a>
                    <a href="{{ url()->current().'/replace' }}" class="button success">Zastąp</a>
                @else
                    <a href="{{ url()->current().'/accept' }}" class="button success">Zatwierdź</a>
                @endif
                <a href="{{ url()->current().'/edit' }}" class="button">Edytuj</a>
                <a href="{{ url()->current().'/delete' }}" class="button danger">Usuń</a>
            </section>
        </section>
    </article>
@endsection
