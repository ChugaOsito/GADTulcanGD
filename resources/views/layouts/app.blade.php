<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    
    <script src="{{ asset('js/app.js') }}" ></script><!-- Se elimino etiqueta defer, volver a usar en caso de conflictos -->
    @yield('cssDataTable')
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="https://bootswatch.com/5/cerulean/bootstrap.css" rel="stylesheet" crossorigin="anonymous">

@yield('cssSelect2')
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

</head>
<body>

        <!-- Todo el nav es el header-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                        <img class="img-thumbnail img-fluid rounded" style="max-width: 15rem;" src="/images/logo.png" alt="logo"/>

                    
                </a>
                <div style="padding-left: 45vw;">

                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                           
                        @else
                        @php
                              $position= \DB::table('positions')->where('id', '=', Auth::user()->position_id)->first();
                              $departament= \DB::table('departaments')->where('id', '=', Auth::user()->departament_id)->first();
                              
                              $roles = array("Super Administrador","Administrador","Jefe de Departamento","Funcionario");
                        @endphp
                            <li class="nav-item dropdown"  >
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                    {{ Auth::user()->lastname }} {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    
                                      
                                 <p class=" text-center small text-muted" 
                                 >
                                   {{ $position->name }}
                                </p>
                            
                            
                               <p class=" text-center small text-muted" 
                               >
                                Departamento de: {{$departament->name}}
                            </p>
                            <p class=" text-center small text-muted" 
                             >
                               Privilegios: {{ $roles[Auth::user()->rol+1] }}
                        </p>
                           <div class="dropdown-divider"></div>
                           <a class="dropdown-item" href="/Recibidos"
                                   >
                                     Mi Perfil
                                 </a>
                                 <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Cerrar Sesion
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    
        

            <div class="container-fluid">
                <div class="row min-vh-100 flex-column flex-md-row">
                   
                    @include('includes.menu')
                    
                    <main class="border  col bg-faded py-3 flex-grow-1">

                        @yield('content')
                        
                    </main>

                
            </div>
            
        
    </div>
    {{-- 
    Descomentar en caso de conflicto    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> --}}
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    @yield('jsSelect2')
    
    {{-- ck-editor 
    @yield('ck-editor')
    --}}

    @yield('jsDataTable')
</body>
</html>
