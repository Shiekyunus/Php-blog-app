<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @auth
                            @if(auth()->user()->hasRole('Admin'))
                               <li class="nav-item">
                                <a class="nav-link {{request()->is('users*')?'active':''}}" href="{{route('users.index')}}">
                                    Users
                                </a>
                               </li>
                            @endif
                            @can('moderate comments')
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('comments*') ? 'active' : '' }}"
                                        href="{{ route('comments.pending') }}">
                                        {{ __('Comment') }}
                                    </a>
                                </li>
                            @endcan
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('articles*') ? 'active' : '' }}"
                                    href="{{ route('articles.index') }}">
                                    {{ __('Articles') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{request()->is('Liked*')? 'active':''}}" href="{{route('likes.index')}}">
                                    {{__('Liked Articles')}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{request()->is('Saved*') ? 'active':''}}" href="{{route('saved.index')}}">
                                    {{__('Saved Articles')}}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('categories*') ? 'active' : '' }}"
                                    href="{{ route('categories.index') }}">
                                    {{ __('Categories') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('tags*') ? 'active' : '' }}"
                                    href="{{ route('tags.index') }}">
                                    {{ __('Tags') }}
                                </a>
                            </li>

                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('feedback.create'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('feedback.create') }}">{{ __('Feedback') }}</a>
                                </li>
                            @endif
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                          <li class="nav-item me-3">
                             <form action="{{route('articles.search')}}" method="GET" class="d-flex">
                                <input type="text" name="q" class="form-control form-control-sm" placeholder="Search articles..." value="{{request('q')}}">
                                <button class="btn btn-primary btn-sm ms-1">Search</button>
                             </form>
                          </li>
                          <li class="nav-item dropdown me-3">
                            <a class="nav-link dropdown-toggle position-relative" href="{{route('notifications.index')}}" role="button">&#128276;
                               @if (auth()->user()->unreadNotifications->count())
                               <span class="badge bg-danger">
                                {{
                                    auth()->user()->unreadNotifications->count()
                                }}
                               </span>
                               @endif
                            </a>
                          </li>
                           @if (Route::has('feedback.sent'))
                                <li class="nav-item me-2">
                                    <a class="nav-link" href="{{ route('feedback.sent') }}">{{ __('Feedback') }}</a>
                                </li>
                            @endif
                            <li class="nav-item me-2">
                                @if (auth()->user()->subscription && auth()->user()->subscription->status == 'active')
                                    <form action="{{ route('unsubscribe') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            Unsubscribe
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('subscribe') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">
                                            Subscribe
                                        </button>
                                    </form>
                                @endif
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{route('profile.index')}}">
                                        Profile
                                    </a>
                                    @can('export articles')
                                    <a class="dropdown-item" href="{{route('export.csv')}}">Export CSV</a>
                                    <a class="dropdown-item" href="{{route('export.pdf')}}">Export PDF</a>
                                    @endcan
                                    @can('create backup')
                                    <a href="{{route('backup.create')}}" class="btn btn-danger">Create Backup</a>
                                    @endcan
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

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
