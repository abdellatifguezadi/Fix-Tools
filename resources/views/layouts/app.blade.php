<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Fix&Tools - {{ $title ?? 'Accueil' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .logo-text {
            font-family: 'Brush Script MT', 'Dancing Script', cursive;
            letter-spacing: 0.05em;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
        [x-cloak] { display: none !important; }
    </style>
    {{ $styles ?? '' }}
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <div class="z-30 relative">
        <x-navbar/>
    </div>


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

    <main class="@auth @if(auth()->user()->isAdmin() || auth()->user()->isProfessional()) lg:ml-64 transition-all duration-300 @endif @endauth flex-grow">
        {{ $slot }}
    </main>

    <footer class="mt-auto">
        <x-footer/>
    </footer>

    @auth
        <x-broadcast-script />
    @endauth
    
    @stack('scripts')
    
    @auth
        @if(auth()->user()->isAdmin())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const sidebar = document.getElementById('adminSidebar');
                    const toggleBtn = document.getElementById('toggleAdminSidebar');
                    const closeBtn = document.getElementById('closeAdminSidebar');
                    
                    function updateSidebarState() {
                        if (window.innerWidth >= 1024) {
                            sidebar.style.transition = 'none';
                            sidebar.classList.remove('-translate-x-full');
                            document.body.classList.add('admin-sidebar-visible');
                        } else {
                            if (!sidebar.classList.contains('-translate-x-full')) {
                                sidebar.classList.add('-translate-x-full');
                            }
                            document.body.classList.remove('admin-sidebar-visible');
                        }
                        
                        setTimeout(() => {
                            sidebar.style.transition = '';
                        }, 50);
                    }

                    if (sidebar) {
                        if (window.innerWidth >= 1024) {
                            sidebar.style.transition = 'none';
                            sidebar.classList.remove('-translate-x-full');
                        }
                        
                        setTimeout(updateSidebarState, 50);
                    }
                    
                    if (toggleBtn && sidebar && closeBtn) {
                        toggleBtn.addEventListener('click', function() {
                            sidebar.classList.toggle('-translate-x-full');
                        });
                        
                        closeBtn.addEventListener('click', function() {
                            sidebar.classList.add('-translate-x-full');
                        });
                        
                        let resizeTimer;
                        window.addEventListener('resize', function() {
                            clearTimeout(resizeTimer);
                            resizeTimer = setTimeout(updateSidebarState, 100);
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
                    
                    function updateSidebarState() {
                        if (window.innerWidth >= 1024) {
                            sidebar.style.transition = 'none';
                            sidebar.classList.remove('-translate-x-full');
                            document.body.classList.add('sidebar-visible');
                        } else {
                            if (!sidebar.classList.contains('-translate-x-full')) {
                                sidebar.classList.add('-translate-x-full');
                            }
                            document.body.classList.remove('sidebar-visible');
                        }
                        
                        setTimeout(() => {
                            sidebar.style.transition = '';
                        }, 50);
                    }

                    if (sidebar) {
                        if (window.innerWidth >= 1024) {
                            sidebar.style.transition = 'none';
                            sidebar.classList.remove('-translate-x-full');
                        }
                        
                        setTimeout(updateSidebarState, 50);
                    }

                    if (toggleBtn && sidebar && closeBtn) {
                        toggleBtn.addEventListener('click', function() {
                            sidebar.classList.toggle('-translate-x-full');
                        });
                        
                        closeBtn.addEventListener('click', function() {
                            sidebar.classList.add('-translate-x-full');
                        });

                        let resizeTimer;
                        window.addEventListener('resize', function() {
                            clearTimeout(resizeTimer);
                            resizeTimer = setTimeout(updateSidebarState, 100);
                        });
                    }
                });
            </script>
        @endif
    @endauth
</body>
</html> 