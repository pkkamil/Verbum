<?php
    $active = 'suggestions';
    $title = 'Verbum - Słowa do zatwierdzenia';
    $lazy = true;
?>

@extends('layouts.app')
@section('content')
    <article class="suggestions-list list">
        @if (count($suggestions) > 0)
            <table>
                <thead>
                    <th scope="col">ID</th>
                    <th scope="col">Słowo</th>
                    <th scope="col">Autor</th>
                    <th scope="col">Duplikat</th>
                    <th scope="col">Data i czas</th>
                    <th scope="col">Operacje</th>
                </thead>
                <tbody>
                    @foreach($suggestions as $suggestion)
                        <tr>
                            <td data-label="ID">{{ $suggestion -> id }}</td>
                            <td data-label="Słowo">{{ $suggestion -> word }}</td>
                            <td class="translation" style="display: none;">{{ $suggestion -> translation }}</td>
                            <td data-label="Autor">{{ \App\User::find($suggestion -> user_id) -> name }}</td>
                            <td data-label="Duplikat">@if (\App\Word::where('word', $suggestion -> word)->first()) tak @else nie @endif</td>
                            <td data-label="Data i czas">{{ date('d.m.Y H:i:s', strtotime($suggestion -> added_at)) }}</td>
                            <td data-label="Operacje">
                                <a href="{{ url('/admin/suggestions/'.$suggestion -> id) }}"><i class="fas fa-eye"></i></a>
                                @if (\App\Word::where('word', $suggestion -> word)->first())
                                    <p><i class="far fa-check-circle"></i></p>
                                @else
                                    <i class="far fa-check-circle success-small"></i>
                                @endif
                                <i class="fas fa-trash danger-small"></i>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $suggestions->links('vendor.pagination.custom') }}
        @else
            <section class="no-suggestions">
                <h2>Wróć tutaj później!</h2>
                <p>Nie ma żadnych nowych słów do zatwierdzenia.</p>
                <a href="{{ url('/profile') }}" class="button">Wróć</a>
            </section>
        @endif
        <article class="dimmer hider dimmer-danger">
            <section class="result-box">
                    <h2 class="sl">Czy na pewno chcesz usunąć słowo <span class="wd"></span>?</h2>
                    <h5>Tłumaczenie tego słowa: <span class="translation"></span></h5>
                    <form method="POST" action="{{ route('deleteSuggestion') }}" autocomplete="OFF">
                        @csrf
                        <input type="hidden" name="suggestion_id" id="suggestion_id" value="">
                        <button type="submit" class="danger">Usuń</button>
                        <button type="button" class="reverse-color">Anuluj</button>
                    </form>
            </section>
        </article>
        <article class="dimmer hider dimmer-success">
            <section class="result-box">
                    <h2 class="sl">Czy na pewno chcesz zatwierdzić słowo <span class="wa"></span>?</h2>
                    <h5>Tłumaczenie tego słowa: <span class="translation"></span></h5>
                    <form method="POST" action="{{ route('acceptSuggestion') }}">
                        @csrf
                        <input type="hidden" name="suggestion_id" id="suggestion_id" value="">
                        <button type="submit" class="success">Zatwierdź</button>
                        <button type="button" class="reverse-color">Anuluj</button>
                    </form>
            </section>
        </article>
    </article>
    <script>
        let dangers = document.querySelectorAll('.danger-small');
        let accepts = document.querySelectorAll('.success-small');
        let dimmer_delete = document.querySelector('.dimmer-danger');
        let dimmer_accept = document.querySelector('.dimmer-success');
        let dimmer_wordD = dimmer_delete.querySelector('.wd');
        let dimmer_wordA = dimmer_accept.querySelector('.wa');

        dangers.forEach(click => {
            click.addEventListener('click', (e) => {
                let w = e.path[2].querySelector('td:nth-child(2)').textContent;
                document.querySelector('.dimmer-danger .translation').textContent = e.path[2].querySelector('td:nth-child(3)').textContent;
                document.querySelector('#suggestion_id').value = e.path[2].querySelector('td:nth-child(1)').textContent;
                dimmer_wordD.textContent = w;
                dimmer_delete.style.display = 'flex';
            });
        });

        accepts.forEach(click => {
            click.addEventListener('click', (e) => {
                let w = e.path[2].querySelector('td:nth-child(2)').textContent;
                document.querySelector('.dimmer-success .translation').textContent = e.path[2].querySelector('td:nth-child(3)').textContent
                document.querySelector('.dimmer-success #suggestion_id').value = e.path[2].querySelector('td:nth-child(1)').textContent;
                console.log(e.path[2].querySelector('td:nth-child(3)').textContent);
                dimmer_wordA.textContent = w;
                dimmer_accept.style.display = 'flex';
            });
        });

        document.querySelectorAll('.reverse-color').forEach(e => {
            e.addEventListener('click', () => {
                if (dimmer_delete.style.display == 'flex')
                    dimmer_delete.style.display = 'none';
                else
                    dimmer_accept.style.display = 'none';
            })
        })

    </script>
@endsection
