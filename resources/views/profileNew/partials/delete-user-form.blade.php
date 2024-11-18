<!-- resources/views/profileNew/partials/delete-user-form.blade.php -->
<section class="">
    <!-- Header -->
    <div class="profile-header">
        <x-application-logo class="mx-auto" />
        <h2>លុបគណនី</h2>
        <p>បញ្ជាក់ការលុបគណនីរបស់អ្នកដោយចុចប៊ូតុងខាងក្រោម</p>
    </div>

    <!-- Delete Account Button -->
    <button
        class="btn-danger"
        onclick="openModal('confirm-user-deletion')"
    >
        {{ __('លុបគណនី') }}
    </button>

    <!-- Confirmation Modal -->
    <div id="confirm-user-deletion" class="modal-overlay hidden">
        <div class="modal-content">
            <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-6">
                @csrf
                @method('delete')

                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('តើអ្នកប្រាកដជាចង់លុបគណនីរបស់អ្នកទេ?') }}
                </h2>

                <p class="text-sm text-gray-600">
                    {{ __('ការលុបគណនីនឹងលុបព័ត៌មាន និងទិន្នន័យទាំងអស់របស់អ្នកដោយចៃដន្យ។ សូមបញ្ចូលពាក្យសម្ងាត់របស់អ្នកដើម្បីបញ្ជាក់។') }}
                </p>

                <!-- Password Input -->
                <div class="form-group">
                    <label for="password" class="block text-pink-600 font-semibold mb-1">{{ __('ពាក្យសម្ងាត់') }}</label>
                    <input id="password" name="password" type="password" required
                        class="form-group-input"
                        placeholder="{{ __('******') }}">
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-4">
                    <button type="button" class="btn-secondary" onclick="closeModal('confirm-user-deletion')">
                        {{ __('បោះបង់') }}
                    </button>
                    <button type="submit" class="btn-danger">
                        {{ __('លុបគណនី') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- JavaScript for Modal Functionality -->
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    // Close modal when clicking outside the content
    window.onclick = function(event) {
        const modal = document.getElementById('confirm-user-deletion');
        if (event.target == modal) {
            modal.classList.add('hidden');
        }
    }
</script>
