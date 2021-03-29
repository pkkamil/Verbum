<?php
    $active = 'ranking';
    $title = 'Verbum - Ranking dodanych słów';
    $lazy = true;
?>

@extends('layouts.app')
@section('content')
<article class="ranking add">
    <section class="left-part">
        <h2>Największa ilość dodanych słów</h2>
        <table class="ranks">
            <tbody>
                @foreach($ranking as $rank)
                    <tr>
                        <td>{{ $loop -> index+1 }}</td>
                        <td>{{ $rank -> name }}</td>
                        <td>{{ $rank -> words }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
    <section class="right-part"></section>
</article>
@endsection
