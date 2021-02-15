<article class="welcome">
    <section class="welcome-text">
        @guest
            <h4>Dołącz do nas i ucz się słownictwa!</h4>
            <button><a href="{{ route('login') }}">Dołącz</a></button>
        @else
            <h4>Kontunuuj swoją naukę angielskiego!</h4>
            <button><a href="{{ url('/exercises') }}">Ćwicz</a></button>
        @endif
    </section>
    <i class="fas fa-arrow-circle-down down"></i>
</article>
