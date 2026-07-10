<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Wagyu France — Élevage et viande d’exception' }}</title>

    <meta
        name="description"
        content="{{ $description ?? 'Wagyu France propose une viande Wagyu française d’exception, une boutique pour les particuliers et une réserve dédiée aux professionnels.' }}"
    >

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/site-header.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/theme-toggle.css') }}">

    @stack('styles')
</head>

<body class="{{ $bodyClass ?? '' }}">

@include('partials.site-header')

<main>
    @yield('content')
</main>

@include('partials.cart-drawer')
@include('partials.theme-toggle')
@include('partials.footer')

<script src="{{ asset('assets/js/cart-preview.js') }}" defer></script>
<script src="{{ asset('assets/js/theme-toggle.js') }}" defer></script>
<script src="{{ asset('assets/js/site-header-menu.js') }}" defer></script>

@stack('scripts')
</body>
</html>
