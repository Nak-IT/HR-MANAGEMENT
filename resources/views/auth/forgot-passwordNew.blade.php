<!-- resources/views/auth/forgot-password.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ភ្លេចពាក្យសម្ងាត់ - HR Managerment</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/forgot-password.css') }}">

    <!-- Optional: Include Font Awesome for additional icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-pap+1WlaJ+PzNX1N3B/oPrIBLgFhFlQeVyJqKnyrwqRMPyC9PFYQwH6xIibLYT7A/NbXcRkFw7e2kWgLqlCLQg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo">
            <x-application-logo class="mx-auto" />
            <span>HR Managerment</span>
        </div>
        <nav class="nav-links">
            <a href="{{ url('/') }}">ទំព័រដើម</a>
            <a href="{{ route('login') }}">ចូលប្រព័ន្ធ</a>
            <a href="{{ route('register') }}">បង្កើតគណនីថ្មី</a>
        </nav>
    </header>

    <!-- Main Content -->
    <div class="forgot-password-container">
        <!-- Header Section within Container -->
        <div class="forgot-password-header">
            <x-application-logo class="mx-auto" />
            <h2>ភ្លេចពាក្យសម្ងាត់</h2>
            <p>សូមបញ្ចូលអ៊ីមែលរបស់អ្នក ដើម្បីយើងអាចផ្ញើតំណភ្ជាប់កំណត់ពាក្យសម្ងាត់ឡើងវិញទៅកាន់អ្នក។</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Forgot Password Form -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email">{{ __('អ៊ីមែល') }}</label>
                <input id="email" name="email" type="email" required autofocus
                    class="form-group-input"
                    placeholder="{{ __('ឧ. example@domain.com') }}"
                    value="{{ old('email') }}">
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="btn-submit">
                    {{ __('ផ្ញើតំណភ្ជាប់កំណត់ពាក្យសម្ងាត់ឡើងវិញ') }}
                </button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; {{ date('Y') }} HR Managerment. {{ __('ទាំងអស់សិទ្ធិនៅស្រាប់។') }}</p>
    </footer>
</body>
</html>
