<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Water Supply') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap 5 CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Custom styles -->
        <style>
            body {
                background-color: #f8f9fa;
                min-height: 100vh;
            }
            .main-container {
                padding: 1.5rem;
                width: 100%;
                max-width: 1400px; /* Increased max-width for better use of space */
                margin: 0 auto;
            }
            .navbar {
                padding: 1rem 0;
            }
            .navbar-brand {
                font-size: 1.5rem;
            }
            .nav-link {
                color: #495057;
                padding: 0.5rem 1rem;
            }
            .nav-link.active {
                font-weight: 500;
                color: #0d6efd;
                background-color: rgba(13, 110, 253, 0.1);
                border-radius: 0.375rem;
            }
            .content-wrapper {
                padding: 1.5rem;
                background-color: #fff;
                border-radius: 0.5rem;
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            }
            .stat-card {
                background-color: #f8f9fa;
                border: none;
                border-radius: 0.5rem;
                padding: 1.5rem;
            }
            .stat-number {
                font-size: 2rem;
                font-weight: 600;
            }
            .stat-label {
                color: #6c757d;
                font-size: 0.9rem;
            }
            .activity-item {
                padding: 1rem;
                border-bottom: 1px solid #e9ecef;
            }
            .activity-item:last-child {
                border-bottom: none;
            }
            .activity-title {
                font-weight: 500;
            }
            .activity-time {
                color: #6c757d;
                font-size: 0.85rem;
            }
        </style>
    </head>
    <body>
        <div class="min-h-screen bg-gray-100">
            <!-- Navigation Bar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
                <div class="container-fluid px-4">
                    <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">Water Supply</a>
                    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <div class="collapse navbar-collapse" id="navbarMain">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" href="{{ route('customers.index') }}">Customers</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('bills.*') ? 'active' : '' }}" href="{{ route('bills.index') }}">Bills</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('bottles.*') ? 'active' : '' }}" href="{{ route('bottles.index') }}">Bottles</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}" href="{{ route('inventory.index') }}">Inventory</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('staff.*') ? 'active' : '' }}" href="{{ route('staff.index') }}">Staff</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('trucks.*') ? 'active' : '' }}" href="{{ route('trucks.index') }}">Trucks</a>
                            </li>
                        </ul>
                        
                        <div class="dropdown">
                            <button class="btn btn-link dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                @auth
                                    {{ Auth::user()->name ?? 'Guest' }}
                                @else
                                    Guest
                                @endauth
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                @auth
                                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Logout</button>
                                        </form>
                                    </li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="main-container">
                <div class="content-wrapper">
                    @yield('content')
                </div>
            </main>
        </div>
    </body>
</html>