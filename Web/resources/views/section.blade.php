<?php
    $active = 'section';
    $title = 'Verbum - Dział: '.$section -> name;
    $lazy = true;
    $sect = true;
?>

@extends('layouts.app')
@section('content')
<article class="section">
    <h1>{{ $section -> name }}</h1>
    <div id="app">
        <Sect></Sect>
    </div>
</article>
@endsection
