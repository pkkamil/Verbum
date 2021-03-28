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
                            <a href="{{ url('/admin/words/'.$word -> id.'/delete') }}"><i class="fas fa-trash danger-small"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $words->links('vendor.pagination.custom') }}
    </article>
@endsection
