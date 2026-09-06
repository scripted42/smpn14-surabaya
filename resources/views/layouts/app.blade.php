<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'SMP Negeri 14 Surabaya — Sekolah Berkarakter & Berbudaya Lingkungan')</title>
    <meta name="description" content="@yield('meta_description', 'Website resmi SMP Negeri 14 Surabaya. Informasi profil, akademik kurikulum merdeka, prestasi kejuaraan, galeri, dan SPMB Kota Surabaya.')">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='10' fill='%231F2A44'/><text x='50%' y='55%' dominant-baseline='middle' text-anchor='middle' font-family='serif' font-weight='bold' font-size='50' fill='%23FBFAF5'>14</text></svg>">

    <!-- Google Fonts: IBM Plex Family -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@500;600&family=IBM+Plex+Sans:wght@400;500;600;700&family=IBM+Plex+Serif:wght@600;700&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>

    @include('partials.header')

    <main id="main-content">
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>
