<?php
    $active = 'exercises';
    $title = 'Verbum - Ćwiczenia | Dopasowanie';
    $lazy = True;
?>

@extends('layouts.app')
@section('content')
<article class="exercise matching">
    <section class="parts">
        <section class="left-part">
            @foreach ($words as $key => $value)
               <h2><span>{{ $key }}</span></h2>
            @endforeach
        </section>
        <section class="right-part">
            @foreach ($words as $key => $value)
                <h3><span>{{ $value }}</span></h3>
            @endforeach
        </section>
    </section>
    <form action="{{ route('checkAnswers') }}" method="POST" autocomplete="off">
        @csrf
        <button type="submit">Sprawdź</button>
    </form>
    @if (isset($result))
    @endif
</article>
<script>
    let words = document.querySelectorAll('h2 span')
    let translations = document.querySelectorAll('h3 span')

    words.forEach(w => {
        w.addEventListener('click', () => {
            if (w.classList.contains('clicked')) {
                words.forEach(e => {
                    if (e.classList.contains('clicked')) {
                        e.classList.remove('clicked')
                        e.style.transform = "scale(1)"
                    }
                })
                w.classList.remove('clicked')
                w.style.transform = "scale(1)"
            } else {
                words.forEach(e => {
                    if (e.classList.contains('clicked')) {
                        e.classList.remove('clicked')
                        e.style.transform = "scale(1)"
                    }
                })
                w.classList.add('clicked')
                w.style.display = "inline-block"
                w.style.transform = "scale(1.1)"
            }
        })
    });

    translations.forEach(t => {
        t.addEventListener('click', () => {
            if (t.classList.contains('clicked')) {
                translations.forEach(e => {
                    if (e.classList.contains('clicked')) {
                        e.classList.remove('clicked')
                        e.style.transform = "scale(1)"
                    }
                })
                t.classList.remove('clicked')
                t.style.transform = "scale(1)"
            } else {
                translations.forEach(e => {
                    if (e.classList.contains('clicked')) {
                        e.classList.remove('clicked')
                        e.style.transform = "scale(1)"
                    }
                })
                t.classList.add('clicked')
                t.style.display = "inline-block"
                t.style.transform = "scale(1.1)"
            }
        })
    });

</script>
@endsection
