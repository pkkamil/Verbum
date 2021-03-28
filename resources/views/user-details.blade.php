<?php
    $active = 'user';
    $title = 'Verbum - Lista użytkowników | '.$user -> id;
    $lazy = true;
?>

@extends('layouts.app')
@section('content')
    <article class="user-details">
        <a href="{{ url('/admin/users') }}" class="button back">Wróć</a>
        <section class="informations">
            <h3>Ten użytkownik ma na imię i nazwisko <b>{{ $user -> name }}</b>.</h3>
            <h3>Jego adres email prezentuje się następująco: <b>{{ $user -> email }}</b>.</h3>
            @if ($user -> role == 'User')
                <h3>Pełni on rolę zwykłego uzytkownika.</h3>
            @else
                <h3>Pełni on rolę administratora.</h3>
            @endif
            <h3>Przynależy on do tej strony od <b>{{ date('d.m.Y H:i:s', strtotime($user -> created_at)) }}</b>.</h3>
            @if ($user -> email_verified_at)
                <h3>Jego konto <b>zostało</b> potwierdzone.</h3>
            @else
                <h3>Jego konto <b>nie zostało jeszcze</b> potwierdzone.</h3>
            @endif
        </section>
        <section class="top-part">
            <div class="single-chart">
                <h4>Dodał łącznie: {{ Auth::user() -> words }} słów <span class="gray" style="color: #c4c4c4">({{ floor(Auth::user() -> words / count(\App\Word::all())*100) }}%)</span></h4>
                <div id="chart1"></div>
                <p>Ostatnie 3 tygodnie</p>
            </div>
            <div class="single-chart">
                <h4>Uzyskał łącznie: {{ Auth::user() -> exercises -> matching + Auth::user() -> exercises -> writing }} punktów z ćwiczeń</h4>
                <div id="chart2"></div>
                <p>Ostatnie 3 tygodnie</p>
            </div>
            <div class="single-chart">
                <h4>Powtórzył łącznie: {{ Auth::user() -> exercises -> translation }} słów <span class="gray" style="color: #c4c4c4">({{ floor(Auth::user() -> exercises -> translation / count(\App\Word::all())*100) }}%)</span></h4>
                <div id="chart3"></div>
                <p>Ostatnie 3 tygodnie</p>
            </div>
        </section>
        <section class="bottom-part">
            <div class="single-form">
                <h4>Zmień imie i nazwisko użytkownika</h4>
                <form method="POST" action="{{ route('changeUserName') }}">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" value="{{ $user -> id }}">
                    <div class="name-group group">
                        <label for="name"><i class="fas fa-user"></i></label>
                        <input type="text" id="name" name="name" value="{{ $user -> name }}" required autocomplete="name" placeholder="Imie i nazwisko">
                    </div>
                    <button type="submit">Zmień</button>
                </form>
            </div>
            <div class="single-form">
                <h4>Zmień adres email użytkownika</h4>
                <form method="POST" action="{{ route('changeUserEmail') }}">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" value="{{ $user -> id }}">
                    <div class="email-group group">
                        <label for="email"><i class="fas fa-envelope"></i></label>
                        <input type="email" id="email" name="email" value="{{ $user -> email }}" required autocomplete="email" placeholder="Adres email">
                    </div>
                    <button type="submit">Zmień</button>
                </form>
            </div>
            <div class="single-form">
                <h4>Usuń użytkownika</h4>
                <form action="{{ route('deleteUserAccount') }}" method="POST" autocomplete="off">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" value="{{ $user -> id }}">
                    <div class="delete-group group danger">
                        <label for="delete"><i class="fas fa-trash"></i></label>
                        <input type="text" id="delete" name="delete" placeholder="Usuwam użytkownika">
                    </div>
                    <button class="danger" type="submit">Zatwierdź</button>
                </form>
            </div>
        </section>
    </article>
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
@endsection
