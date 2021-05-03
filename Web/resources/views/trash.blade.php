<?php
    $active = 'trash';
    $title = 'Verbum - Ostatnio usunięte';
    $lazy = true;
?>

@extends('layouts.app')
@section('content')
    <article class="trash-list list">
        @if (count($trash) > 0)
            <table>
                <thead>
                    <th scope="col">#</th>
                    <th scope="col">Słowo</th>
                    <th scope="col">Rodzaj</th>
                    <th scope="col">Operacje</th>
                </thead>
                <tbody>
                    @foreach($trash as $t)
                        <tr>
                            <td data-label="#">{{ ($loop -> index + 1) + ($trash -> links() -> paginator -> currentPage() - 1) * $trash -> links() -> paginator -> perPage() }}</td>
                            <td class="id" style="display: none">{{ $t -> id }}</td>
                            <td class="translation" style="display: none">{{ $t -> translation }}</td>
                            <td data-label="Słowo">{{ $t -> word }}</td>
                            <td data-label="Rodzaj">{{ $t -> type == 'suggestion' ? 'Sugestia' : 'Słowo' }}</td>
                            <td data-label="Operacje">
                                <i class="fas fa-undo undo"></i>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $trash->links('vendor.pagination.custom') }}
        @else
            <section class="empty-trash">
                <h2>Wróć tutaj później!</h2>
                <p>Nie ma żadnych ostatnio usuniętych słów lub sugestii.</p>
                <a href="{{ url('/profile') }}" class="button">Wróć</a>
            </section>
        @endif
        <article class="dimmer hider">
            <section class="result-box">
                    <h2>Czy na pewno chcesz przywrócić <span class="t">słowo</span> <span class="w"></span>?</h2>
                    <p>Tłumaczenie: <span class="translation-span"></span></p>
                    <form method="POST" action="{{ route('undo') }}" autocomplete="OFF">
                        @csrf
                        <input type="hidden" name="item_id" id="item_id" value="">
                        <button type="submit" class="success">Przywróć</button>
                        <button type="button" class="reverse-color">Anuluj</button>
                    </form>
            </section>
        </article>
    </article>
    <script>
        let clicks = document.querySelectorAll('.undo');
        let dimmer = document.querySelector('.dimmer');
        let dimmer_word = dimmer.querySelector('.w');
        let dimmer_type = dimmer.querySelector('.t');

        clicks.forEach(click => {
            click.addEventListener('click', (e) => {
                let w = e.path[2].querySelector('td:nth-child(4)').textContent;
                let t = e.path[2].querySelector('td:nth-child(5)').textContent;
                document.querySelector('.translation-span').textContent = e.path[2].querySelector('.translation').textContent;
                if (t == 'Sugestia')
                    dimmer_type.textContent = 'sugestię';
                else
                    dimmer_type.textContent = t;
                document.querySelector('#item_id').value = e.path[2].querySelector('td:nth-child(2)').textContent;
                dimmer_word.textContent = w;
                dimmer.style.display = 'flex';
            });
        });

        document.querySelector('.reverse-color').addEventListener('click', () => {
            dimmer.style.display = 'none';
        })
    </script>
@endsection
