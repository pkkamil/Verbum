<?php
    $active = 'remembered-list';
    $title = 'Verbum - Lista zapamiętanych słów';
    $lazy = true;
?>

@extends('layouts.app')
@section('content')
    <article class="remembered-list list">
        @if (count($remembered) > 0)
            <table>
                <thead>
                    <th scope="col">#</th>
                    <th scope="col">Słowo</th>
                    <th scope="col">Data zapamiętania</th>
                    <th scope="col">Operacje</th>
                </thead>
                <tbody>
                    @foreach($remembered as $r)
                        <tr>
                            <td data-label="#">{{ ($loop -> index + 1) + ($remembered -> links() -> paginator -> currentPage() - 1) * $remembered -> links() -> paginator -> perPage() }}</td>
                            <td data-label="Słowo">{{ \App\Word::find($r -> word_id) -> word }}</td>
                            <td data-label="Data zapamiętania">{{ $r -> remembered_at }}</td>
                            <td class="word_id" style="display: none">{{ $r -> word_id }}</td>
                            <td data-label="Operacje">
                                <i class="fas fa-trash danger-small"></i>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $remembered->links('vendor.pagination.custom') }}
        @else
            <section class="no-remembered">
                <h2>Nie zapamiętałeś żadnego słowa!</h2>
                <p>Dodaj je, korzystając z przycisku w trakcie ćwiczenia.</p>
                <a href="{{ url('/profile') }}" class="button">Wróć</a>
            </section>
        @endif
        <article class="dimmer hider">
            <section class="result-box">
                    <h2>Czy na pewno chcesz usunąć słowo <span class="w"></span> z listy?</h2>
                    <form method="POST" action="{{ route('deleteRemembered') }}" autocomplete="OFF">
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
                document.querySelector('#word_id').value = e.path[2].querySelector('.word_id').textContent;
                dimmer_word.textContent = w;
                dimmer.style.display = 'flex';
            });
        });

        document.querySelector('.reverse-color').addEventListener('click', () => {
            dimmer.style.display = 'none';
        })
    </script>
@endsection
