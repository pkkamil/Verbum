<?php
    $active = 'add';
    $title = 'Verbum - Dodawanie nowych słów';
    $lazy = True;
    $meta = True;
?>

@extends('layouts.app')
@section('content')
<article class="adding-words">
    <section class="left-part">
        <div id="app">
            <Suggestion></Suggestion>
        </div>
    </section>
    <section class="right-part">
    </section>
</article>
@endsection
