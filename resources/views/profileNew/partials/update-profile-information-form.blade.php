<section class="">
    <!-- Header -->
    <div class="profile-header">
        <x-application-logo class="mx-auto" />
        <h2>ព័ត៌មានគណនី</h2>
        <p>ធ្វើការកែប្រែព័ត៌មានបុគ្គលរបស់អ្នកដើម្បីបន្ថែមព័ត៌មាន។</p>
    </div>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('patch')

        <!-- Name -->
        <div class="form-group">
            <label for="name">{{ __('ឈ្មោះ') }}</label>
            <input id="name" name="name" type="text" required autofocus
                class="form-group-input"
                placeholder="{{ __('ឧ. ពៅ មុនី') }}"
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
                placeholder="{{ __('ឧ. povmuny@domain.com') }}"
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

        <!-- Profile Picture Upload -->
        <div class="form-group">
            <label for="profile_picture">{{ __('រូបភាពប្រវត្តិរូប') }}</label>
            <input id="profile_picture" name="profile_picture" type="file" accept="image/*" class="form-group-input">
            @error('profile_picture')
                <div class="error-message">{{ $message }}</div>
            @enderror

            <!-- Preview Selected Profile Picture -->
            <div class="mt-2">
              
                <div style="display: flex; justify-content: center;">
                    <img id="profile_picture_preview" src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/user.png') }}" alt="Profile Picture" style="max-width: 150px; max-height: 150px; object-fit: cover;">
                </div>

            </div>
        </div>

        <!-- Cover Photo Upload -->
        <div class="form-group">
            <label for="cover_photo">{{ __('រូបភាពគម្រប') }}</label>
            <input id="cover_photo" name="cover_photo" type="file" accept="image/*" class="form-group-input">
            @error('cover_photo')
                <div class="error-message">{{ $message }}</div>
            @enderror

            <!-- Preview Selected Cover Photo -->
            <div class="mt-2">
                <div style="display: flex; justify-content: center;">
                    <img id="cover_photo_preview" src="{{ $user && $user->cover_photo ? asset('storage/' . $user->cover_photo) : asset('images/personal.png') }}" alt="Cover Photo" style="max-width: 150px; max-height: 150px; object-fit: cover;">
                </div>
            </div>
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
</section>

<script>
    document.getElementById('profile_picture').addEventListener('change', function(event) {
        previewImage(event, 'profile_picture_preview');
    });

    document.getElementById('cover_photo').addEventListener('change', function(event) {
        previewImage(event, 'cover_photo_preview');
    });

    function previewImage(event, previewId) {
        const input = event.target;
        const preview = document.getElementById(previewId);

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = previewId === 'profile_picture_preview' 
                ? "{{ asset('images/personal.png') }}" 
                : "{{ asset('images/user.png') }}";
        }
    }
</script>
