<?php
    $active = '404';
    $title = 'Verbum - Zagubiono';
    $lazy = true;
?>

@extends('layouts.app')
@section('content')
    <article class="not-found">
        <section class="info">
            <h2>Strona, której szukasz nie istnieje</h2>
            <a href="{{ url('/') }}">Wróć na właściwą ścieżkę</a>
        </section>
    </article>
@endsection
