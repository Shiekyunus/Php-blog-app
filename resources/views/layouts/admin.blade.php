<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Personal Blog</title>
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('about') }}" class="nav-link">About</a>
                </li>
            </ul>
            <form action="{{ route('articles.search') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            <ul class="navbar-nav ml-auto">

                @guest
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
                @endguest
                @auth
                    <li class="nav-item dropdown me-3">
                        <a class="nav-link dropdown-toggle position-relative" href="{{ route('notifications.index') }}"
                            role="button">&#128276;
                            @if ($unreadNotifications > 0)
                                <span class="badge badge-danger navbar-badge">
                                    {{ $unreadNotifications ?? 0 }}
                                </span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('profile.index') }}">
                                <i class="fas fa-user mr-2"></i> Profile</a>
                            <a class="dropdown-item" href="{{ route('password.request') }}">
                                <i class="fas fa-key mr-2"></i>{{ __('change password') }}
                            </a>
                            <div class="dropdown-divider"></div>
                            @can('export articles')
                                <a class="dropdown-item" href="{{ route('export.csv') }}"><i class="fas fa-file-csv mr-2"></i>
                                    CSV</a>
                                <a class="dropdown-item" href="{{ route('export.pdf') }}"><i class="fas fa-file-pdf mr-2"></i>
                                    PDF</a>
                            @endcan
                            @can('create backup')
                                <a href="{{ route('backup.create') }}" class="dropdown-item text-danger">
                                    <i class="fas fa-database mr-2"></i> Create Backup</a>
                            @endcan
                            <div class="dropdown-divider"></div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout</button>
                            </form>
                        </div>
                    </li>
                @endauth
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('dashboard') }}" class="brand-link">
                <span class="brand-text font-weight-light">My Blog Admin</span>
            </a>
            <div class="sidebar">
                <nav class="mt-3">
                    <ul class="nav nav-pills nav-sidebar flex-column">
                        @auth
                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}" class="nav-link">
                                    <i class="nav-icon fas fa-home"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>
                            @can('manage articles')
                                <li class="nav-item">
                                    <a href="{{ route('articles.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-newspaper"></i>
                                        <p>My Article</p>
                                    </a>
                                </li>
                            @endcan
                        @endauth
                        <li class="nav-header">CONTENT</li>
                        <li class="nav-item">
                            <a href="{{ route('categories.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-list"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('tags.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-tags"></i>
                                <p>Tags</p>
                            </a>
                        </li>
                        <li class="nav-header">ENGAGEMENT</li>
                        @auth
                            <li class="nav-item">
                                <a href="{{ route('saved.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-bookmark"></i>
                                    <p>Saved</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('likes.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-heart"></i>
                                    <p>Liked</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('feedback.sent') }}" class="nav-link">
                                    <i class="nav-icon fas fa-comment"></i>
                                    <p>Feedback</p>
                                </a>
                            </li>
                            @can('moderate comments')
                                <li class="nav-item">
                                    <a href="{{ route('comments.pending') }}" class="nav-link">
                                        <i class="navv-icon fas fa-newspaper"></i>
                                        <p>Moderate Comments
                                            @if ($pendingComments > 0)
                                                <span class="badge badge-warning">
                                                    {{ $pendingComments }}
                                                </span>
                                            @endif
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('manage users')
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-users"></i>
                                        <p>Users</p>
                                    </a>
                                </li>
                            @endcan
                        @endauth
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('feedback.create') }}">
                                    <i class="nav-icon fas fa-comment"></i>
                                    <p>Feedback</p>
                                </a>
                            </li>
                        @endguest
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper p-3">
            @yield('content')
        </div>
    </div>
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>
</body>

</html>
