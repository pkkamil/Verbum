<?php
    $active = 'login';
    $title = 'Verbum - Logowanie';
    $lazy = true;
?>

@extends('layouts.app')
@section('content')
    <article class="auth login">
        <section class="left-part">
            @if ($errors -> all())
                <div class="errors">
                    @foreach ($errors->all() as $message)
                        <span class="error">{{ $message }}</span>
                    @endforeach
                </div>
            @endif
            <h1>{{ __('Logowanie') }}</h1>
            <form method="POST" action="{{ route('login') }}" autocomplete="on">
                @csrf
                <div class="email-group group">
                    <label for="email"><i class="fas fa-envelope"></i></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="adres email">
                </div>
                <div class="password-group group">
                    <label for="password"><i class="fas fa-lock"></i></label>
                    <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="Hasło">
                </div>
                <button type="submit">Zaloguj</button>
                <a href="{{ url('auth/google') }}" class="button"><span>Zaloguj się z </span>Google</a>
                <div class="flex">
                    <a href="{{ route('register') }}">Nie masz jeszcze konta?</a>
                    <a href="{{ route('password.request') }}">Nie pamiętasz hasła?</a>
                </div>
            </form>
        </section>
        <section class="right-part">
        </section>
    </article>
@endsection
