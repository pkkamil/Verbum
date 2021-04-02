<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="description" content="Witryna internetowa ułatwiająca naukę słownictwa w języku angielskim. Strona zapewnia zarówno słownik jak i ćwiczenia utrwalające słownictwo." />
    <meta name="keywords" content="Verbum, słownik, angielski, polski" />
    <meta name="apple-mobile-web-app-title" content="Verbum"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href={{ asset("../favicon.ico")}} />
    <link rel="apple-touch-icon" sizes="256x256" href={{ asset("../favicon.ico") }} />
    <link rel="apple-touch-startup-image" href={{ asset("../favicon.ico") }} />

    <!-- Open Graph -->
    <meta property="og:title" content="Verbum - nauka słownictwa w języku angielskim" />
    <meta property="og:description" content="Witryna internetowa ułatwiająca naukę słownictwa w języku angielskim. Strona zapewnia zarówno słownik jak i ćwiczenia utrwalające słownictwo." />
    <meta property="og:type" content="website" />
    <meta property="og:image" content={{ asset("../favicon.ico") }} />
    <meta property="og:url" content="http://www.verbum.me" />
    <meta property="og:site_name" content="verbum" />

    <title>{{ $title ?? 'Verbum - Nauka Słownictwa' }}</title>

    <!-- Canonical link -->
    <link rel="canonical" href="http://www.verbum.me" />

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>
    @if ($active == '')
        <script src="{{ asset('js/scroll.js') }}" defer></script>
    @endif
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/95a2d2c3f2.js" crossorigin="anonymous"></script>

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
    <body>
        @if ($navbar ?? true)
            @include('partials.navbar')
        @endif
        @if ($lazy ?? '' == True)
            <div class="loader-wrapper">
                <span class="loader"><span class="loader-inner"></span></span>
            </div>
            <script>
                $(window).on("load",function(){
                $(".loader-wrapper").fadeOut(700);
                });
            </script>
        @endif
        @yield('content')
        @include('partials.footer')
    </body>
</html>
