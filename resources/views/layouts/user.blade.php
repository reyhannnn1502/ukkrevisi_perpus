<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'FutureSight') }}</title>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/profile-css.css')}}">
    
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<style>
    /* Profile CSS */

.profile-section {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 1.5rem;
    transition: transform 0.2s;
}

.profile-section:hover {
    transform: translateY(-2px);
}

.section-header {
    border-bottom: 2px solid #f3f4f6;
    padding: 1rem;
    font-weight: 600;
    color: #1a1a1a;
}

.avatar-upload {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.current-avatar {
    border-radius: 50%;
    border: 3px solid #e5e7eb;
    transition: border-color 0.2s;
}

.current-avatar:hover {
    border-color: #3b82f6;
}

.back-button {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: white;
    font-weight: 500;
    transition: opacity 0.2s;
}

.back-button:hover {
    opacity: 0.9;
}

.profile-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.nav-profile {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.nav-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px solid white;
}

.btn-custom {
    background-color: #3b82f6;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    transition: background-color 0.2s;
}

.btn-custom:hover {
    background-color: #2563eb;
}

/* Tambahkan di dalam tag <style> yang sudah ada */
.nav-link {
    transition: all 0.3s ease;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
}

.nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
    transform: translateY(-1px);
}

.nav-link i {
    font-size: 1.1rem;
}

.nav-link span {
    font-weight: 500;
}

/* Animasi hover */
@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        transform: scale(1);
    }
}

.nav-link:hover i {
    animation: pulse 1s infinite;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .nav-link {
        padding: 0.5rem;
    }
    
    .nav-link i {
        margin-right: 0.5rem;
    }
}
</style>

<body class="bg-gray-100">
    <div id="app">
        @include('partials.navbar')
        
        <!-- Main Content -->
        <main>
            <div class="profile-container">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>