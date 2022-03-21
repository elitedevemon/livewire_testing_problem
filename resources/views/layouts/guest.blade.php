

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
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

        <!-- Scripts -->
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        
        <script src="{{ asset('js/app.js') }}" defer></script>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.0/html2canvas.min.js"></script><!-- pour screenshots de l'écran de l'utilisateur -->

        @if(request()->routeIs('home')) 
        <!-- ne pas inclure le javascript pour le jump menu si on n'est pas dans la page home 
        car ça donne une erreur javascript si on garde le menu en haut -->
        <script src="{{ asset('js/JumpMenuWithActiveClass.js') }}" async defer></script>
        @endif
        

    </head>
    <body>
        <div class="min-h-screen bg-gray-100">      

            <div class="font-sans text-gray-900 antialiased">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
