<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0F9B81">
    <meta name="description" content="@yield('meta_description', 'PetCare — layanan grooming, konsultasi dokter hewan, dan pet hotel di Jakarta. Booking perawatan hewan kesayangan dengan mudah.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PetCare — Happy Pets, Better Life')</title>

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Crect width='64' height='64' rx='16' fill='%230F9B81'/%3E%3Cg fill='%23fff'%3E%3Cellipse cx='23' cy='20' rx='6' ry='8'/%3E%3Cellipse cx='41' cy='20' rx='6' ry='8'/%3E%3Cellipse cx='14' cy='33' rx='5' ry='7'/%3E%3Cellipse cx='50' cy='33' rx='5' ry='7'/%3E%3Cpath d='M32 29c-8 0-14 6-14 13 0 5 4 8 9 8 2 0 3-1 5-1s3 1 5 1c5 0 9-3 9-8 0-7-6-13-14-13Z'/%3E%3C/g%3E%3C/svg%3E">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="relative min-h-screen">
    <div class="page-ambient" aria-hidden="true">
        <div class="orb orb-mint"></div>
        <div class="orb orb-amber"></div>
        <div class="orb orb-sky"></div>
    </div>

    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[100] focus:rounded-xl focus:bg-primary-700 focus:px-4 focus:py-2 focus:text-sm focus:font-bold focus:text-white">
        Lewati ke konten utama
    </a>

    @include('partials.public-navbar')

    <main id="main-content">
        @yield('content')
    </main>

    @include('partials.public-footer')
    @include('partials.toast-stack')

    @stack('scripts')
</body>
</html>
