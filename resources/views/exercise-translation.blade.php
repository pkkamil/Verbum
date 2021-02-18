<?php
    $active = 'exercises';
    $title = 'Verbum - Ćwiczenia | Tłumaczenie';
?>

@extends('layouts.app')
@section('content')
    <article class="exercise translation">
        <h4>Pozostały czas: 10</h4>
        <h2>Ridiculous</h2>
        <h3 class="tn">Bezsensowny, absurdalny, niepoważny</h3>
        <form action="{{ route('rememberWord') }}" method="POST"">
            @csrf
            <input type="hidden" name="word" value="ridiculous">
            <button type="submit">Znam to słowo</button>
        </form>
    </article>
@endsection
