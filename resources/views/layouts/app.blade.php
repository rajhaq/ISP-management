<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Call Center') }}</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
    <v-app>
        <v-toolbar color="blue-grey darken-4"
              dark>
            <v-toolbar-title href="{{ url('/') }}">
                    {{ config('app.name', '') }}
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items class="hidden-sm-and-down">
            @guest
                <v-btn flat href="{{ route('login') }}">{{ __('Login') }}</v-btn>
            @if (Route::has('register'))
                <v-btn flat href="{{ route('register') }}">{{ __('Register') }}</v-btn>
            @endif
            @else
                <v-btn flat>{{ Auth::user()->name }} </v-btn>
                <v-btn flat> <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                </v-btn>
            @endguest
            </v-toolbar-items>
        </v-toolbar>
        <main class="py-4">
                @yield('content')
        </main>
    </v-app>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vuetify/1.5.14/vuetify.js"></script>
<script href="{{ asset('js/app.js') }}" ></script>

<script>
    new Vue({ 
        el: '#app', 
        data: {
        input: '# hello',        
        },

  })


  </script>
</body>
</html>
