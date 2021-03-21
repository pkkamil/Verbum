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
                <th>ID</th>
                <th>Słowo</th>
                <th>Tłumaczenie</th>
                <th>Operacje</th>
            </thead>
            <tbody>
                @foreach($words as $word)
                    <tr>
                        <td>{{ $word -> id }}</td>
                        <td>{{ $word -> word }}</td>
                        <td><p>{{ $word -> translation }}</p></td>
                        <td>
                            <a href="{{ url('/admin/words/'.$word -> id) }}"><i class="fas fa-eye"></i></a>
                            <a href="{{ url('/admin/words/'.$word -> id.'/delete') }}"><i class="fas fa-trash danger-small"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $words->links() }}
    </article>
@endsection
