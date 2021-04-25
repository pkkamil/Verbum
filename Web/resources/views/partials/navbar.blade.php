<nav @if ($active != '') class="gray" @endif>
    <input type='checkbox' id="nav" class="hidden">
    <label for="nav" class="nav-btn">
        <i></i>
        <i></i>
        <i></i>
    </label>
    <div class="logo">
        <a href="/">Verbum</a>
    </div>
    <div class="nav-wrapper">
        <ul>
            @if ($active == '')
                <li><a class="link down" href="">Słownik</a></li>
            @else
                <li><a class="down" href="/#slownik">Słownik</a></li>
            @endif
            <li><a @if ($active == 'exercises' && (isset($section_id) && $section_id != 0)) href="{{ url('/exercises/'.$section_id) }}" @else href="/exercises" @endif @if ($active == 'exercises') class="active" @endif>ćwiczenia</a></li>
            <li><a href="/add-word" @if ($active == 'add') class="active" @endif>Dodaj słowo</a></li>
            @guest
                @if ($active == 'register')
                    <li><a @if ($active =='register' ) class="active" @endif href="{{ route('register') }}">Rejestracja</a></li>
                @else
                    <li><a @if ($active =='login' ) class="active" @endif href="{{ route('login') }}">Logowanie</a></li>
                @endif
            @else
                <li><a href="/profile" @if ($active == 'profile') class="active" @endif>Profil</a></li>
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
