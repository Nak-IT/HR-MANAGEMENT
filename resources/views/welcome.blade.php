<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ប្រព័ន្ធគ្រប់គ្រងធនធានមនុស្ស - សូមស្វាគមន៍</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Hanuman:wght@300;400;700&family=Moul&display=swap" rel="stylesheet">
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Hanuman', serif;
            background: linear-gradient(135deg, #f8f9fa 25%, #e9ecef 100%);
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar-brand {
            font-family: 'Moul', cursive;
            font-size: 1.5rem;
            color: #ff6f61 !important;
        }
        .welcome-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
        }
        .welcome-section h1 {
            font-family: 'Moul', cursive;
            font-size: 2.5rem;
            color: #343a40;
        }
        .welcome-section p {
            font-size: 1.2rem;
            color: #6c757d;
        }
        .btn-custom {
            background-color: #ff6f61;
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            border-radius: 50px;
            transition: background-color 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #ff4a3d;
        }
        .footer {
            background-color: #343a40;
            color: #ffffff;
            text-align: center;
            padding: 1rem 0;
        }
        /* Cute Icons */
        .icon {
            font-size: 2rem;
            color: #ff6f61;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">ប្រព័ន្ធគ្រប់គ្រងធនធានមនុស្សសម្រាប់មន្ទីរពេទ្យបាត់ដំបង</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    @if(Auth::check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">ផ្ទាំងគ្រប់គ្រង(Dashboard)</a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="nav-link btn btn-link" type="submit" style="color: #ff6f61; text-decoration: none;">
                                    ចាកចេញ(Logout)
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">ចូល(Login)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">ចុះឈ្មោះ(Register)</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Welcome Section -->
    <section class="welcome-section">
        <div class="container">
            <div class="text-center">
                <div class="icon">
                    <!-- Hospital logo with very cute styling -->
                    <img src="{{ asset('images/MxoxO3LyJcORpZNwtY8g.png') }}" alt="Khmer Hospital Logo" class="img-fluid" style="max-height: 400px; width: auto; border: 5px solid #ff69b4; border-radius: 50%; box-shadow: 0 0 20px rgba(255, 105, 180, 0.8); transform: rotate(-5deg); transition: all 0.3s ease;">
                </div>
                <div class="cute-decorations">
                    <span class="heart">❤️</span>
                    <span class="star">⭐</span>
                    <span class="flower">🌸</span>
                </div>
            </div>
                <h1 class="mb-3 custom-font007">សូមស្វាគមន៍មកកាន់ប្រព័ន្ធគ្រប់គ្រងធនធានមនុស្ស</h1>
                <p>ប្រព័ន្ធគ្រប់គ្រងធនធានមនុស្ស នៃក្រុមសារណាយើងខ្ញុំ ។</p>
                @if(Auth::check())
                    <a href="{{ route('dashboard') }}" class="btn btn-custom">ទៅកាន់ផ្ទាំងគ្រប់គ្រង(Dashboard)</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-custom me-2">ចូល(Login)</a>
                    <a href="{{ route('register') }}" class="btn btn-custom">ចុះឈ្មោះ(Register)</a>
                @endif
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} ប្រព័ន្ធគ្រប់គ្រងធនធានមនុស្សសម្រាប់មន្ទីរពេទ្យបាត់ដំបង។ រក្សាសិទ្ធិគ្រប់យ៉ាង។</p>
        </div>
    </footer>

    <!-- Bootstrap JS and dependencies (Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Optional: Include Font Awesome for additional icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
