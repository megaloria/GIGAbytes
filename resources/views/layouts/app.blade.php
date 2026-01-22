<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GIGAbytes') }} - @yield('title', 'Dashboard')</title>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar d-flex flex-column p-3" style="width: 250px;">
            <a href="{{ route('dashboard') }}" class="d-flex align-items-center mb-3 text-white text-decoration-none">
                <i class="bi bi-book-half fs-4 me-2"></i>
                <span class="fs-4 fw-bold">GIGAbytes</span>
            </a>
            <hr class="text-white">
            <ul class="nav nav-pills flex-column mb-auto">
                @auth
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="bi bi-speedometer2 me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                                <i class="bi bi-people me-2"></i> Users
                            </a>
                        </li>
                    @elseif(auth()->user()->isTeacher())
                        <li class="nav-item">
                            <a href="{{ route('teacher.dashboard') }}" class="nav-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
                                <i class="bi bi-speedometer2 me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('teacher.tasks.index') }}" class="nav-link {{ request()->routeIs('teacher.tasks*') ? 'active' : '' }}">
                                <i class="bi bi-list-task me-2"></i> Tasks
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('teacher.submissions') }}" class="nav-link {{ request()->routeIs('teacher.submissions*') ? 'active' : '' }}">
                                <i class="bi bi-file-earmark-check me-2"></i> Submissions
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('student.dashboard') }}" class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                                <i class="bi bi-speedometer2 me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('student.tasks') }}" class="nav-link {{ request()->routeIs('student.tasks*') ? 'active' : '' }}">
                                <i class="bi bi-list-task me-2"></i> Tasks
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('student.submissions') }}" class="nav-link {{ request()->routeIs('student.submissions*') ? 'active' : '' }}">
                                <i class="bi bi-file-earmark me-2"></i> My Submissions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('student.progress') }}" class="nav-link {{ request()->routeIs('student.progress') ? 'active' : '' }}">
                                <i class="bi bi-graph-up me-2"></i> Progress
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ route('leaderboard') }}" class="nav-link {{ request()->routeIs('leaderboard') ? 'active' : '' }}">
                            <i class="bi bi-trophy me-2"></i> Leaderboard
                        </a>
                    </li>
                @endauth
            </ul>
            <hr class="text-white">
            @auth
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle fs-4 me-2"></i>
                        <strong>{{ auth()->user()->name }}</strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-gear me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right me-2"></i>Sign out</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
        </nav>

        <!-- Main Content -->
        <div class="flex-grow-1">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h1">@yield('title', 'Dashboard')</span>
                    @auth
                        @if(auth()->user()->isStudent())
                            <div class="d-flex align-items-center">
                                <span class="badge badge-level me-2 px-3 py-2">
                                    <i class="bi bi-star-fill me-1"></i> Level {{ auth()->user()->level }}
                                </span>
                                <span class="badge badge-xp px-3 py-2">
                                    <i class="bi bi-lightning-fill me-1"></i> {{ auth()->user()->xp_points }} XP
                                </span>
                            </div>
                        @endif
                    @endauth
                </div>
            </nav>

            <!-- Page Content -->
            <main class="p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
