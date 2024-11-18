
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>កែប្រែប្រវត្តិរូប - user</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/appUser.css') }}">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<header>
<nav class="nav-links custom-font007" style=" font-size: 18px; color: #000000;">
<a href="{{ url('/') }}">ទំព័រដើម</a>
                <a href="{{ route('profile.edit') }}">ព័ត៌មានគណនី</a>
                <a href="{{ route('users.index') }}">កំណត់សិទ្ធិUser</a>
                <a href="{{ route('dashboard') }}">ត្រឡប់ក្រោយ(Dashboard)</a>
                
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('ចេញពីប្រព័ន្ធ(Logout)') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>

                <div class="dropdown" style="display: flex; align-items: center; justify-content: center;">
                    <a class="dropdown-toggle " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                       
                        កំណត់Settings
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('backup.index') }}" style="color: #FF0000; font-size: 26px;">Backup and Restore Now</a></li>
                        <li><a class="dropdown-item" href="{{ route('backup.index_Auto') }}" style="color: #FF0000; font-size: 26px;">Backup and Restore Auto</a></li>
                    </ul>
                </div>
            </nav>
</header>

<div class="min-h-screen flex flex-col items-center justify-center bg-pink-50 py-12 px-4 sm:px-6 lg:px-8">
<div class="max-w-2xl w-full">
            <!-- Profile Edit Header -->
            <div class="profile-header mb-8 text-center">
                <a href="{{ url('/') }}">
                    <x-application-logo class="mx-auto" style="border: 5px dashed #FF0000; border-radius: 50%; padding: 10px; box-shadow: 0 0 10px rgba(0, 0, 255, 0.5); margin-top: 15%;" />
                </a>
                <h1 class="mt-4 text-3xl font-extrabold text-pink-600" style="color: #0000FF; border: 3px dashed #0000FF; padding: 10px; border-radius: 15px; box-shadow: 0 0 10px rgba(0, 0, 255, 0.5);">កំណត់សិទ្ធិUser(អ្នកចូលប្រើប្រាស់ប្រព័ន្ធ)</h1>
                <p class="mt-2 text-sm text-gray-600">ធ្វើការកែប្រែព័ត៌មានUserទីនេះ។</p>
            </div>
        @yield('content')
    </div>


</body>
<footer class="footer" >
        
        <p style="font-size: 10px; text-align: center; margin: 0; padding-top: 5px;">&copy; {{ date('Y') }} ប្រព័ន្ធគ្រប់គ្រងធនធានមនុស្សសម្រាប់មន្ទីរពេទ្យបាត់ដំបង។ រក្សាសិទ្ធិគ្រប់យ៉ាង។</p>
   
</footer>
</html>
<script>
    // Optional: Initialize dropdowns if needed (Bootstrap 4 or earlier)
    $(document).ready(function() {
        $('.dropdown-toggle').dropdown();
    });
</script>