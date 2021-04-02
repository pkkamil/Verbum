<?php
    $active = 'suggestion';
    $title = 'Verbum - Słowa do zatwierdzenia | '.strtoupper($suggestion -> word);
    $lazy = true;
?>

@extends('layouts.app')
@section('content')
    <article class="suggestion-details">
        <section class="box">
            <h3>{{ $suggestion -> word }}</h3>
            <p>{{ $suggestion -> translation }}</p>
            <section class="down">
                <h4><b>Dodano:</b> {{ date('d.m.Y H:i:s', strtotime($suggestion -> added_at)) }}</h4>
                <h4><b>Przez:</b> {{ \App\User::find($suggestion -> user_id) -> name }}</h4>
            </section>
            @if ($duplicate)
                <section class="duplicate">
                    <h2><span style="color: #AA1A1A">UWAGA:</span> To słowo znajduje się już w bazie!</h2>
                </section>
            @endif
            <section class="operations">
                <a href="{{ url('/admin/suggestions')}}" class="button">Wróć</a>
                @if ($duplicate)
                    <a href="{{ url('/admin/words/'.$duplicate -> id) }}" class="button">Podgląd</a>
                    <button class="success">Zastąp</button>
                @else
                    <button class="success">Zatwierdź</button>
                @endif
                <a href="{{ url()->current().'/edit' }}" class="button">Edytuj</a>
                <button class="danger">Usuń</button>
            </section>
        </section>
        <article class="dimmer hider dimmer-delete">
            <section class="result-box">
                    <h2>Czy na pewno chcesz usunąć słowo <span class="w">{{ $suggestion -> word }}</span>?</h2>
                    <form method="POST" action="{{ route('deleteSuggestion') }}">
                        @csrf
                        <input type="hidden" name="suggestion_id" id="suggestion_id" value="{{ $suggestion -> id }}">
                        <button type="submit" class="danger">Usuń</button>
                        <button type="button" class="reverse-color">Anuluj</button>
                    </form>
            </section>
        </article>
        <article class="dimmer hider dimmer-replace">
            <section class="result-box">
                    <h2>Czy na pewno chcesz @if ($duplicate) zastąpić @else zatwierdzić @endif słowo <span class="w">{{ $suggestion -> word }}</span>?</h2>
                    @if ($duplicate)
                        <form method="POST" action="{{ route('replaceWord') }}">
                            @csrf
                            <input type="hidden" name="suggestion_id" id="suggestion_id" value="{{ $suggestion -> id }}">
                            <button type="submit" class="success">Zastąp</button>
                            <button type="button" class="reverse-color">Anuluj</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('acceptSuggestion') }}">
                            @csrf
                            <input type="hidden" name="suggestion_id" id="suggestion_id" value="{{ $suggestion -> id }}">
                            <button type="submit" class="success">Zatwierdź</button>
                            <button type="button" class="reverse-color">Anuluj</button>
                        </form>
                    @endif
            </section>
        </article>
    </article>
    <script>
        let danger = document.querySelector('.danger');
        let replace = document.querySelector('.success');
        let dimmer_delete = document.querySelector('.dimmer-delete');
        let dimmer_replace = document.querySelector('.dimmer-replace');

        danger.addEventListener('click', (e) => {
            dimmer_delete.style.display = 'flex';
        });

        replace.addEventListener('click', (e) => {
            dimmer_replace.style.display = 'flex';
        });

        document.querySelectorAll('.reverse-color').forEach(e => {
            e.addEventListener('click', () => {
                if (dimmer_delete.style.display == 'flex')
                    dimmer_delete.style.display = 'none';
                else
                    dimmer_replace.style.display = 'none';
            })
        })
    </script>
@endsection
