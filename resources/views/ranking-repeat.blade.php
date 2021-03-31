<?php
    $active = 'ranking';
    $title = 'Verbum - Ranking powtórzonych słów';
    $lazy = true;
?>

@extends('layouts.app')
@section('content')
<article class="ranking repeat">
    <section class="left-part">
        <h2>Największa ilość powtórzonych słów</h2>
        <table class="ranks">
            <tbody>
                @foreach($ranking as $rank)
                    <tr>
                        <td>{{ ($loop -> index + 1) + ($ranking -> links() -> paginator -> currentPage() - 1) * $ranking -> links() -> paginator -> perPage() }}</td>
                        <td>{{ \App\User::find($rank -> user_id) -> name }}</td>
                        <td>{{ $rank -> translation }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $ranking->links('pagination::simple-custom') }}
    </section>
    <section class="right-part"></section>
</article>
@endsection
