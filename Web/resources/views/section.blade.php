<?php
    $active = 'section';
    $title = 'Verbum - Dział: '.$section -> name;
    $lazy = true;
    $sect = true;
?>

@extends('layouts.app')
@section('content')
<article class="section">
    <div class="pageUp"><i class="fas fa-arrow-up"></i></div>
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
<script>
    let pageUp = document.querySelector('.pageUp')

    document.addEventListener('scroll', () => {
        if (window.scrollY < document.querySelector('.all-words').offsetTop - $('nav').height() - 17) {
            pageUp.style.display = 'none'
        } else {
            pageUp.style.display = 'flex'
        }
    })

    pageUp.addEventListener('click', () => {
        window.scrollTo(0,0)
    })
</script>
@endsection
