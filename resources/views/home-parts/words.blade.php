<article class="words">
    <section class="search">
        <form action="search" method="GET">
            <input type="text" name="search" id="search" placeholder="wyszukaj słowo">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
    </section>
    <section class="all-words">
        @foreach (range(0, 30) as $item)
            <section class="single-word">
                <h3>Apply</h3>
                <p>Dotyczyć, zastosować</p>
            </section>
        @endforeach
    </section>
</article>
