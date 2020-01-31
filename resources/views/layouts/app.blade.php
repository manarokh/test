<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    {{-- <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://use.fontawesome.com/57f39e8c6d.js"></script>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css"> --}}
    <script>
        $(document).ready(function() {
            //check when page load 
            if ($('body').hasClass('theme-dark')) {
                    $('#logo').attr('src','/images/logo-dark.svg');
                }else{
                    $('#logo').attr('src','/images/logo.svg');
                }

            //check if theme changed 
                $( "#theme" ).click(function() {
                    if ($('body').hasClass('theme-dark')) {
                    $('#logo').attr('src','/images/logo-dark.svg');
                }else{
                    $('#logo').attr('src','/images/logo.svg');
                }
            });
        });
    </script>
</head>
<body class="theme-light bg-page">
    <div id="app">
        <nav class="bg-header">
            <div class="container mx-auto">
                <div class="flex justify-between items-center py-2">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img 
                        id="logo"
                        {{-- src="/images/logo.svg"  --}}
                        alt="Logo" >
                       
                    </a>
                        <!-- Right Side Of Navbar -->
                            <div class="flex items-center ml-auto">
                            <!-- Authentication Links -->
                            <theme-switcher id="theme"></theme-switcher>

                           

                        @guest

                        <dropdown>
                            <template v-slot:trigger>
                                <span id="dropdown for login/signup"></span>
                            </template>
                            <a class="dropdown-item text-default mr-3" href="{{ route('login') }}">{{ __('Login') }}</a>
                            @if (Route::has('register'))
                                    <a class="dropdown-item text-default" href="{{ route('register') }}">{{ __('Register') }}</a>
                            @endif
                        </dropdown>
                            
                        @else

                        <dropdown width="100%">
                            <template v-slot:trigger>
                                <button class="flex items-center capitalize mr-5 focus:outline-none" href="#">
                                    <img 
                                    src="{{ gravatar_url(auth()->user()->email) }}" 
                                    class="h-16 w-16 rounded-full mr-3 "
                                    alt="Username">{{ Auth::user()->name }}</button>        
                            </template>
                            
                            {{-- <a href="#" class="block text-default hover:underline leading-loose px-4 ">Item 2 </a> --}}
                            
                                <a 
                                href="{{ route('logout') }}"
                                class="dropdown-item"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            
                        </dropdown>

                            
                        @endguest
                        </div>
                    </div>
                </div>
        </nav>

        <main class="py-4 mx-auto container">
            @yield('content')
        </main>
    </div>
</body>
</html>
