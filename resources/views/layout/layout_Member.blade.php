<script type="text/javascript" src="{{ asset('lib/Print/printThis.js') }}"></script>

</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Default Title')</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Additional head elements -->
    @stack('head')
</head>
<body>
    <div id="app">
        <!-- Header -->
        @include('partials.header_Member')

        <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('ajax_product')}}">AJAX Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('PersonalInfoEmp')}}">Personal Info Emp</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('identifications')}}">Identification</a>
                    </li>
                </ul>
            </div>
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        @include('partials.footer_A_M_M')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Additional scripts -->
    @stack('scripts')
</body>
</html>
