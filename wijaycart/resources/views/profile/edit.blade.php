@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="mx-auto max-w-2xl px-4 py-8 sm:px-6 lg:px-8">
    <h1 class="section-title mb-8">Edit Profil</h1>

    <div class="card">
        @if($user->avatar)
        <form action="{{ route('profile.avatar.destroy') }}" method="POST" class="mb-4 hidden" id="avatar-delete-form">
            @csrf @method('DELETE')
        </form>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')

            {{-- Avatar --}}
            <div>
                <label class="mb-3 block text-sm font-medium">Foto Profil</label>
                <div class="flex flex-col items-start gap-4 sm:flex-row sm:items-center">
                    <img
                        id="avatar-preview"
                        src="{{ $user->avatar_url }}"
                        alt="Avatar {{ $user->name }}"
                        class="h-24 w-24 rounded-2xl border-2 border-border object-cover dark:border-dark-border"
                    >
                    <div class="flex flex-wrap gap-2">
                        <label class="btn-secondary cursor-pointer text-sm">
                            <i data-lucide="upload" class="h-4 w-4" aria-hidden="true"></i>
                            Upload Avatar
                            <input type="file" name="avatar" accept="image/jpeg,image/png,image/webp" class="sr-only" data-avatar-preview="avatar-preview">
                        </label>
                        @if($user->avatar)
                        <button
                            type="button"
                            class="btn-secondary text-sm text-danger"
                            data-confirm="Hapus foto profil?"
                            data-confirm-title="Hapus Avatar"
                            data-confirm-form="avatar-delete-form"
                        >
                            <i data-lucide="trash-2" class="h-4 w-4" aria-hidden="true"></i>
                            Hapus Avatar
                        </button>
                        @endif
                    </div>
                </div>
                <p class="mt-2 text-xs text-text/50 dark:text-dark-muted">Format: JPEG, PNG, WebP. Maksimal 2 MB.</p>
                @error('avatar')<p class="mt-1 text-sm text-danger">{{ $message }}</p>@enderror
            </div>

            <hr class="border-border dark:border-dark-border">

            <div>
                <label for="name" class="mb-1.5 block text-sm font-medium">Nama</label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" class="input-field" required>
                @error('name')<p class="mt-1 text-sm text-danger">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="email" class="mb-1.5 block text-sm font-medium">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" class="input-field" required>
                @error('email')<p class="mt-1 text-sm text-danger">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="phone" class="mb-1.5 block text-sm font-medium">No. Telepon</label>
                <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="input-field">
                @error('phone')<p class="mt-1 text-sm text-danger">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="address" class="mb-1.5 block text-sm font-medium">Alamat</label>
                <textarea id="address" name="address" rows="3" class="input-field">{{ old('address', $user->address) }}</textarea>
                @error('address')<p class="mt-1 text-sm text-danger">{{ $message }}</p>@enderror
            </div>
            <hr class="border-border dark:border-dark-border">
            <p class="text-sm text-text/60 dark:text-dark-muted">Kosongkan jika tidak ingin mengubah password.</p>
            <div>
                <label for="password" class="form-label">Password Baru</label>
                <x-password-input name="password" id="password" autocomplete="new-password" class="@error('password') border-danger @enderror" />
                @error('password')<p class="mt-1 text-sm text-danger">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <x-password-input name="password_confirmation" id="password_confirmation" autocomplete="new-password" />
            </div>
            <button type="submit" class="btn-accent">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
