<!DOCTYPE html>
  <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

     
        <link rel="icon" type="image/png" href="{{ asset('images/logoz.png') }}">

        <title>OffSuppSys</title>
        <script src="//unpkg.com/alpinejs" defer></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

       <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href="https://cdn.tailwindcss.com" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script src="//unpkg.com/alpinejs" defer></script>
   

    </head>

    <body class="font-sans antialiased">

    <section id="sidebar" class="w-64 h-screen bg-gray-900 text-gray-300 fixed top-0 left-0 flex flex-col shadow-md">
        
        <div class="header-container flex justify-center items-center space-x-1 pt-2">
            <img class="img-logo mb-2" src="{{ asset('images/logoz.png') }}" alt="Description of Image">


  
 
   
    
            <h1 id="header-text" class=" text-3xl font-extrabold bg-gradient-to-r from-teal-800 to-cyan-500 text-transparent bg-clip-text">
               OffSuppSys
            </h1>

        </div>
    
        {{-- Navigation --}}
        <nav id="nav-container" class="flex-1 overflow-y-auto justify-center pt-4">
            <ul class="px-2 space-y-2">
                <li>
                    <a href="{{ route('admin.dashboard') }}" data-tooltip="Dashboard" class="flex items-center py-2.5 text-dark hover:bg-gray-100 transition hover:rounded-md 
                    {{ request()->routeIs('admin.dashboard') ? 'active-nav bg-gray-100 rounded-md' : '' }}">
                    <i class="fa-solid fa-house text-teal-600 px-2"></i>
                    <span id="nav-text" class="px-2 ml-2 text-md">Dashboard</span>
                </a>
                </li>
        
                <li>
                    <a href="{{ route('admin.requests') }}" class="flex items-center py-2.5 text-dark hover:bg-gray-100 transition hover:rounded-md 
                        {{ request()->routeIs('admin.requests') ? 'active-nav bg-gray-100 rounded-md' : '' }}">
                        <i class="fa-solid fa-clipboard text-teal-600 px-2.5"></i>
                        <span id="nav-text" class="px-2 ml-2 text-md">Request Approvals</span>
                    </a>
                </li>
        
                <li>
                    <a href="{{ route('admin.withdrawal') }}" class="flex items-center py-2.5 text-dark hover:bg-gray-100 transition hover:rounded-md 
                        {{ request()->routeIs('admin.withdrawal') ? 'active-nav bg-gray-100 rounded-md' : '' }}">
                        <i class="fa-solid fa-sign-out-alt text-teal-600 px-2"></i>
                        <span id="nav-text" class="px-2 ml-2 text-md">Withdrawals</span>
                    </a>
                </li>
        
                <li>
                    <a href="{{ route('admin.return') }}" class="flex items-center py-2.5 text-dark hover:bg-gray-100 transition hover:rounded-md 
                        {{ request()->routeIs('admin.return') ? 'active-nav bg-gray-100 rounded-md' : '' }}">
                        <i class="fa-solid fa-undo text-teal-600 px-2"></i>
                        <span id="nav-text" class="px-2 ml-2 text-md">Returns</span>
                    </a>
                </li>
        
                <li>
                    <a href="{{ route('admin.stocks') }}" class="flex items-center py-2.5 text-dark hover:bg-gray-100 transition hover:rounded-md 
                        {{ request()->routeIs('admin.stocks') ? 'active-nav bg-gray-100 rounded-md' : '' }}">
                        <i class="fa-solid fa-boxes text-teal-600 px-2"></i>
                        <span id="nav-text" class="px-2 ml-2 text-md">Inventory</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.monthly-reports') }}" class="flex items-center py-2.5 text-dark hover:bg-gray-100 transition hover:rounded-md 
                        {{ request()->routeIs('admin.monthly-reports') ? 'active-nav bg-gray-100 rounded-md' : '' }}">
                        <i class="fas fa-calendar-alt text-teal-600 px-2"></i>
                        <span id="nav-text" class="px-2 ml-2 text-md">Reports</span>
                    </a>
                </li>
        
                <li>
                    <a href="{{ route('admin.users') }}" class="flex items-center py-2.5 text-dark hover:bg-gray-100 transition hover:rounded-md 
                        {{ request()->routeIs('admin.users') ? 'active-nav bg-gray-100 rounded-md' : '' }}">
                        <i class="fas fa-users text-teal-600 px-2"></i>
                        <span id="nav-text" class="px-2 ml-2 text-md">Users</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.feedback') }}" class="flex items-center py-2.5 text-dark hover:bg-gray-100 transition hover:rounded-md 
                        {{ request()->routeIs('admin.feedback') ? 'active-nav bg-gray-100 rounded-md' : '' }}">
                        <i class="fas fa-comment-dots text-teal-600 px-2"></i>
                        <span id="nav-text" class="px-2 ml-2 text-md">Feedback</span>
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
            
            <div class="flex items-center justify-end ms-4 sm:ms-6 w-full">
                <div class="relative dropdown">
                    <button id="dropdownToggle" class="profile-btn inline-flex items-center text-sm leading-4 font-medium text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        
                        <div class="flex gap-2">
                               <i class="fas fa-user-shield text-teal-600"></i>
                            {{ Auth::user()->name }}
                        </div>
                        <div class="ms-1 ">
                            
                            <svg id="dropdownArrow" class="fill-current h-4 w-4 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                    <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                        <a href="{{ route('admin.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user mr-1  text-teal-600"></i>    {{ __('Profile') }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-sign-out text-teal-600"></i>    {{ __('Log Out') }}
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
