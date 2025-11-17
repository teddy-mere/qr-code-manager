<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    @hasSection('title')
    <title>@yield('title') - {{ config('app.name') }}</title>
    @else
    <title>{{ config('app.name') }}</title>
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        // Load theme early to prevent FOUC
        (function() {
            const theme = localStorage.getItem('theme');
            if (!theme) {
                const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (prefersDark) {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                }
            } else if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <!-- Flash messages -->
    <x-flash />
    <div class="group/sidebar-wrapper bg-sidebar flex min-h-svh w-full" style="--sidebar-width: 16rem; --sidebar-width-icon: 3rem;">
        @php
        $sidebarState = request()->cookie('sidebar_state', 'expanded');
        @endphp
        <!-- Sidebar -->
        <div id="sidebar" class="group peer animate-in slide-in-from-left md:repeat-0 text-sidebar-foreground hidden md:block" data-state="{{ $sidebarState }}" data-collapsible="{{ $sidebarState === 'collapsed' ? 'icon' : '' }}" data-variant="inset">
            <div class="relative h-svh w-(--sidebar-width) bg-transparent transition-[width] duration-200 ease-linear md:group-data-[collapsible=icon]:w-[calc(var(--sidebar-width-icon)+(--spacing(4)))]"></div>
            <div id="sidebar-content" class="fixed inset-y-0 z-10 hidden h-svh w-(--sidebar-width) transition-[left,right,width] duration-200 ease-linear md:flex left-0 p-2 md:group-data-[collapsible=icon]:w-[calc(var(--sidebar-width-icon)+(--spacing(4))+2px)]">
                <div class="bg-sidebar flex h-full w-full flex-col">
                    <!-- Sidebar header -->
                    <div class="flex flex-col gap-2 p-2">
                        <ul class="flex w-full min-w-0 flex-col gap-1">
                            <li class="group/menu-item relative">
                                <a href="{{ route('dashboard') }}" class="peer/menu-button flex w-full items-center gap-2 overflow-hidden rounded-md p-2 text-left outline-hidden ring-sidebar-ring transition-[width,height,padding] focus-visible:ring-2 active:bg-sidebar-accent active:text-sidebar-accent-foreground md:group-data-[collapsible=icon]:size-8! [&>span:last-child]:truncate [&>svg]:size-4 [&>svg]:shrink-0 hover:bg-sidebar-accent hover:text-sidebar-accent-foreground h-12 text-sm md:group-data-[collapsible=icon]:p-0!">
                                    <div class="flex aspect-square size-8 items-center justify-center rounded-md bg-sidebar-primary text-sidebar-primary-foreground">
                                        <svg class="size-5 fill-current text-white dark:text-black" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17 12v4a1 1 0 0 1-1 1h-4" />
                                            <path d="M17 3h2a2 2 0 0 1 2 2v2" />
                                            <path d="M17 8V7" />
                                            <path d="M21 17v2a2 2 0 0 1-2 2h-2" />
                                            <path d="M3 7V5a2 2 0 0 1 2-2h2" />
                                            <path d="M7 17h.01" />
                                            <path d="M7 21H5a2 2 0 0 1-2-2v-2" />
                                            <rect x="7" y="7" width="5" height="5" rx="1" />
                                        </svg>
                                    </div>
                                    <div class="ml-1 grid flex-1 text-left text-sm"><span class="mb-0.5 truncate leading-tight font-semibold">{{ config('app.name') }}</span></div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- Sidebar content -->
                    <div class="flex min-h-0 flex-1 flex-col gap-2 overflow-auto md:group-data-[collapsible=icon]:overflow-hidden">
                        <div class="relative flex w-full min-w-0 flex-col p-2 px-2 py-0">
                            <div class="text-sidebar-foreground/70 ring-sidebar-ring flex h-8 shrink-0 items-center rounded-md px-2 text-xs font-medium outline-hidden transition-[margin,opacity] duration-200 ease-linear focus-visible:ring-2 [&>svg]:size-4 [&>svg]:shrink-0 md:group-data-[collapsible=icon]:-mt-8 md:group-data-[collapsible=icon]:opacity-0 md:group-data-[collapsible=icon]:select-none md:group-data-[collapsible=icon]:pointer-events-none">Plateforme</div>
                            <ul class="flex w-full min-w-0 flex-col gap-1">
                                <li class="group/menu-item relative">
                                    <x-nav-item :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect width="7" height="7" x="3" y="3" rx="1"></rect>
                                            <rect width="7" height="7" x="14" y="3" rx="1"></rect>
                                            <rect width="7" height="7" x="14" y="14" rx="1"></rect>
                                            <rect width="7" height="7" x="3" y="14" rx="1"></rect>
                                        </svg>
                                        <span>Dashboard</span>
                                    </x-nav-item>
                                </li>
                                <li class="group/menu-item relative">
                                    <x-nav-item :href="route('qrcodes.index')" :active="request()->routeIs('qrcodes.*')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect width="5" height="5" x="3" y="3" rx="1" />
                                            <rect width="5" height="5" x="16" y="3" rx="1" />
                                            <rect width="5" height="5" x="3" y="16" rx="1" />
                                            <path d="M21 16h-3a2 2 0 0 0-2 2v3" />
                                            <path d="M21 21v.01" />
                                            <path d="M12 7v3a2 2 0 0 1-2 2H7" />
                                            <path d="M3 12h.01" />
                                            <path d="M12 3h.01" />
                                            <path d="M12 16v.01" />
                                            <path d="M16 12h1" />
                                            <path d="M21 12v.01" />
                                            <path d="M12 21v-1" />
                                        </svg>
                                        <span>QR Codes</span>
                                    </x-nav-item>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Sidebar footer -->
                    <div class="flex flex-col gap-2 p-2">
                        <ul class="flex w-full min-w-0 flex-col gap-1">
                            <li class="group/menu-item relative">
                                <div class="flex w-full items-center gap-2 overflow-hidden rounded-md p-2 text-left outline-hidden ring-sidebar-ring transition-[width,height,padding] focus-visible:ring-2 md:group-data-[collapsible=icon]:size-8! [&>span:last-child]:truncate [&>svg]:size-4 [&>svg]:shrink-0 h-12 text-sm md:group-data-[collapsible=icon]:p-0! group text-sidebar-accent-foreground">
                                    <span class="relative flex size-8 shrink-0 h-8 w-8 overflow-hidden rounded-full">
                                        <span class="flex size-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">{{ auth()->user()->getInitials() }}</span>
                                    </span>
                                    <div class="grid flex-1 text-left text-sm leading-tight">
                                        <span class="truncate font-medium">{{ auth()->user()->name }}</span>
                                        <span class="truncate text-xs text-muted-foreground">{{ auth()->user()->email }}</span>
                                    </div>
                                </div>
                            </li>
                            <li class="group/menu-item relative">
                                <x-nav-item :href="route('profile.edit')" :active="request()->routeIs('profile.*')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                        <circle cx="12" cy="7" r="4" />
                                    </svg>
                                    <span>Profil</span>
                                </x-nav-item>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="peer/menu-button cursor-pointer flex w-full items-center gap-2 overflow-hidden rounded-md p-2 text-left outline-hidden ring-sidebar-ring transition-[width,height,padding] focus-visible:ring-2 active:bg-sidebar-accent active:text-sidebar-accent-foreground md:group-data-[collapsible=icon]:size-8! md:group-data-[collapsible=icon]:p-2! [&>span:last-child]:truncate [&>svg]:size-4 [&>svg]:shrink-0 hover:bg-sidebar-accent hover:text-sidebar-accent-foreground h-8 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m16 17 5-5-5-5" />
                                            <path d="M21 12H9" />
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                        </svg>
                                        <span>Se déconnecter</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                        <!-- Sidebar theme switcher -->
                        <div class="relative flex w-full min-w-0 flex-col p-2 md:group-data-[collapsible=icon]:p-0 mt-auto">
                            <div class="w-full text-sm">
                                <div class="inline-flex gap-1 rounded-lg bg-neutral-100 p-1 dark:bg-neutral-800 md:group-data-[collapsible=icon]:hidden">
                                    <button id="btn-light" class="flex items-center rounded-md px-3.5 py-1.5 transition-colors text-neutral-500 hover:bg-neutral-200/60 hover:text-black dark:text-neutral-400 dark:hover:bg-neutral-700/60 cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="-ml-1 h-4 w-4">
                                            <circle cx="12" cy="12" r="4"></circle>
                                            <path d="M12 2v2"></path>
                                            <path d="M12 20v2"></path>
                                            <path d="m4.93 4.93 1.41 1.41"></path>
                                            <path d="m17.66 17.66 1.41 1.41"></path>
                                            <path d="M2 12h2"></path>
                                            <path d="M20 12h2"></path>
                                            <path d="m6.34 17.66-1.41 1.41"></path>
                                            <path d="m19.07 4.93-1.41 1.41"></path>
                                        </svg>
                                        <span class="ml-1.5 text-sm">Clair</span>
                                    </button>
                                    <button id="btn-dark" class="flex items-center rounded-md px-3.5 py-1.5 transition-colors text-neutral-500 hover:bg-neutral-200/60 hover:text-black dark:text-neutral-400 dark:hover:bg-neutral-700/60 cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="-ml-1 h-4 w-4">
                                            <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>
                                        </svg>
                                        <span class="ml-1.5 text-sm">Sombre</span>
                                    </button>
                                </div>
                                <button id="btn-toggle-icon"
                                    class="hidden md:group-data-[collapsible=icon]:flex flex w-full items-center gap-2 overflow-hidden rounded-md p-2 text-left outline-hidden ring-sidebar-ring transition-[width,height,padding] focus-visible:ring-2 active:bg-sidebar-accent active:text-sidebar-accent-foreground md:group-data-[collapsible=icon]:size-8! md:group-data-[collapsible=icon]:p-2! [&>span:last-child]:truncate [&>svg]:size-4 [&>svg]:shrink-0 hover:bg-sidebar-accent hover:text-sidebar-accent-foreground h-8 text-sm cursor-pointer">
                                    <div id="icon-toggle" class="h-4 w-4 [&>svg]:size-4 [&>svg]:shrink-0"></div>
                                    <span class="sr-only">Changer le thème</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main content -->
        <main class="bg-background relative flex max-w-full min-h-svh flex-1 flex-col min-h-main md:m-2 md:ml-0 md:rounded-xl md:shadow-sm md:peer-data-[state=collapsed]:ml-0 overflow-x-hidden">
            <header class="flex h-16 shrink-0 items-center gap-2 border-b border-sidebar-border/50 px-6 transition-[width,height] ease-linear md:group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4">
                <div class="flex items-center gap-2">
                    <button id="sidebar-toggle" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-[color,box-shadow] [&_svg]:pointer-events-none [&_svg:not([class*='size-'])]:size-4 [&_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] hover:bg-accent hover:text-accent-foreground size-9 h-7 w-7 -ml-1 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="18" x="3" y="3" rx="2"></rect>
                            <path d="M9 3v18"></path>
                        </svg>
                        <span class="sr-only">Afficher/Masquer la barre latérale</span>
                    </button>
                    @hasSection('title')
                    <span class="font-normal text-foreground text-sm">@yield('title')</span>
                    @endif
                </div>
            </header>
            <div class="px-4 py-6">
                @yield('content')
            </div>
        </main>
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 hidden z-40 md:hidden"></div>
    </div>
    <script>
        (function() {
            // Theme toggle
            const lightBtn = document.getElementById('btn-light');
            const darkBtn = document.getElementById('btn-dark');
            const toggleIconBtn = document.getElementById('btn-toggle-icon');
            const icon = document.getElementById('icon-toggle');

            const activeClasses = ['bg-white', 'shadow-xs', 'dark:bg-neutral-700', 'dark:text-neutral-100'];
            const inactiveClasses = ['text-neutral-500', 'hover:bg-neutral-200/60', 'hover:text-black', 'dark:text-neutral-400', 'dark:hover:bg-neutral-700/60'];

            const icons = {
                light: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>`,
                dark: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.985 12.486a9 9 0 1 1-9.473-9.472c.405-.022.617.46.402.803a6 6 0 0 0 8.268 8.268c.344-.215.825-.004.803.401"/></svg>`
            };

            function setActive(activeBtn, inactiveBtn, darkMode) {
                activeBtn.classList.add(...activeClasses);
                activeBtn.classList.remove(...inactiveClasses);

                inactiveBtn.classList.add(...inactiveClasses);
                inactiveBtn.classList.remove(...activeClasses);

                icon.innerHTML = darkMode ? icons.dark : icons.light;

                document.documentElement.classList.toggle('dark', darkMode);
                localStorage.setItem('theme', darkMode ? 'dark' : 'light');
            }

            // État initial
            if (localStorage.getItem('theme') === 'dark') {
                setActive(darkBtn, lightBtn, true);
            } else {
                setActive(lightBtn, darkBtn, false);
            }

            lightBtn.addEventListener('click', () => setActive(lightBtn, darkBtn, false));
            darkBtn.addEventListener('click', () => setActive(darkBtn, lightBtn, true));
            toggleIconBtn.addEventListener('click', () => {
                const darkMode = !document.documentElement.classList.contains('dark');
                setActive(darkMode ? darkBtn : lightBtn, darkMode ? lightBtn : darkBtn, darkMode);
            });
        })();
    </script>
</body>

</html>