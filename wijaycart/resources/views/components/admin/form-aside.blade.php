@props(['title' => 'Informasi'])

<aside class="admin-form-aside">
    <p class="admin-form-aside-title">{{ $title }}</p>
    <div class="space-y-4">
        {{ $slot }}
    </div>
</aside>
