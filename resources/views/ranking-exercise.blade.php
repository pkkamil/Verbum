<?php
    $active = 'ranking';
    $title = 'Verbum - Ranking uzyskanych punktów';
    $lazy = true;
?>

@extends('layouts.app')
@section('content')
<article class="ranking exercising">
    <section class="left-part">
        <h2>Największa ilość uzyskanych punktów</h2>
        <table class="ranks">
            <tbody>
                @foreach($ranking as $rank)
                    <tr>
                        <td>{{ $loop -> index+1 }}</td>
                        <td>{{ \App\User::find($rank -> user_id) -> name }}</td>
                        <td>{{ $rank -> writing + $rank -> matching }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
    <section class="right-part"></section>
</article>
@endsection
