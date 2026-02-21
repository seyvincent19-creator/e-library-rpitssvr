<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPITST E-Library</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/image/img_welcome/RPITST.png') }}">

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css"/>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @yield('head')

    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f6fb; }

        .user-navbar {
            background: linear-gradient(135deg, #1a237e 0%, #283593 100%);
            box-shadow: 0 2px 12px rgba(26,35,126,.25);
        }
        .user-navbar .navbar-brand {
            font-weight: 700;
            font-size: 1.15rem;
            color: #fff !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .user-navbar .navbar-brand img { width: 36px; height: 36px; border-radius: 50%; }
        .user-navbar .nav-link { color: rgba(255,255,255,.85) !important; font-weight: 500; }
        .user-navbar .nav-link.active, .user-navbar .nav-link:hover { color: #fff !important; }
        .user-navbar .btn-logout {
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.3);
            color: #fff;
            border-radius: 20px;
            padding: 5px 16px;
            font-size: .875rem;
            transition: background .2s;
        }
        .user-navbar .btn-logout:hover { background: rgba(255,255,255,.25); }

        .page-hero {
            background: linear-gradient(135deg, #1a237e 0%, #3949ab 100%);
            color: #fff;
            padding: 48px 0 36px;
        }
        .page-hero h1 { font-weight: 700; font-size: 1.8rem; }
        .page-hero p { opacity: .85; }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg user-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('assets/image/img_welcome/RPITST.png') }}" alt="Logo">
                RPITST E-Library
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#userNav">
                <i class="bi bi-list text-white fs-4"></i>
            </button>

            <div class="collapse navbar-collapse" id="userNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('user/dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
                            <i class="bi bi-house-door me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('user/books*') ? 'active' : '' }}" href="{{ url('user/books') }}">
                            <i class="bi bi-book me-1"></i>Books
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    @auth
                        <span class="text-white-50 small">
                            <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                        </span>
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="btn-logout">
                                <i class="bi bi-box-arrow-right me-1"></i>Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ url('login') }}" class="btn-logout text-decoration-none">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="bg-dark text-white-50 text-center py-3 mt-5">
        <small>&#169; 2026 វិទ្យាស្ថានពហុបច្ចេកទេស RPITST E-Library. រក្សាសិទ្ធិគ្រប់យ៉ាង។</small>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    @yield('scripts')
</body>
</html>
