<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Wagyu France â€” La RÃ©serve' }}</title>

    <meta name="description" content="{{ $description ?? 'Wagyu France, expÃ©rience premium autour du Wagyu franÃ§ais, boutique, histoire du domaine et rÃ©serve professionnelle.' }}">

    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">

    {{-- Nouveau header + switch Particulier / Pro --}}
    <link rel="stylesheet" href="{{ asset('assets/css/site-header.css') }}">

    {{-- Ã€ garder --}}
    <link rel="stylesheet" href="{{ asset('assets/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/theme-toggle.css') }}">

    @stack('styles')
</head>

<body class="{{ $bodyClass ?? '' }}">

@include('partials.site-header')

<main>
    @yield('content')
</main>

{{-- Ã€ garder si ton panier global boutique existe dÃ©jÃ  --}}
@include('partials.cart-drawer')

{{-- Ã€ ne pas toucher --}}
@include('partials.theme-toggle')
@include('partials.footer')

{{-- Nouveau JS switch Particulier / Pro --}}
<script src="{{ asset('assets/js/universe-switch.js') }}" defer></script>

{{-- Ã€ garder si ton panier global boutique existe dÃ©jÃ  --}}
<script src="{{ asset('assets/js/cart-preview.js') }}" defer></script>

{{-- Ã€ ne pas toucher --}}
<script src="{{ asset('assets/js/theme-toggle.js') }}" defer></script>

<script src="{{ asset('assets/js/site-header-menu.js') }}"></script>
@stack('scripts')
</body>
</html>


