<?php
    $active = 'sections';
    $title = 'Verbum - Działy słów';
    $lazy = true;
?>

@extends('layouts.app')
@section('content')
    <article class="sections-list list">
        @if (count($sections) > 0)
            <table>
                <thead>
                    <th scope="col">#</th>
                    <th scope="col">Nazwa</th>
                    <th scope="col">Data i czas utworzenia</th>
                    <th scope="col">Operacje</th>
                </thead>
                <tbody>
                    @foreach($sections as $section)
                        <tr>
                            <td data-label="#">{{ ($loop -> index + 1) + ($sections -> links() -> paginator -> currentPage() - 1) * $sections -> links() -> paginator -> perPage() }}</td>
                            <td class="id" style="display: none">{{ $section -> id }}</td>
                            <td data-label="Słowo">{{ $section -> name }}</td>
                            <td data-label="Data i czas">{{ date('d.m.Y H:i:s', strtotime($section -> created_at)) }}</td>
                            <td data-label="Operacje">
                                <a href="{{ url('/profile/sections/'.$section -> id) }}"><i class="fas fa-eye"></i></a>
                                <a href="{{ url('/profile/sections/'.$section -> id.'/edit') }}"><i class="fas fa-edit"></i></a>
                                <i class="fas fa-trash danger-small"></i>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $sections->links('vendor.pagination.custom') }}
        @else
            <section class="no-sections">
                <h2>Nie masz żadnych utworzonych działów!</h2>
                <p>Działy umożliwią Ci grupowanie słów według własnych zachcianek.</p>
                <div class="operations">
                    <a href="{{ url('/profile/section/create') }}" class="button">Utwórz dział</a>
                    <a href="{{ url('/profile') }}" class="button">Wróć</a>
                </div>
            </section>
        @endif
        <article class="dimmer hider">
            <section class="result-box">
                    <h2>Czy na pewno chcesz usunąć dział: <span class="s"></span>?</h2>
                    <form method="POST" action="{{ route('deleteSection') }}" autocomplete="OFF">
                        @csrf
                        <input type="hidden" name="section_id" id="section_id" value="">
                        <button type="submit" class="danger">Usuń</button>
                        <button type="button" class="reverse-color">Anuluj</button>
                    </form>
            </section>
        </article>
    </article>
    <script>
        let clicks = document.querySelectorAll('.danger-small');
        let dimmer = document.querySelector('.dimmer');
        let dimmer_section = dimmer.querySelector('.s');

        clicks.forEach(click => {
            click.addEventListener('click', (e) => {
                let s = e.path[2].querySelector('td:nth-child(3)').textContent;
                document.querySelector('#section_id').value = e.path[2].querySelector('td:nth-child(2)').textContent;
                dimmer_section.textContent = s;
                dimmer.style.display = 'flex';
            });
        });

        document.querySelector('.reverse-color').addEventListener('click', () => {
            dimmer.style.display = 'none';
        })
    </script>
@endsection
