<?php
    $active = 'profile';
    $title = 'Verbum - Profil';
    $lazy = true;
?>

@extends('layouts.app')
@section('content')
<article class="profile">
    <h2>Cześć, {{ explode(" ", Auth::user() -> name)[0] }}!</h2>
    <section class="top-part">
        <div class="single-chart">
            <h4>Dodałeś łącznie: {{ Auth::user() -> words }} słów <span class="gray" style="color: #c4c4c4">({{ floor(Auth::user() -> words / count(\App\Word::all())*100) }}%)</span></h4>
            @if ($data)
                <div id="chart1"></div>
                <p>Ostatnie 3 tygodnie</p>
            @else
                <p>Nie wystarczająca ilość danych do stworzenia diagramu</p>
            @endif
            <a href="{{ url('/ranking/add') }}" class="button">Ranking</a>
        </div>
        <div class="single-chart">
            <h4>Uzyskałeś łącznie: {{ Auth::user() -> exercises -> matching + Auth::user() -> exercises -> writing }} punktów z ćwiczeń</h4>
            @if ($data)
                <div id="chart2"></div>
                <p>Ostatnie 3 tygodnie</p>
            @else
                <p>Nie wystarczająca ilość danych do stworzenia diagramu</p>
            @endif
            <a href="{{ url('/ranking/exercise') }}" class="button">Ranking</a>
        </div>
        <div class="single-chart">
            <h4>Powtórzyłeś łącznie: {{ Auth::user() -> exercises -> translation }} słów <span class="gray" style="color: #c4c4c4">({{ floor(Auth::user() -> exercises -> translation / count(\App\Word::all())*100) }}%)</span></h4>
            @if ($data)
                <div id="chart3"></div>
                <p>Ostatnie 3 tygodnie</p>
            @else
                <p>Nie wystarczająca ilość danych do stworzenia diagramu</p>
            @endif
            <a href="{{ url('/ranking/repeat') }}" class="button">Ranking</a>
        </div>
    </section>
    <section class="bottom-part">
        <div class="single-form">
            @if (Auth::user() -> role == 'User')
                <h4>Zmień swoje imie i nazwisko</h4>
                <form method="POST" action="{{ route('changeName') }}">
                    @csrf
                    <div class="name-group group">
                        <label for="name"><i class="fas fa-user"></i></label>
                        <input type="text" id="name" name="name" value="{{ Auth::user() -> name }}" required autocomplete="name" placeholder="Imie i nazwisko">
                    </div>
                    <button type="submit">Zmień</button>
                </form>
                <h4>Zarządzaj</h4>
                <a href="{{ url('/profile/remembered') }}" class="button">Zapamiętane słowa</a>
                <a href="{{ url('/profile/sections') }}" class="button">Działy słów</a>
            @else
                <h4>Zarządzaj stroną</h4>
                <a href="{{ url('/admin/users') }}" class="button">Lista użytkowników</a>
                <a href="{{ url('/admin/words') }}" class="button">Lista słów</a>
                <a href="{{ url('/admin/suggestions') }}" class="button"><span class="toHide">Słowa </span>do zatwierdzenia</a>
                <a href="{{ url('/admin/logs') }}" class="button">Dziennik zdarzeń</a>
            @endif
        </div>
        <div class="single-form">
            <h4>Zmień swoje hasło</h4>
            <form method="POST" action="{{ route('changePassword') }}">
                @csrf
                <div class="current-password-group group">
                    <label for="current_password"><i class="fas fa-lock"></i></label>
                    <input type="password" id="current_password" name="current_password" required autocomplete="current_password" placeholder="Obecne hasło">
                </div>
                <div class="new_password-group group">
                    <label for="new_password"><i class="fas fa-lock"></i></label>
                    <input type="password" id="new_password"  name="new_password" required autocomplete="new_password" placeholder="Nowe hasło">
                </div>
                <div class="confirm_password-group group">
                    <label for="confirm_password"><i class="fas fa-lock"></i></label>
                    <input type="password" id="confirm_password"  name="confirm_password" required autocomplete="confirm_password" placeholder="Potwierdzenie hasła">
                </div>
                <button type="submit">Zmień</button>
            </form>
        </div>
        <div class="single-form">
            <h4>Zgłoś błąd</h4>
            <form method="POST" action="{{ route('reportAnError') }}">
                @csrf
                <div class="type-group group">
                    <label for="type"><i class="fas fa-exclamation-triangle"></i></label>
                    <input type="text" id="type" name="type" placeholder="Rodzaj błędu">
                </div>
                <div class="description-group group">
                    <label for="description"><i class="fas fa-scroll"></i></label>
                    <input type="text" id="description" name="description" placeholder="Opis błędu" maxlength="200">
                </div>
                <button type="submit">Zgłoś</button>
            </form>
        </div>
        <div class="single-form">
            @if (Auth::user() -> role == 'User')
                <h4>Usuń konto</h4>
                <form action="{{ route('deleteAccount') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="delete-group group danger">
                        <label for="delete"><i class="fas fa-trash"></i></label>
                        <input type="text" id="delete" name="delete" placeholder="Usuwam konto">
                    </div>
                    <button class="danger" type="submit">Zatwierdź</button>
                </form>
            @else
                <h4>Korzystaj z innych operacji</h4>
                <a href="{{ url('/admin/reports') }}" class="button">Lista zgłoszeń</a>
                <a href="{{ url('/admin/trash') }}" class="button">Ostatnio usunięte</a>
                <a href="{{ url('/profile/remembered') }}" class="button">Zapamiętane słowa</a>
                <a href="{{ url('/profile/sections') }}" class="button">Działy słów</a>
            @endif
        </div>
    </section>
</article>
@if ($data)
    <!-- Charting library -->
    <script src="https://unpkg.com/chart.js@2.9.3/dist/Chart.min.js"></script>
    <!-- Chartisan -->
    <script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>
    <!-- Charts -->
    <script>
        const chart1 = new Chartisan({
        el: '#chart1',
        url: "http://localhost:8000/charts/profile/1",
        hooks: new ChartisanHooks()
            .legend(false)
            .beginAtZero()
            .minimalist()
            .colors(['#c4c4c4'])
        });
        const chart2 = new Chartisan({
        el: '#chart2',
        url: "http://localhost:8000/charts/profile/2",
        hooks: new ChartisanHooks()
            .legend(false)
            .beginAtZero()
            .minimalist()
            .colors(['#c4c4c4'])
        });
        const chart3 = new Chartisan({
        el: '#chart3',
        url: "http://localhost:8000/charts/profile/3",
        hooks: new ChartisanHooks()
            .legend(false)
            .beginAtZero()
            .minimalist()
            .colors(['#c4c4c4'])
        });
    </script>
@endif
@endsection
