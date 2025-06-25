  <!DOCTYPE html>
  <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <title>{{ config('app.name', 'Laravel') }}</title>

      <!-- Fonts -->
      <link rel="dns-prefetch" href="//fonts.gstatic.com">
      <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

      <!-- Styles -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
      <style>
          body {
              font-family: 'Nunito';
              background-image: url('https://charlespeguymarseille.com/wp-content/uploads/2022/01/rez.jpg');
              background-size: cover;
              background-repeat: no-repeat;
              background-attachment: fixed;
          }
          .nav-link.active {
              /*font-weight: bold;*/
              color: #000 !important;
              border-bottom: 2px solid #000;
          }
      </style>
          @livewireStyles

  </head>
  <body>
      <div id="app">
          <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
              <div class="container">
                  <a class="navbar-brand" href="{{ url('/') }}">
                      {{ config('app.name', 'Laravel') }}
                  </a>
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                      <span class="navbar-toggler-icon"></span>
                  </button>

                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                      <!-- Left Side Of Navbar -->
                      <ul class="navbar-nav me-auto">

                      </ul>

                      <!-- Right Side Of Navbar -->
                      <ul class="navbar-nav ms-auto">
                          <!-- Authentication Links -->
                          @guest
                              @if (Route::has('login'))
                                  <li class="nav-item">
                                      <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">{{ __('Login') }}</a>
                                  </li>
                              @endif

                              @if (Route::has('register'))
                                  <li class="nav-item">
                                      <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">{{ __('Register') }}</a>
                                  </li>
                              @endif
                          @else
                          @if(Auth::user()->id == 1)
                            
                          
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('backoffice.pc.index') ? 'active' : '' }}" href="{{ route('backoffice.pc.index') }}">{{ __('Backoffice') }}</a>
                        </li>
                              @else
                              <li class="nav-item">
                                  <a class="nav-link {{ request()->routeIs('reservation') ? 'active' : '' }}" href="{{ route('reservation') }}">{{ __('Nouvelle réservation') }}</a>
                              </li>
                              
                          @endif
                          <li class="nav-item">
                              <a class="nav-link {{ request()->routeIs('reservations.listing') ? 'active' : '' }}" href="{{ route('reservations.listing') }}">{{ __('Reservations en attente') }}</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link {{ request()->routeIs('reservations.listing-valide') ? 'active' : '' }}" href="{{ route('reservations.listing-valide') }}">{{ __('Reservations validées') }}</a>
                          </li>
                              <li class="nav-item dropdown">
                                  <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                      {{ Auth::user()->name }}
                                  </a>

                                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                      <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                          {{ __('Logout') }}
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

          <main class="py-4" id="content">
              @yield('content')
          </main>
      </div>

      <!-- Scripts -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
      @livewireScripts
  </body>
  </html>