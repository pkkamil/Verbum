<?php
    $active = 'exercises';

    if (!isset($section_id))
        $section_id = 0;

    if ($section_id != 0)
        $title = 'Verbum - Ćwiczenia | '.\App\Section::find($section_id) -> name;
    else
        $title = 'Verbum - Ćwiczenia';
    $lazy = True;
?>

@extends('layouts.app')
@section('content')
    <article class="exercises">
        <section class="part translation">
            <a class="images translation" href="{{ url('/exercise/translation') }}">
                <h2>Tłumaczenie</h2>
                <p>Na ekranie pojawiają się słowa po angielsku, następnie po kilku sekundach pojawia się tłumaczenie</p>
            </a>
        </section>
        <section class="part matching">
            <a class="images matching" href="{{ url('/exercise/matching') }}">
                <h2>Dopasowanie</h2>
                <p>Na ekranie pojawia się pięć losowych słów po angielsku oraz tłumaczenia, twoim zadaniem jest dopasowanie ich</p>
            </a>
        </section>
        <section class="part writing">
            <a class="images writing" href="{{ url('/exercise/writing') }}">
                <h2>Pisanie</h2>
                <p>Na ekranie pojawiają się tłumaczenia słów po angielsku, twoim zadaniem jest napisanie tych słów</p>
            </a>
        </section>
    </article>
@endsection
