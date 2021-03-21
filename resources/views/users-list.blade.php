<?php
    $active = 'users-list';
    $title = 'Verbum - Lista użytkowników';
    $lazy = true;
?>

@extends('layouts.app')
@section('content')
    <article class="users-list list">
        <table>
            <thead>
                <th>ID</th>
                <th>Imię i nazwisko</th>
                <th>Adres email</th>
                <th>Rola</th>
                <th>Potwierdzony</th>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user -> id }}</td>
                        <td><a href="{{ url('/admin/users/'.$user -> id) }}">{{ $user -> name }}</a></td>
                        <td>{{ $user -> email }}</td>
                        <td>{{ $user -> role }}</td>
                        <td>@if ($user -> email_verified_at) Tak @else Nie @endif</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </article>
@endsection
