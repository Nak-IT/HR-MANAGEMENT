<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ចូល - HRCute</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom-login.css') }}">

    <!-- Optional: Include Font Awesome for additional icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-pap+1WlaJ+PzNX1N3B/oPrIBLgFhFlQeVyJqKnyrwqRMPyC9PFYQwH6xIibLYT7A/NbXcRkFw7e2kWgLqlCLQg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="login-container">
        <!-- Cute Illustration -->
        <div class="login-header">
        <a href="{{ url('/') }}">
            <x-application-logo class="w-24 h-24 mx-auto mb-4" style="border: 5px dashed #FF0000; border-radius: 50%; padding: 10px; box-shadow: 0 0 10px rgba(0, 0, 255, 0.5);" />
        </a>
            <h2 style="color: #0000FF; border: 3px dashed #0000FF; padding: 10px; border-radius: 15px; box-shadow: 0 0 10px rgba(0, 0, 255, 0.5);">ចូលទៅកាន់មន្ទីរពេទ្យ</h2>
            <p>សូមបំពេញព័ត៌មានដើម្បីចូលប្រើប្រាស់</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email">{{ __('អ៊ីមែល') }}</label>
                <input id="email" name="email" type="email" autocomplete="username" required
                    placeholder="ឧ. example@domain.com" value="{{ old('email') }}">
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">{{ __('ពាក្យសម្ងាត់') }}</label>
                <input id="password" name="password" type="password" autocomplete="current-password" required
                    placeholder="******">
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="remember-me">
                <input id="remember_me" type="checkbox" name="remember">
                <label for="remember_me">{{ __('ចងចាំខ្ញុំ') }}</label>
            </div>

            <!-- Forgot Password -->
            <div class="forgot-password">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        {{ __('ភ្លេចពាក្យសម្ងាត់?') }}
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="btn-submit">
                    {{ __('ចូល') }}
                </button>
            </div>
        </form>

        <!-- Optional: Register Link -->
        <div class="register-link">
            <p>
                {{ __("មិនមានគណនីមែនទេ?") }}
                <a href="{{ route('register') }}">
                    {{ __('ចុះឈ្មោះឥឡូវនេះ') }}
                </a>
            </p>
        </div>
    </div>
</body>
</html>
