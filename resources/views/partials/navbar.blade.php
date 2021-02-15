<nav>
    <input type='checkbox' id="nav" class="hidden">
    <label for="nav" class="nav-btn">
        <i></i>
        <i></i>
        <i></i>
    </label>
    <div class="logo">
        <a href="/#">Verbum</a>
    </div>
    <div class="nav-wrapper">
        <ul>
            <li><a class="down" href="">Słownik</a></li>
            <li><a href="/exercises">ćwiczenia</a></li>
            <li><a href="/add">Dodaj słowo</a></li>
            @guest
                @if ($active == 'register')
                    <li><a @if ($active =='register' ) class="active" @endif href="{{ route('register') }}">Rejestracja</a></li>
                @else
                    <li><a @if ($active =='login' ) class="active" @endif href="{{ route('login') }}">Logowanie</a></li>
                @endif
            @else
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Wyloguj') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                </li>
            @endguest
            </ul>
        </div>
    </nav>
