<?php
    $active = '404';
    $title = 'Verbum - Zagubiono';
    $lazy = true;
?>

@extends('layouts.app')
@section('content')
    <article class="not-found">
        <section class="info">
            <h2><span class="long">Strona, której szukasz nie istnieje</span><span class="short">Zaginąłeś!</span></h2>
            <a href="{{ url('/') }}">Wróć na właściwą ścieżkę</a>
        </section>
    </article>
@endsection
