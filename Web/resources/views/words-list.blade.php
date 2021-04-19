<?php
    $active = 'words-list';
    $title = 'Verbum - Lista słów';
    $lazy = true;
?>

@extends('layouts.app')
@section('content')
    <article class="words-list list">
        <table>
            <thead>
                <th scope="col">ID</th>
                <th scope="col">Słowo</th>
                <th scope="col">Tłumaczenie</th>
                <th scope="col">Operacje</th>
            </thead>
            <tbody>
                @foreach($words as $word)
                    <tr>
                        <td data-label="ID">{{ $word -> id }}</td>
                        <td data-label="Słowo">{{ $word -> word }}</td>
                        <td data-label="Tłumaczenie"><p>{{ $word -> translation }}</p></td>
                        <td data-label="Operacje">
                            <a href="{{ url('/admin/words/'.$word -> id) }}"><i class="fas fa-eye"></i></a>
                            <i class="fas fa-trash danger-small"></i>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $words->links('vendor.pagination.custom') }}
        <article class="dimmer hider">
            <section class="result-box">
                    <h2>Czy na pewno chcesz usunąć słowo <span class="w"></span>?</h2>
                    <form method="POST" action="{{ route('deleteWord') }}" autocomplete="OFF">
                        @csrf
                        <input type="hidden" name="word_id" id="word_id" value="">
                        <button type="submit" class="danger">Usuń</button>
                        <button type="button" class="reverse-color">Anuluj</button>
                    </form>
            </section>
        </article>
    </article>
    <script>
        let clicks = document.querySelectorAll('.danger-small');
        let dimmer = document.querySelector('.dimmer');
        let dimmer_word = dimmer.querySelector('.w');

        clicks.forEach(click => {
            click.addEventListener('click', (e) => {
                let w = e.path[2].querySelector('td:nth-child(2)').textContent;
                document.querySelector('#word_id').value = e.path[2].querySelector('td:nth-child(1)').textContent;
                dimmer_word.textContent = w;
                dimmer.style.display = 'flex';
            });
        });

        document.querySelector('.reverse-color').addEventListener('click', () => {
            dimmer.style.display = 'none';
        })
    </script>
@endsection
