<!-- resources/views/profileNew/partials/update-password-form.blade.php -->
<section class="profile-container">
    <!-- Header -->
    <div class="profile-header">
        <x-application-logo class="mx-auto" />
        <h2>ធ្វើបច្ចុប្បន្នភាពពាក្យសម្ងាត់</h2>
        <p>ធ្វើការផ្លាស់ប្តូរពាក្យសម្ងាត់របស់អ្នកដើម្បីបន្ថែមសុវត្ថិភាព។</p>
    </div>

    <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div class="form-group">
            <label for="current_password">{{ __('ពាក្យសម្ងាត់បច្ចុប្បន្ន') }}</label>
            <input id="current_password" name="current_password" type="password" required
                class="form-group-input"
                placeholder="{{ __('******') }}">
            @error('current_password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- New Password -->
        <div class="form-group">
            <label for="password">{{ __('ពាក្យសម្ងាត់ថ្មី') }}</label>
            <input id="password" name="password" type="password" required
                class="form-group-input"
                placeholder="{{ __('******') }}">
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm New Password -->
        <div class="form-group">
            <label for="password_confirmation">{{ __('បញ្ជាក់ពាក្យសម្ងាត់ថ្មី') }}</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required
                class="form-group-input"
                placeholder="{{ __('******') }}">
            @error('password_confirmation')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button and Status Message -->
        <div class="flex items-center gap-4">
            <button type="submit" class="btn-submit">
                {{ __('រក្សាទុក') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600"
                >
                    {{ __('បានរក្សាទុក។') }}
                </p>
            @endif
        </div>
    </form>
</section>
