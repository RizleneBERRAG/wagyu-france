<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Wagyu France — La Réserve' }}</title>

    <meta name="description" content="{{ $description ?? 'Wagyu France, expérience premium autour du Wagyu français, boutique, histoire du domaine et réserve professionnelle.' }}">

    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">

    {{-- Nouveau header + switch Particulier / Pro --}}
    <link rel="stylesheet" href="{{ asset('assets/css/site-header.css') }}">

    {{-- À garder --}}
    <link rel="stylesheet" href="{{ asset('assets/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/theme-toggle.css') }}">

    @stack('styles')
</head>

<body class="{{ $bodyClass ?? '' }}">

@include('partials.site-header')

<main>
    @yield('content')
</main>

{{-- À garder si ton panier global boutique existe déjà --}}
@include('partials.cart-drawer')

{{-- À ne pas toucher --}}
@include('partials.theme-toggle')
@include('partials.footer')

{{-- Nouveau JS switch Particulier / Pro --}}
<script src="{{ asset('assets/js/universe-switch.js') }}" defer></script>

{{-- À garder si ton panier global boutique existe déjà --}}
<script src="{{ asset('assets/js/cart-preview.js') }}" defer></script>

{{-- À ne pas toucher --}}
<script src="{{ asset('assets/js/theme-toggle.js') }}" defer></script>

@stack('scripts')
</body>
</html>
