<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
      <link rel="icon" type="image/png" href="{{ asset('images/logoz.png') }}">
        
        <script src="https://cdn.tailwindcss.com"></script>
        <title>Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .main-bg {
             background-color: #aafffb;
            }
            
            .form-container {
                position: relative;
                z-index: 20;
                background-color: rgba(255, 255, 255, 0.95);
                border-radius: 12px;
                box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05),
                            0 2px 6px rgba(0, 0, 0, 0.02);
                border: 1px solid rgba(237, 242, 247, 0.8);
                transition: all 0.3s ease;
            }
            
            .form-container:hover {
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08),
                            inset 0 0 0 1px rgba(255, 255, 255, 0.9);
            }
            
            /* Teal floating elements */
            .floating-elements {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                overflow: hidden;
                z-index: 10;
            }
            
            .floating-elements span {
                position: absolute;
                display: block;
                background: rgba(13, 148, 136, 0.1);
                border: 1px solid rgba(13, 129, 120, 0.849);
                bottom: -150px;
                animation: float 15s linear infinite;
                border-radius: 50%;
            }
            
            .floating-elements span:nth-child(1) {
                left: 25%;
                width: 80px;
                height: 80px;
                animation-delay: 0s;
                background: rgb(31, 224, 208);
            }
            
            .floating-elements span:nth-child(2) {
                left: 10%;
                width: 20px;
                height: 20px;
                animation-delay: 2s;
                animation-duration: 12s;
            }
            
            .floating-elements span:nth-child(3) {
                left: 70%;
                width: 20px;
                height: 20px;
                animation-delay: 4s;
            }
            
            .floating-elements span:nth-child(4) {
                left: 40%;
                width: 60px;
                height: 60px;
                animation-delay: 0s;
                animation-duration: 18s;
                background: rgb(27, 209, 194);
            }
            
            .floating-elements span:nth-child(5) {
                left: 65%;
                width: 20px;
                height: 20px;
                animation-delay: 0s;
            }
            
            .floating-elements span:nth-child(6) {
                left: 75%;
                width: 110px;
                height: 110px;
                animation-delay: 3s;
                background: rgb(19, 197, 182);
            }
            
            .floating-elements span:nth-child(7) {
                left: 35%;
                width: 150px;
                height: 150px;
                animation-delay: 7s;
                background: rgb(18, 219, 203);
            }
            
            .floating-elements span:nth-child(8) {
                left: 50%;
                width: 25px;
                height: 25px;
                animation-delay: 15s;
                animation-duration: 45s;
            }
            
            .floating-elements span:nth-child(9) {
                left: 20%;
                width: 15px;
                height: 15px;
                animation-delay: 2s;
                animation-duration: 35s;
            }
            
            .floating-elements span:nth-child(10) {
                left: 85%;
                width: 150px;
                height: 150px;
                animation-delay: 0s;
                animation-duration: 11s;
                background: rgb(12, 199, 183);
            }
            
            @keyframes float {
                0% {
                    transform: translateY(0) rotate(0deg);
                    opacity: 0.8;
                    border-radius: 50%;
                }
                50% {
                    opacity: 0.4;
                }
                100% {
                    transform: translateY(-1000px) rotate(720deg);
                    opacity: 0;
                    border-radius: 10%;
                }
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex justify-center items-center pt-6 sm:pt-0 main-bg relative overflow-hidden">
            <!-- Teal floating elements -->
            <div class="floating-elements">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
            
            <!-- Form Container -->
            <div class="w-11/12 sm:w-96 p-8 form-container">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>