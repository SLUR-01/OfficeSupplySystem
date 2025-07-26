<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">

        {{-- script --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

           
        <link rel="icon" type="image/png" href="{{ asset('images/logoz.png') }}">

        <title>OffSuppSys</title>
        {{-- {{ config('app.name', 'OffSuppSys') }} --}}
        {{-- {{ config('app.name', 'Laravel') }} --}}
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://unpkg.com/@popperjs/core@2"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
   
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/main.min.js"></script>

    </head>
    <body class="font-sans antialiased">
    
   
        <section id="sidebar" class="w-64 h-screen  fixed top-0 left-0 flex flex-col shadow-md">
            <div class="flex justify-center items-center space-x-1 pt-2">
                <img class="h-12 w-12 mb-2" src="{{ asset('images/logoz.png') }}" alt="Description of Image">
    
    
      
     
       
        
                <h1 id="nav-text" class="text-3xl font-extrabold bg-gradient-to-r from-teal-800 to-cyan-500 text-transparent bg-clip-text">
                   OffSuppSys
                </h1>
    
            </div>
        
        
    
            <!-- Navigation -->
            <nav id="nav-container" class="flex-1 overflow-y-auto justify-center pt-4">
                <ul class="px-2 space-y-2">
    
    
                <li class="nav-item">
            
                    <a href="{{ route('dean.dashboard') }}" class="flex items-center py-2.5 text-dark hover:bg-gray-100 transition hover:rounded-md 
                    {{ request()->routeIs('dean.dashboard') ? 'active-nav bg-gray-100 rounded-md' : '' }}">
                    <i class="fa-solid fa-house text-teal-600 px-2"></i>
                    <span id="nav-text" class="px-2 ml-2 text-md">Dashboard</span>
                    </a>
                </li>   
                </ul>
            </nav>
        </section>


    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav class="navigation">
            <span class="navbar-toggler-icon">
                <i class="fa-solid fa-bars"></i>
            </span>
            <div class="flex items-center justify-end w-full sm:ms-6 relative">
                <div class="dropdown relative">
                    <button id="dropdownToggle" class="profile-btn inline-flex items-center text-sm leading-4 font-medium text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 px-2 py-1 rounded-md">
                        <div class="truncate max-w-[100px] sm:max-w-none">{{ Auth::user()->name }}</div>
                        <div class="ms-1">
                            <svg id="dropdownArrow" class="fill-current h-4 w-4 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                    <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                        <a href="{{ route('dean.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Profile') }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
        </nav>
        <!-- MAIN -->
    
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
           @yield('content')
        </main>
    
    
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script src="{{ asset('js/main.js') }}"></script>

</body>
</html>

            {{-- @else
                <!-- Handle cases where there is no specific role or fallback content -->
                
            @endif
        @endauth --}}



            {{-- <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('navigation.dashboard')">
                <i class="fa-solid fa-house"></i>

                <h4 class="dashboard-title">{{ __('Dashboard') }}</h4>
            </x-nav-link>
        </div>
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <x-nav-link :href="route('navigation.request')" :active="request()->routeIs('navigation.request')">
                <i class="fa-solid fa-envelope"></i>       
                <h4 class="request-title">  {{ __('Request Supplies') }} </h4> 
            </x-nav-link>
        </div> --}}




        {{-- @auth
            @if(auth()->user()->role === 'admin')
                <!-- Admin Dashboard View -->
                <div class="min-h-screen bg-gray-100">
                    @include('layouts.navigation') <!-- Navigation layout for admin -->

                    <!-- Page Heading -->
                    @isset($header)
                        <header class="bg-white shadow">
                            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endisset

                    <!-- Page Content -->
                    <main>
                        {{ $slot }}
                    </main>
                </div>
            @elseif(auth()->user()->role === 'user')
                <!-- User Dashboard View -->
                <div class="min-h-screen bg-gray-100">
                    @include('layouts.navigation') <!-- Navigation layout for user -->

                    <!-- Page Heading -->
                    @isset($header)
                        <header class="bg-white shadow">
                            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endisset

                    <!-- Page Content -->
                    <main>
                        {{ $slot }}
                    </main>
                </div> --}}

                <!-- resources/views/layouts/app.blade.php -->
