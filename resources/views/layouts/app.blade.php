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
    <div class="z-30 relative">
        <x-navbar/>
    </div>

    @auth
        @if(auth()->user()->isAdmin())
            <button id="toggleAdminSidebar" class="fixed top-20 left-4 bg-yellow-400 text-black p-2 rounded-lg shadow-lg md:hidden z-30">
                <i class="fas fa-bars"></i>
            </button>
        @elseif(auth()->user()->isProfessional()) 
            <button id="toggleSidebar" class="fixed top-20 left-4 bg-yellow-400 text-black p-2 rounded-lg shadow-lg md:hidden z-30">
                <i class="fas fa-bars"></i>
            </button>
        @endif
    @endauth

    @auth
        <div class="z-20 relative">
            @if(auth()->user()->isAdmin())
                <x-sidebars.admin/>
            @elseif(auth()->user()->isProfessional())
                <x-sidebars.professional/>
            @endif
        </div>
    @endauth

    <x-toast-notifications type="success" />
    <x-toast-notifications type="error" />

    <main class="@auth @if(auth()->user()->isAdmin() || auth()->user()->isProfessional()) md:ml-64 transition-all duration-300 @endif @endauth">
        {{ $slot }}
    </main>

    <x-footer/>

    @stack('scripts')
    
    @auth
        @if(auth()->user()->isAdmin())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const sidebar = document.getElementById('adminSidebar');
                    const toggleBtn = document.getElementById('toggleAdminSidebar');
                    const closeBtn = document.getElementById('closeAdminSidebar');
                    
                    if (toggleBtn && sidebar && closeBtn) {
                        toggleBtn.addEventListener('click', function() {
                            sidebar.classList.toggle('-translate-x-full');
                        });
                        
                        closeBtn.addEventListener('click', function() {
                            sidebar.classList.add('-translate-x-full');
                        });
                    }
                });
            </script>
        @elseif(auth()->user()->isProfessional())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const sidebar = document.getElementById('professionalSidebar');
                    const toggleBtn = document.getElementById('toggleSidebar');
                    const closeBtn = document.getElementById('closeSidebar');
                    
                    if (toggleBtn && sidebar && closeBtn) {
                        toggleBtn.addEventListener('click', function() {
                            sidebar.classList.toggle('-translate-x-full');
                        });
                        
                        closeBtn.addEventListener('click', function() {
                            sidebar.classList.add('-translate-x-full');
                        });
                    }
                });
            </script>
        @endif
    @endauth
</body>
</html> 