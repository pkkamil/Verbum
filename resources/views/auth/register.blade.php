<?php
    $active = 'register';
    $title = 'Verbum - Rejestracja';
    $lazy = true;
?>

@extends('layouts.app')
@section('content')
    <article class="auth register">
        <section class="left-part">
        </section>
        <section class="right-part">
            @if ($errors -> all())
                <div class="errors">
                    @foreach ($errors->all() as $message)
                        <span class="error">{{ $message }}</span>
                    @endforeach
                </div>
            @endif
            <h1>{{ __('Rejestracja') }}</h1>
            <form method="POST" action="{{ route('register') }}" autocomplete="on">
                @csrf
                <div class="name-group group">
                    <label for="name"><i class="fas fa-user"></i></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Imie i nazwisko">
                </div>
                <div class="email-group group">
                    <label for="email"><i class="fas fa-envelope"></i></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Adres email">
                </div>
                <div class="password-group group">
                    <label for="password"><i class="fas fa-lock"></i></label>
                    <input type="password" id="password" name="password" required autocomplete="new-password" placeholder="Hasło">
                </div>
                <div class="confirm-password-group group">
                    <label for="confirm-password"><i class="fas fa-lock"></i></label>
                    <input type="password" id="confirm-password"  name="password_confirmation" required autocomplete="new-password" placeholder="Potwierdzenie hasła">
                </div>
                <button type="submit">Zarejestruj</button>
                <a href="{{ url('auth/google') }}" class="button"><span>Zarejestruj się z </span>Google</a>
                <div class="flex">
                    <a href="{{ route('login') }}">Masz już konto?</a>
                    <a href="{{ route('password.request') }}">Nie pamiętasz hasła?</a>
                </div>
            </form>
        </section>
    </article>
@endsection
