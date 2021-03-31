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
                <th scope="col">ID</th>
                <th scope="col">Imię i nazwisko</th>
                <th scope="col">Adres email</th>
                <th scope="col">Rola</th>
                <th scope="col">Potwierdzony</th>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td data-label="ID">{{ $user -> id }}</td>
                        <td data-label="Imię i nazwisko"><a href="{{ url('/admin/users/'.$user -> id) }}">{{ $user -> name }}</a></td>
                        <td data-label="Adres email">{{ $user -> email }}</td>
                        <td data-label="Rola">{{ $user -> role }}</td>
                        <td>@if ($user -> email_verified_at) Tak @else Nie @endif</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links('vendor.pagination.custom') }}
    </article>
@endsection
