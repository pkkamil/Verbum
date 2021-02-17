<article class="words">
    <section class="search">
        <form action="search" method="GET">
            <input type="text" name="search" id="search" placeholder="wyszukaj słowo">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
    </section>
    <section class="all-words">
        @foreach ($words as $word)
            <section class="single-word">
                <h3>{{ $word -> word}}</h3>
                <p>{{ $word -> translation }}</p>
            </section>
        @endforeach
    </section>
</article>
