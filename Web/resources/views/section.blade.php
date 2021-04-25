<?php
    $active = 'section';
    $title = 'Verbum - Dział: '.$section -> name;
    $lazy = true;
    $sect = true;
?>

@extends('layouts.app')
@section('content')
<article class="section">
    <div class="operations triple">
        <a href="{{ url('/exercises/'.$section -> id) }}" class="button">Ćwicz</a>
        <a href="{{ url('/profile/section/'.$section -> id.'/edit') }}" class="button">Edytuj</a>
        <a href="{{ url('/profile/sections') }}" class="button">Wróć</a>
    </div>
    <h1>{{ $section -> name }}</h1>
    <div id="app">
        <Sect></Sect>
    </div>
</article>
@endsection
