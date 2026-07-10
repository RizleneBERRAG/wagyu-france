<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Wagyu France — Élevage et viande Wagyu française' }}</title>
    <meta name="description" content="{{ $description ?? 'Wagyu France propose une viande Wagyu française issue d’un élevage attentif, des pièces sélectionnées et une réserve dédiée aux professionnels.' }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,500;1,600&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/site-header.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/footer.css') }}">

    @stack('styles')
</head>
<body class="{{ $bodyClass ?? '' }}">

@include('partials.site-header')

<main>
    @yield('content')
</main>

@if (! request()->routeIs('boutique'))
    @include('partials.cart-drawer')
@endif

@include('partials.footer')

@if (! request()->routeIs('boutique'))
    <script src="{{ asset('assets/js/cart-preview.js') }}" defer></script>
@endif
<script src="{{ asset('assets/js/site-header-menu.js') }}" defer></script>
@stack('scripts')
</body>
</html>
