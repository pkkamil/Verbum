<article class="words">
    <section class="search">
        <form action="{{route('searchWords')}}" method="POST">
            @csrf
            <input type="text" name="q" id="search" placeholder="wyszukaj słowo" @if (isset($q)) value="{{ $q }}" @endif>
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
    </section>
    <section class="all-words">
        @if (count($words) != 0)
            @foreach ($words as $word)
                <section class="single-word">
                    <h3>{{ $word -> word}}</h3>
                    <p>{{ $word -> translation }}</p>
                </section>
            @endforeach
        @else
            <h2 class="null">Nie znaleziono żadnego słowa o&nbsp;podanej frazie!</h2>
        @endif
    </section>
</article>
