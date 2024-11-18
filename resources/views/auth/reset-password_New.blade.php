<!-- resources/views/auth/reset-password.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>កំណត់ពាក្យសម្ងាត់ឡើងវិញ - HR Managerment</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom-profile.css') }}">

    <!-- Optional: Include Font Awesome for additional icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-pap+1WlaJ+PzNX1N3B/oPrIBLgFhFlQeVyJqKnyrwqRMPyC9PFYQwH6xIibLYT7A/NbXcRkFw7e2kWgLqlCLQg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo">
            <!-- <x-application-logo class="mx-auto" /> -->
            <span class="ml-2 text-xl font-bold text-pink-600">HR Managerment</span>
        </div>
        <nav class="nav-links">
            <a href="{{ url('/') }}">ទំព័រដើម</a>
            <a href="{{ route('login') }}">ចូលប្រព័ន្ធ</a>
            <a href="{{ route('register') }}">បង្កើតគណនីថ្មី</a>
        </nav>
    </header>

    <!-- Main Content -->
    <div class="flex-grow">
        <div class="py-12">
            <div class="max-w-md mx-auto">
                <!-- Reset Password Form -->
                <div class="profile-container">
                    <!-- Header Section -->
                    <div class="profile-header">
                        <x-application-logo class="mx-auto" />
                        <h2>កំណត់ពាក្យសម្ងាត់ឡើងវិញ</h2>
                        <p>សូមបញ្ចូលអ៊ីមែល និងពាក្យសម្ងាត់ថ្មីរបស់អ្នក។</p>
                    </div>

                    <!-- Reset Password Form -->
                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email Address -->
                        <div class="form-group">
                            <label for="email">{{ __('អ៊ីមែល') }}</label>
                            <input id="email" name="email" type="email" required autofocus
                                class="form-group-input"
                                placeholder="{{ __('ឧ. example@domain.com') }}"
                                value="{{ old('email', $request->email) }}">
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">{{ __('ពាក្យសម្ងាត់') }}</label>
                            <input id="password" name="password" type="password" required
                                class="form-group-input"
                                placeholder="{{ __('******') }}"
                                autocomplete="new-password">
                            @error('password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="password_confirmation">{{ __('បញ្ជាក់ពាក្យសម្ងាត់') }}</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                class="form-group-input"
                                placeholder="{{ __('******') }}"
                                autocomplete="new-password">
                            @error('password_confirmation')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="btn-submit">
                                {{ __('កំណត់ពាក្យសម្ងាត់ឡើងវិញ') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; {{ date('Y') }} HR Managerment. {{ __('រក្សារសិទ្ធ្ធិ។') }}</p>
    </footer>
</body>
</html>
