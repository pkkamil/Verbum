<article class="welcome">
    <section class="welcome-text">
        @guest
            <h4>Dołącz do nas i ucz się słownictwa!</h4>
            <a href="{{ route('login') }}" class="button">Dołącz</a>
        @else
            <h4>Kontunuuj swoją naukę angielskiego!</h4>
            <a href="{{ url('/exercises') }}" class="button">Ćwicz</a>
        @endif
    </section>
    <i class="fas fa-arrow-circle-down down"></i>
</article>
