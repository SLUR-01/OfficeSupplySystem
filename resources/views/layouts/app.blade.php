<<<<<<< HEAD
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
=======
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
     <head>
>>>>>>> 050d60bca7d17b9057529ca4c167d07cb3a2e0ad
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
<<<<<<< HEAD
        <title>{{ config('app.name', 'Laravel') }}</title>
=======

        {{-- script --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

     
        <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
>>>>>>> 050d60bca7d17b9057529ca4c167d07cb3a2e0ad

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
<<<<<<< HEAD
        
=======
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

>>>>>>> 050d60bca7d17b9057529ca4c167d07cb3a2e0ad
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
<<<<<<< HEAD

    </head>
    <body class="font-sans antialiased">
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

	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			
        
			<h3 class="h-title">``LOGOWO</h3>
		</a>

        <div class="sidebar">
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('navigation.dashboard')">
                <h4 class="dashboard-title">{{ __('Dashboard') }}</h4>
            </x-nav-link>
        </div>
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <x-nav-link :href="route('navigation.request')" :active="request()->routeIs('navigation.request')">
               <h4 class="request-title">  {{ __('Request Supplies') }} </h4> 
            </x-nav-link>
        </div>
		
         </div>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav class="navs">
        <span class="navbar-toggler-icon">
            <i class="fa-solid fa-bars"></i>
        </span>
        <div class="hidden sm:flex sm:items-center sm:ms-6">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        <div>{{ Auth::user()->name }}</div>

                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <!-- Authentication -->
                    <form class="logout" method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
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
            {{ $slot }}
        </main>
      
     
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

<script>
    // TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .fa-solid.fa-bars');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');
})



</script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

            {{-- @else
                <!-- Handle cases where there is no specific role or fallback content -->
                
            @endif
        @endauth --}}
=======
        
        <script src="https://cdn.tailwindcss.com"></script>

    </head>
        <body class="font-sans antialiased">
        

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
>>>>>>> 050d60bca7d17b9057529ca4c167d07cb3a2e0ad
