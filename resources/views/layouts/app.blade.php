<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fix&Tools - {{ $title ?? 'Accueil' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <style>
        .logo-text {
            font-family: 'Brush Script MT', 'Dancing Script', cursive;
            letter-spacing: 0.05em;
        }
    </style>
    {{ $styles ?? '' }}
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <x-navbar/>

    <!-- Sidebar pour admin et professionnel -->
    @auth
        @if(auth()->user()->isAdmin())
            <x-sidebars.admin/>
        @elseif(auth()->user()->isProfessional())
            <x-sidebars.professional/>
        @endif
    @endauth

    <!-- Flash Messages -->
    <x-flash-messages/>

    <!-- Main Content -->
    <main class="@auth @if(auth()->user()->isAdmin() || auth()->user()->isProfessional()) ml-64 @endif @endauth">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <x-footer/>

    {{ $scripts ?? '' }}
</body>
</html> 