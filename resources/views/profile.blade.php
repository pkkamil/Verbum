<?php
    $active = 'profile';
    $title = 'Verbum - Profil';
?>

@extends('layouts.app')
@section('content')
<article class="profile">
    <h2>Cześć, {{ Auth::user() -> name }}</h2>
    <section class="top-part">
        <div class="single-chart">
            <h4>Dodałeś łącznie: 329 słów (51%)</h4>
            <div id="chart1"></div>
            <p>Ostatnie 3 tygodnie</p>
            <a href="{{ url('/ranking') }}">Ranking</a>
        </div>
        <div class="single-chart">
            <h4>Wykonałeś łącznie: 25 ćwiczeń</h4>
            <div id="chart2"></div>
            <p>Ostatnie 3 tygodnie</p>
            <a href="{{ url('/ranking') }}">Ranking</a>
        </div>
        <div class="single-chart">
            <h4>Powtórzyłeś łącznie: 341 słów (53%)</h4>
            <div id="chart3"></div>
            <p>Ostatnie 3 tygodnie</p>
            <a href="{{ url('/ranking') }}">Ranking</a>
        </div>
    </section>
    <section class="bottom-part">
        <div class="single-form">
            <h4>Zmień swoje imie i nazwisko</h4>
            <form method="POST" action="{{ route('changeName') }}">
                @csrf
                <div class="name-group group">
                    <label for="name"><i class="fas fa-user"></i></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Imie i nazwisko">
                </div>
                <button type="submit">Zmień</button>
            </form>
        </div>
        <div class="single-form">
            <h4>Zmień swoje hasło</h4>
            <form method="POST" action="{{ route('changePassword') }}">
                @csrf
                <div class="current-password-group group">
                    <label for="current-password"><i class="fas fa-lock"></i></label>
                    <input type="password" id="current-password" name="current-password" required autocomplete="current-password" placeholder="Obecne hasło">
                </div>
                <div class="new-password-group group">
                    <label for="new-password"><i class="fas fa-lock"></i></label>
                    <input type="password" id="new-password"  name="new-password" required autocomplete="new-password" placeholder="Nowe hasło">
                </div>
                <div class="confirm-password-group group">
                    <label for="confirm-password"><i class="fas fa-lock"></i></label>
                    <input type="password" id="confirm-password"  name="confirm-password" required autocomplete="new-password" placeholder="Potwierdzenie hasła">
                </div>
                <button type="submit">Zmień</button>
            </form>
        </div>
        <div class="single-form">
            <h4>Zgłoś błąd</h4>
            <form method="POST" action="{{ route('reportAnError') }}">
                @csrf
                <div class="error-type-group group">
                    <label for="error-type"><i class="fas fa-exclamation-triangle"></i></label>
                    <input type="text" id="error-type" name="error-type" placeholder="Rodzaj błędu">
                </div>
                <div class="error-description-group group">
                    <label for="error-description"><i class="fas fa-scroll"></i></label>
                    <input type="text" id="error-description" name="error-description" placeholder="Opis błędu">
                </div>
                <button type="submit">Zgłoś</button>
            </form>
        </div>
        <div class="single-form">
            <h4>Usuwanie konta</h4>
            <form action="{{ route('deleteAccount') }}" method="POST">
                @csrf
                <div class="delete-account-group group danger">
                    <label for="delete-account"><i class="fas fa-trash"></i></label>
                    <input type="text" id="delete-account" name="delete-account" placeholder="Usuwam konto">
                </div>
                <button class="danger" type="submit">Zatwierdź</button>
            </form>
        </div>
    </section>
</article>
@endsection
