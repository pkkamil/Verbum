<?php
    $active = 'logs';
    $title = 'Verbum - Dziennik zdarzeń';
    $lazy = True;
?>

@extends('layouts.app')
@section('content')
    <article class="logs-list list">
        @if (count($logs) > 0)
        <table>
            <thead>
                <th scope="col">Opis zdarzenia</th>
                <th scope="col">Data</th>
            </thead>
            <tbody>
                @foreach($logs as $l)
                    <tr>
                        @if ($l -> type == 1)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> dołączył do naszej witrymy</td>
                        @elseif ($l -> type == 2)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> zalogował się</td>
                        @elseif ($l -> type == 3)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> wylogował się</td>
                        @elseif ($l -> type == 4)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> zapomniał swoje hasło</td>
                        @elseif ($l -> type == 5)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> dodał nowe słowo do zatwierdzenia <b>@if (\App\Suggestion::find($l -> type_id)) {{ \App\Suggestion::find($l -> type_id) -> word}}@else nieznane @endif <span class="grey">[{{ $l -> type_id }}]</span></b></td>
                        @elseif ($l -> type == 6)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> zaakceptował nowe słowo <b>@if (\App\Word::find($l -> type_id)) {{ \App\Word::find($l -> type_id) -> word}}@else nieznane @endif <span class="grey">[{{ $l -> type_id }}]</span></b></td>
                        @elseif ($l -> type == 7)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> zamienił słowo <b>@if (\App\word::find($l -> type_id)) {{ \App\word::find($l -> type_id) -> word}}@else nieznane @endif <span class="grey">[{{ $l -> type_id }}]</span></b></td>
                        @elseif ($l -> type == 8)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> zedytował słowo do zatwierdzenia <b>@if (\App\Suggestion::find($l -> type_id)) {{ \App\Suggestion::find($l -> type_id) -> word}}@else nieznane @endif <span class="grey">[{{ $l -> type_id }}]</span></b></td>
                        @elseif ($l -> type == 9)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> usunął słowo do zatwierdzenia <b>@if (\App\Suggestion::find($l -> type_id)) {{ \App\Suggestion::find($l -> type_id) -> word}}@else nieznane @endif <span class="grey">[{{ $l -> type_id }}]</span></b></td>
                        @elseif ($l -> type == 10)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> przywrócił usuniętą sugestię <b>@if (\App\Suggestion::find($l -> type_id)) {{ \App\Suggestion::find($l -> type_id) -> word}}@else nieznane @endif <span class="grey">[{{ $l -> type_id }}]</span></b></td>
                        @elseif ($l -> type == 11)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> zedytował słowo <b>@if (\App\Word::find($l -> type_id)) {{ \App\Word::find($l -> type_id) -> word}}@else nieznane @endif <span class="grey">[{{ $l -> type_id }}]</span></b></td>
                        @elseif ($l -> type == 12)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> usunął słowo <b>@if (\App\Word::find($l -> type_id)) {{ \App\Word::find($l -> type_id) -> word}}@else nieznane @endif <span class="grey">[{{ $l -> type_id }}]</span></b></td>
                        @elseif ($l -> type == 13)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> przywrócił usunięte słowo <b>@if (\App\Word::find($l -> type_id)) {{ \App\Word::find($l -> type_id) -> word}}@else nieznane @endif <span class="grey">[{{ $l -> type_id }}]</span></b></td>
                        @elseif ($l -> type == 14)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> dodał nowe zgłoszenie <b>@if (\App\Report::find($l -> type_id)) {{ \App\Report::find($l -> type_id) -> type}}@else nieznane @endif <span class="grey">[{{ $l -> type_id }}]</span></b></td>
                        @elseif ($l -> type == 15)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> usunął zgłoszenie <b>@if (\App\Report::find($l -> type_id)) {{ \App\Report::find($l -> type_id) -> type}}@else nieznane @endif <span class="grey">[{{ $l -> type_id }}]</span></b></td>
                        @elseif ($l -> type == 16)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> zapamiętał nowe słowo <b>@if (\App\Word::find($l -> type_id)) {{ \App\Word::find($l -> type_id) -> word}}@else nieznane @endif <span class="grey">[{{ $l -> type_id }}]</span></b></td>
                        @elseif ($l -> type == 17)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> usunął zapamiętane słowo <b>@if (\App\Word::find($l -> type_id)) {{ \App\Word::find($l -> type_id) -> word}}@else nieznane @endif <span class="grey">[{{ $l -> type_id }}]</span></b></td>
                        @elseif ($l -> type == 18)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> utworzył nowy dział <b>@if (\App\Section::find($l -> type_id)) {{ \App\Section::find($l -> type_id) -> name}}@else nieznane @endif <span class="grey">[{{ $l -> type_id }}]</span></b></td>
                        @elseif ($l -> type == 19)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> zedytował dział <b>@if (\App\Section::find($l -> type_id)) {{ \App\Section::find($l -> type_id) -> name}}@else nieznane @endif <span class="grey">[{{ $l -> type_id }}]</span></b></td>
                        @elseif ($l -> type == 20)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> usunął dział <b>@if (\App\Section::find($l -> type_id)) {{ \App\Section::find($l -> type_id) -> name}}@else nieznane @endif <span class="grey">[{{ $l -> type_id }}]</span></b></td>
                        @elseif ($l -> type == 21)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> ćwiczył <b>dopasowywanie słów</b></td>
                        @elseif ($l -> type == 22)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> ćwiczył <b>pisownie słów</b></td>
                        @elseif ($l -> type == 23)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> zmienił <b>swoje hasło</b></td>
                        @elseif ($l -> type == 24)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> zmienił <b>adres email</b></td>
                        @elseif ($l -> type == 25)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> zmienił <b>swoją nazwę użytkownika</b></td>
                        @elseif ($l -> type == 26)
                            <td data-label="Opis zdarzenia">Użytkownik <b>Gość <span class="grey">[{{ $l -> user_id }}]</span></b> usunął <b>swoje konto</b></td>
                        @elseif ($l -> type == 27)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> zmienił adres email użytkownika  <b>@if (\App\User::find($l -> type_id)){{ \App\User::find($l -> type_id) -> name }}@else Gość @endif<span class="grey"> [{{ $l -> type_id }}]</span></b></td>
                        @elseif ($l -> type == 28)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> zmienił nazwę użytkownika <b>@if (\App\User::find($l -> type_id)){{ \App\User::find($l -> type_id) -> name }}@else Gość @endif<span class="grey"> [{{ $l -> type_id }}]</span></b></td>
                        @elseif ($l -> type == 29)
                            <td data-label="Opis zdarzenia">Użytkownik <b>@if (\App\User::find($l -> user_id)){{ \App\User::find($l -> user_id) -> name }}@else Gość @endif <span class="grey">[{{ $l -> user_id }}]</span></b> usunął konto użytkownika <b>Gość <span class="grey">[{{ $l -> type_id }}]</span></b></td>
                        @endif
                        <td data-label="Data">{{ date('d.m.Y H:i:s', strtotime($l -> date)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $logs->links('vendor.pagination.custom') }}
    @else
        <section class="no-logs">
            <h2>Dziennik jest pusty!</h2>
            <p>Dziennik zdarzeń nie zawiera żadnych zdarzeń.</p>
            <a href="{{ url('/profile') }}" class="button">Wróć</a>
        </section>
     @endif
    </article>
@endsection
