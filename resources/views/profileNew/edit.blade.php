
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ប្រព័ន្ធគ្រប់គ្រងធនធានមនុស្សសម្រាប់មន្ទីរពេទ្យបាត់ដំបង</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom-profile.css') }}">

    <!-- Optional: Include Font Awesome for additional icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-pap+1WlaJ+PzNX1N3B/oPrIBLgFhFlQeVyJqKnyrwqRMPyC9PFYQwH6xIibLYT7A/NbXcRkFw7e2kWgLqlCLQg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<header>
<nav class="nav-links custom-font007" style=" font-size: 18px; color: #000000;">
                <a href="{{ url('/') }}">ទំព័រដើម</a>
                <a href="{{ route('profile.edit') }}">ព័ត៌មានគណនី</a>
                <a href="{{ route('users.index') }}">កំណត់សិទ្ធិUser</a>
                <a href="{{ route('dashboard') }}">ត្រឡប់ក្រោយ(Dashboard)</a>
                <a  href="{{ route('backup.index') }}"> Backup Now</a>
                <a href="{{ route('backup.index_Auto') }}"> Backup Auto</a>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('ចេញពីប្រព័ន្ធ(Logout)') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </nav>
</header>
    <div class="min-h-screen flex flex-col items-center justify-center bg-pink-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full">
            <!-- Profile Edit Header -->
            <div class="profile-header mb-8 text-center">
            <div style="display: flex; justify-content: center; width: 115%;">
                <a href="{{ url('/') }}">
                    <x-application-logo class="mx-auto" style="border: 5px dashed #FF0000; border-radius: 50%; padding: 10px; box-shadow: 0 0 10px rgba(0, 0, 255, 0.5); margin-top: 65%;" />
                </a>
                </div>
                <div style="display: flex; justify-content: center; width: 115%;">
                <h1 class="mt-4 text-3xl font-extrabold text-pink-600" style="color: #0000FF; border: 3px dashed #0000FF; padding: 10px; border-radius: 15px; box-shadow: 0 0 10px rgba(0, 0, 255, 0.5); width: 100%;">កែប្រែព័ត៌មានគណនី</h1>
                
                </div>
                <p class="mt-2 text-sm text-gray-600">ធ្វើការកែប្រែព័ត៌មានរបស់អ្នកនៅទីនេះ។</p>
            </div>


            <!-- Update Profile Information -->
            <div class="profile-container mb-8 bg-white p-6 rounded-xl shadow-lg">
                @include('profileNew.partials.update-profile-information-form')
            </div>

            <!-- Update Password -->
            <div class="profile-container mb-8 bg-white p-6 rounded-xl shadow-lg">
                @include('profileNew.partials.update-password-form')
            </div>

            <!-- Delete User Account -->
            <div class="profile-container bg-white p-6 rounded-xl shadow-lg">
                @include('profileNew.partials.delete-user-form')
            </div>
        </div> <br><br><br><br><br><br><br><br>


    </div>
    <footer class="footer" >
        
            <p style="font-size: 10px; text-align: center; margin: 0; padding-top: 5px;">&copy; {{ date('Y') }} ប្រព័ន្ធគ្រប់គ្រងធនធានមនុស្សសម្រាប់មន្ទីរពេទ្យបាត់ដំបង។ រក្សាសិទ្ធិគ្រប់យ៉ាង។</p>
       
    </footer>
</body>
</html>
<link rel="stylesheet" type="text/css" href="{{ asset('css/Modal.css') }}">

