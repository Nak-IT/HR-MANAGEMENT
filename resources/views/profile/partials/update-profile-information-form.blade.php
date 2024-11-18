<!-- resources/views/profileNew/partials/update-profile-information-form.blade.php -->
<section class="profile-container">
    <!-- Header -->
    <div class="profile-header">
        <x-application-logo class="mx-auto" />
        <h2>ព័ត៌មានគណនី</h2>
        <p>ធ្វើការកែប្រែព័ត៌មានបុគ្គលរបស់អ្នកដើម្បីបន្ថែមព័ត៌មាន។</p>
    </div>

    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <!-- Name -->
        <div class="form-group">
            <label for="name">{{ __('ឈ្មោះ') }}</label>
            <input id="name" name="name" type="text" required autofocus
                class="form-group-input"
                placeholder="{{ __('ឧ. សុភ័ក្រ្ត') }}"
                value="{{ old('name', $user->name) }}">
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email">{{ __('អ៊ីមែល') }}</label>
            <input id="email" name="email" type="email" required
                class="form-group-input"
                placeholder="{{ __('ឧ. example@domain.com') }}"
                value="{{ old('email', $user->email) }}">
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4">
                    <p class="text-sm text-pink-600">
                        {{ __('អាសយដ្ឋានអ៊ីមែលរបស់អ្នកមិនទាន់ត្រូវបានបញ្ជាក់ទេ។') }}

                        <button form="send-verification" class="underline text-sm text-pink-600 hover:text-pink-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                            {{ __('ចុចទីនេះដើម្បីផ្ញើតំណភ្ជាប់បញ្ជាក់ម្ដងទៀត។') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-green-600">
                            {{ __('តំណភ្ជាប់បញ្ជាក់ថ្មីបានផ្ញើទៅអាសយដ្ឋានអ៊ីមែលរបស់អ្នករួច។') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Submit Button and Status Message -->
        <div class="flex items-center gap-4">
            <button type="submit" class="btn-submit">
                {{ __('រក្សាទុក') }}
            </button>

            @if (session('status') === 'profile-updated')
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

    <!-- Verification Form (Hidden) -->
    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>
    @endif
</section>
