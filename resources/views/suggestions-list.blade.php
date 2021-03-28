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
                            <td data-label="Autor">{{ \App\User::find($suggestion -> user_id) -> name }}</td>
                            <td data-label="Duplikat">@if (\App\Word::where('word', $suggestion -> word)->first()) tak @else nie @endif</td>
                            <td data-label="Data i czas">{{ date('d.m.Y H:i:s', strtotime($suggestion -> added_at)) }}</td>
                            <td data-label="Operacje">
                                <a href="{{ url('/admin/suggestions/'.$suggestion -> id) }}"><i class="fas fa-eye"></i></a>
                                @if (\App\Word::where('word', $suggestion -> word)->first())
                                    <p><i class="far fa-check-circle"></i></p>
                                @else
                                    <a href="{{ url('/admin/suggestions/'.$suggestion -> id.'/accept') }}"><i class="far fa-check-circle success-small"></i></a>
                                @endif
                                <a href="{{ url('/admin/suggestions/'.$suggestion -> id.'/delete') }}"><i class="fas fa-trash danger-small"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $suggestions->links() }}
        @else
            <section class="no-suggestions">
                <h2>Wróć tutaj później!</h2>
                <p>Nie ma żadnych nowych słów do zatwierdzenia.</p>
                <a href="{{ url('/profile') }}" class="button">Wróć</a>
            </section>
        @endif
    </article>
@endsection
