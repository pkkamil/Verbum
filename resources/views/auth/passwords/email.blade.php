<?php
    $active = 'login';
    $title = 'Verbum - Przypomnienie hasła';
?>

@extends('layouts.app')
@section('content')
    <article class="auth remember">
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
            <h1>{{ __('Przypomnij hasło') }}</h1>
            <form method="POST" action="{{ route('password.email') }}" autocomplete="on">
                @csrf
                <div class="email-group group">
                    <label for="email"><i class="fas fa-envelope"></i></label>
                    <input type="email" id="email" name="email" placeholder="Adres email">
                </div>
                <button type="submit">Przypomnij</button>
                <a href="{{ route('register') }}">Nie maasz jeszcze konta?</a>
                <a href="{{ route('login') }}">Masz już konto?</a>
            </form>
        </section>
    </article>
@endsection
