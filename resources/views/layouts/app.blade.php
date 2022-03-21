<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!--Favicon-->
        <link rel="shortcut icon" href="/images/favicon.ico" title="Favicon"/>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/css-loader-master/dist/css-loader.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">


        <!-- Scripts -->
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/custom.js') }}" defer></script>
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" type="text/javascript"></script>    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.0/html2canvas.min.js"></script><!-- pour screenshots de l'écran de l'utilisateur -->


        @livewireStyles
    </head>
    <body class="font-sans antialiased" onload="displayRemainingTimeUntilCreditsReset()" id="top">
    <!-- id='top' est utilisé pour remonter en haut de la page pour certaines pages comme peut-être 'credits usage' par exemple -->
        <div class="min-h-screen bg-yellow-100">        

            <!-- Page Heading -->
            <header class="bg-yellow-50 shadow border-t-2 border-gray-200 sm:border-0">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @livewireScripts
    </body>
</html>
