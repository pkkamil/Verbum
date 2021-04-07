<?php
    $active = 'reports-list';
    $title = 'Verbum - Lista zgłoszeń';
    $lazy = true;
?>

@extends('layouts.app')
@section('content')
    <article class="reports-list list">
        @if (count($reports) > 0)
            <table>
                <thead>
                    <th scope="col">#</th>
                    <th scope="col">Rodzaj</th>
                    <th scope="col">Dodany przez</th>
                    <th scope="col">Operacje</th>
                </thead>
                <tbody>
                    @foreach($reports as $r)
                        <tr>
                            <td data-label="#">{{ ($loop -> index + 1) + ($reports -> links() -> paginator -> currentPage() - 1) * $reports -> links() -> paginator -> perPage() }}</td>
                            <td data-label="Rodzaj">{{ $r -> type }}</td>
                            <td class="description" style="display: none;">{{ $r -> description }}</td>
                            <td data-label="Dodany przez">{{ \App\User::find($r -> user_id) -> name }}</td>
                            <td class="report_id" style="display: none">{{ $r -> id }}</td>
                            <td data-label="Operacje">
                                <i class="fas fa-eye details"></i>
                                <i class="fas fa-trash danger-small"></i>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $reports->links('vendor.pagination.custom') }}
        @else
            <section class="no-reports">
                <h2>Wróć tutaj później!</h2>
                <p>Nie ma żadnych nowych raportów do przeczytania.</p>
                <a href="{{ url('/profile') }}" class="button">Wróć</a>
            </section>
         @endif
         <article class="dimmer dimmer-details hider">
            <section class="result-box">
                    <h2>Szczegóły raportu&nbsp;o&nbsp;ID&nbsp;<span class="w"></span></h2>
                    <p class="details-paragraph"></p>
                    <button type="button" class="reverse-color">Wróć</button>
            </section>
        </article>
        <article class="dimmer dimmer-delete hider">
            <section class="result-box">
                    <h2>Czy na pewno chcesz usunąć raport&nbsp;o&nbsp;ID&nbsp;<span class="w"></span>?</h2>
                    <form method="POST" action="{{ route('deleteReport') }}" autocomplete="OFF">
                        @csrf
                        <input type="hidden" name="report_id" id="report_id" value="">
                        <button type="submit" class="danger">Usuń</button>
                        <button type="button" class="reverse-color">Anuluj</button>
                    </form>
            </section>
        </article>
    </article>
    <script>
        let details = document.querySelectorAll('.details');
        let dangers = document.querySelectorAll('.danger-small');
        let dimmer_details = document.querySelector('.dimmer-details');
        let dimmer_delete = document.querySelector('.dimmer-delete');
        let dimmer_ID_delete = dimmer_delete.querySelector('.w');
        let dimmer_ID_details = dimmer_details.querySelector('.w');

        details.forEach(click => {
            click.addEventListener('click', (e) => {
                let w = e.path[2].querySelector('td:nth-child(1)').textContent;
                document.querySelector('.details-paragraph').textContent = e.path[2].querySelector('.description').textContent;
                dimmer_ID_details.textContent = w;
                dimmer_details.style.display = 'flex';
            });
        });

        dangers.forEach(click => {
            click.addEventListener('click', (e) => {
                let w = e.path[2].querySelector('td:nth-child(1)').textContent;
                document.querySelector('#report_id').value = e.path[2].querySelector('.report_id').textContent;
                dimmer_ID_delete.textContent = w;
                dimmer_delete.style.display = 'flex';
            });
        });

        document.querySelectorAll('.reverse-color').forEach(e => {
            e.addEventListener('click', () => {
                if (dimmer_delete.style.display == 'flex')
                    dimmer_delete.style.display = 'none';
                else
                    dimmer_details.style.display = 'none';
            })
        })

    </script>
@endsection
