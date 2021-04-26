<?php
    $active = 'section';
    $title = 'Verbum - Tworzenie nowego działu';
    $lazy = true;
?>

@extends('layouts.app')
@section('content')
<article class="section section-create">
    <div class="pageUp"><i class="fas fa-arrow-up"></i></div>
    <div class="operations">
        <a href="{{ url('/profile/sections') }}" class="button">Wróć</a>
    </div>
    <h1>Tworzenie nowego działu</h1>
    <section class="name">
        <form method="POST" action="{{ route('createSection') }}" autocomplete="off">
            @csrf
            <input type="hidden" name="words" id="words">
            <div class="name-group group">
                <input type="text" name="name" id="name" placeholder="Nazwa działu">
                <button type="submit" class="disabled" disabled><i class="fas fa-plus"></i></button>
            </div>
        </form>
    </section>
    <h2>Dodane słowa</h2>
    <p class="empty">Nie dodano wystarczającej ilości słów</p>
    <section class="all-words added">
    </section>
    <div id="app">
        <Adding></Adding>
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
