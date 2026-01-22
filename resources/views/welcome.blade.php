<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GIGAbytes - Growth and Improvement of Grammar and Articulation</title>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .hero-section {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            min-height: 100vh;
        }
        .feature-icon {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 2rem;
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section text-white">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark py-3">
                <a class="navbar-brand fs-4 fw-bold" href="/">
                    <i class="bi bi-book-half me-2"></i>GIGAbytes
                </a>
                <div class="ms-auto">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-light me-2">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-light">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </nav>

            <div class="row align-items-center py-5" style="min-height: 80vh;">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">
                        Growth and Improvement of Grammar and Articulation
                    </h1>
                    <p class="lead mb-4">
                        Enhance your English speaking and writing skills through gamified digital learning.
                        Earn XP, unlock badges, and climb the leaderboard!
                    </p>
                    <div class="d-flex gap-3">
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4">
                                <i class="bi bi-rocket-takeoff me-2"></i>Get Started
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4">
                                Log in
                            </a>
                        @else
                            <a href="{{ url('/dashboard') }}" class="btn btn-light btn-lg px-4">
                                <i class="bi bi-speedometer2 me-2"></i>Go to Dashboard
                            </a>
                        @endguest
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <i class="bi bi-mortarboard-fill" style="font-size: 15rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container py-5">
            <h2 class="text-center fw-bold mb-5">How It Works</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-primary text-white mx-auto mb-4">
                                <i class="bi bi-mic"></i>
                            </div>
                            <h5>Speaking Tasks</h5>
                            <p class="text-muted">
                                Record video responses to prompts and improve your pronunciation, fluency, and confidence.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-success text-white mx-auto mb-4">
                                <i class="bi bi-pencil"></i>
                            </div>
                            <h5>Writing Tasks</h5>
                            <p class="text-muted">
                                Complete writing prompts and grammar exercises to strengthen your written communication.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-warning text-dark mx-auto mb-4">
                                <i class="bi bi-trophy"></i>
                            </div>
                            <h5>Earn Rewards</h5>
                            <p class="text-muted">
                                Gain XP, level up, earn badges, and compete on the leaderboard with other students.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SDG Section -->
    <section class="py-5">
        <div class="container py-5">
            <h2 class="text-center fw-bold mb-5">Supporting Sustainable Development Goals</h2>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="text-center">
                        <div class="rounded-circle bg-danger text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <span class="fw-bold">4</span>
                        </div>
                        <h6>Quality Education</h6>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <div class="rounded-circle bg-warning text-dark d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <span class="fw-bold">9</span>
                        </div>
                        <h6>Industry & Innovation</h6>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <div class="rounded-circle text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; background-color: #dd1367;">
                            <span class="fw-bold">10</span>
                        </div>
                        <h6>Reduced Inequalities</h6>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <span class="fw-bold">17</span>
                        </div>
                        <h6>Partnerships</h6>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-1">
                <i class="bi bi-book-half me-2"></i><strong>Project GIGAbytes</strong>
            </p>
            <p class="text-muted small mb-0">
                College of Education and Liberal Arts, Lipa City Colleges
            </p>
        </div>
    </footer>
</body>
</html>
