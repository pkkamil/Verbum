<?php
    $active = 'suggestions';
    $title = 'Verbum - Słowa do zatwierdzenia';
    $lazy = true;
?>

@extends('layouts.app')
@section('content')
    <article class="suggestions-list list">
        <table>
            <thead>
                <th>ID</th>
                <th>Słowo</th>
                <th>Autor</th>
                <th>Duplikat</th>
                <th>Data i czas</th>
                <th>Operacje</th>
            </thead>
            <tbody>
                @foreach($suggestions as $suggestion)
                    <tr>
                        <td>{{ $suggestion -> id }}</td>
                        <td>{{ $suggestion -> word }}</td>
                        <td>{{ \App\User::find($suggestion -> user_id) -> name }}</td>
                        <td>@if (\App\Word::where('word', $suggestion -> word)->first()) tak @else nie @endif</td>
                        <td>{{ date('d.m.Y H:i:s', strtotime($suggestion -> added_at)) }}</td>
                        <td>
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
    </article>
@endsection
