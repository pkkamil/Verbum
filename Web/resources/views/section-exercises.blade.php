<?php
    $active = 'section';
    $title = 'Verbum - Ćwiczenia: '.$section -> name;
    $lazy = true;
    $sect = true;
?>

@extends('layouts.app')
@section('content')
<article class="exercises">
    <section class="part translation">
        <a class="images translation" href="{{ url('/exercise/translation/'.$section -> id) }}">
            <h2>Tłumaczenie</h2>
            <p>Na ekranie pojawiają się słowa po angielsku, następnie po kilku sekundach pojawia się tłumaczenie</p>
        </a>
    </section>
    <section class="part matching">
        <a class="images matching" href="{{ url('/exercise/matching/'.$section -> id) }}">
            <h2>Dopasowanie</h2>
            <p>Na ekranie pojawia się pięć losowych słów po angielsku oraz tłumaczenia, twoim zadaniem jest dopasowanie ich</p>
        </a>
    </section>
    <section class="part writing">
        <a class="images writing" href="{{ url('/exercise/writing/'.$section -> id) }}">
            <h2>Pisanie</h2>
            <p>Na ekranie pojawiają się tłumaczenia słów po angielsku, twoim zadaniem jest napisanie tych słów</p>
        </a>
    </section>
</article>
@endsection
