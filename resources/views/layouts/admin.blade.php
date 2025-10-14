<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin Panel</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        .border-left-primary { border-left: 4px solid #007bff !important; }
        .border-left-success { border-left: 4px solid #28a745 !important; }
        .border-left-info { border-left: 4px solid #17a2b8 !important; }
        .border-left-warning { border-left: 4px solid #ffc107 !important; }
        .border-left-danger { border-left: 4px solid #dc3545 !important; }
        .border-left-secondary { border-left: 4px solid #6c757d !important; }
        .text-gray-800 { color: #5a5c69 !important; }
        .text-gray-300 { color: #dddfeb !important; }
    </style>
    
    <!-- Vite - Load Laravel Echo for Realtime features -->
    @vite(['resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-shield-check"></i> Admin Panel
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        @can('manage-live-settings')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.live-settings.index') }}">
                                <i class="bi bi-broadcast"></i> Cài đặt Live
                            </a>
                        </li>
                        @endcan
                        @can('manage-users')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.users.index') }}">
                                <i class="bi bi-people"></i> Quản lý User
                            </a>
                        </li>
                        @endcan
                        @can('manage-keywords')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.keywords.index') }}">
                                <i class="bi bi-filter"></i> Từ khóa chặn
                            </a>
                        </li>
                        @endcan
                        @can('manage-chat')
                        <li class="nav-item">
                            @if(auth()->user()->hasRole('Nhân viên Live'))
                                <a class="nav-link" href="{{ route('live-staff.chat.index') }}">
                                    <i class="bi bi-chat-dots"></i> Quản lý Chat
                                </a>
                            @else
                                <a class="nav-link" href="{{ route('admin.chat.index') }}">
                                    <i class="bi bi-chat-dots"></i> Quản lý Chat
                                </a>
                            @endif
                        </li>
                        @endcan
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right"></i> {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container-fluid">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- jQuery (required for admin scripts) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
