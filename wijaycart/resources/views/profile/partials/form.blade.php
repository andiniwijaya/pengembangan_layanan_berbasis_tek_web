@props(['user'])

@if ($user->avatar)
    <form action="{{ route('profile.avatar.destroy') }}" method="POST" class="hidden" id="avatar-delete-form">
        @csrf
        @method('DELETE')
    </form>
@endif

<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profile-form">
    @csrf
    @method('PUT')

    <div class="space-y-8">
        {{-- Avatar --}}
        <section>
            <h3 class="mb-4 flex items-center gap-2 text-sm font-semibold uppercase tracking-wider text-text/50 dark:text-dark-muted">
                <i data-lucide="image" class="h-4 w-4 text-accent dark:text-primary" aria-hidden="true"></i>
                Foto Profil
            </h3>
            <div class="flex flex-col items-center gap-5 sm:flex-row sm:items-start">
                <img id="avatar-preview" src="{{ $user->avatar_url }}" alt="Avatar {{ $user->name }}"
                    class="h-28 w-28 rounded-2xl border-2 border-primary/40 object-cover shadow-sm ring-4 ring-primary/15">
                <div class="flex-1 space-y-3 text-center sm:text-left">
                    <p class="text-sm text-text/70 dark:text-dark-muted">Unggah foto profil agar akun Anda lebih personal.</p>
                    <div class="flex flex-wrap justify-center gap-2 sm:justify-start">
                        <label class="btn-secondary cursor-pointer text-sm">
                            <i data-lucide="upload" class="h-4 w-4" aria-hidden="true"></i>
                            Pilih Foto
                            <input type="file" name="avatar" accept="image/jpeg,image/png,image/webp" class="sr-only"
                                data-avatar-preview="avatar-preview">
                        </label>
                        @if ($user->avatar)
                            <button type="button" class="btn-secondary text-sm text-danger" data-confirm="Hapus foto profil?"
                                data-confirm-title="Hapus Avatar" data-confirm-form="avatar-delete-form">
                                <i data-lucide="trash-2" class="h-4 w-4" aria-hidden="true"></i>
                                Hapus
                            </button>
                        @endif
                    </div>
                    <p class="text-xs text-text/50 dark:text-dark-muted">JPEG, PNG, atau WebP · maks. 2 MB</p>
                    @error('avatar')
                        <p class="text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </section>

        {{-- Data pribadi --}}
        <section>
            <h3 class="mb-4 flex items-center gap-2 text-sm font-semibold uppercase tracking-wider text-text/50 dark:text-dark-muted">
                <i data-lucide="user" class="h-4 w-4 text-accent dark:text-primary" aria-hidden="true"></i>
                Informasi Akun
            </h3>
            <div class="grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="name" class="form-label">Nama Lengkap <span class="form-required">*</span></label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" class="input-field"
                        required>
                    @error('name')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="email" class="form-label">Email <span class="form-required">*</span></label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" class="input-field"
                        required>
                    @error('email')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="phone" class="form-label">No. Telepon</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="input-field" placeholder="08xxxxxxxxxx">
                    @error('phone')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="sm:col-span-2">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea id="address" name="address" rows="3" class="input-field"
                        placeholder="Alamat lengkap untuk pengiriman pesanan">{{ old('address', $user->address) }}</textarea>
                    <p class="form-helper">Digunakan saat checkout agar pengisian lebih cepat.</p>
                    @error('address')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </section>

        {{-- Password --}}
        <section>
            <h3 class="mb-1 flex items-center gap-2 text-sm font-semibold uppercase tracking-wider text-text/50 dark:text-dark-muted">
                <i data-lucide="lock" class="h-4 w-4 text-accent dark:text-primary" aria-hidden="true"></i>
                Keamanan
            </h3>
            <p class="mb-4 text-sm text-text/60 dark:text-dark-muted">Kosongkan jika tidak ingin mengubah password.</p>
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="password" class="form-label">Password Baru</label>
                    <x-password-input name="password" id="password" autocomplete="new-password"
                        class="@error('password') border-danger @enderror" />
                    @error('password')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <x-password-input name="password_confirmation" id="password_confirmation"
                        autocomplete="new-password" />
                </div>
            </div>
        </section>
    </div>
</form>
