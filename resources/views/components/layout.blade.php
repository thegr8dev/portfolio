<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth" id="html-element">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Primary Meta Tags -->
    <title>{{ $title ?? 'Ankit Kabra | Engineering Manager / Senior Laravel Developer' }}</title>
    <meta name="title" content="{{ $title ?? 'Ankit Kabra | Engineering Manager / Senior Laravel Developer' }}">
    <meta name="description" content="Engineering Manager & Senior Laravel Developer with 6.5+ years building scalable multi-tenant web applications using TALL stack (Tailwind, Alpine.js, Laravel, Livewire). Expert in Filament, team leadership, and AI integration.">
    <meta name="keywords" content="Engineering Manager, Senior Laravel Developer, TALL Stack, Laravel, Livewire, Filament, Alpine.js, Tailwind CSS, Multi-tenant Architecture, PHP Developer, Team Lead, AI Integration, Web Development, Full Stack Developer, Ankit Kabra, thegr8dev">
    <meta name="author" content="Ankit Kabra">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:title" content="Ankit Kabra | Engineering Manager / Senior Laravel Developer">
    <meta property="og:description" content="Engineering Manager & Senior Laravel Developer with 6.5+ years building scalable multi-tenant web applications using TALL stack. Expert in Filament, team leadership, and AI integration.">
    <meta property="og:image" content="https://images.unsplash.com/photo-1568602471122-7832951cc4c5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="en_US">
    <meta property="og:site_name" content="Ankit Kabra - Portfolio">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ config('app.url') }}">
    <meta property="twitter:title" content="Ankit Kabra | Engineering Manager / Senior Laravel Developer">
    <meta property="twitter:description" content="Engineering Manager & Senior Laravel Developer with 6.5+ years building scalable multi-tenant web applications using TALL stack. Expert in Filament, team leadership, and AI integration.">
    <meta property="twitter:image" content="https://images.unsplash.com/photo-1568602471122-7832951cc4c5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80">
    
    <!-- Additional SEO Tags -->
    <meta name="theme-color" content="#2563eb">
    <meta name="msapplication-TileColor" content="#2563eb">
    <meta name="msapplication-config" content="/browserconfig.xml">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ config('app.url') }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800|source-sans-pro:400,500,600,700|fira-code:400,500&display=swap"
        rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Livewire Styles -->
    @livewireStyles
</head>

<body class="antialiased bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-300">
    {{ $slot }}
    
    <!-- Livewire Scripts -->
    @livewireScripts
</body>

</html>