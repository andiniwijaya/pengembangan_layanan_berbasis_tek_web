@if (session('success'))
    <div data-flash-modal="{{ session('success') }}" data-flash-type="success" class="hidden" aria-hidden="true"></div>
@endif
@if (session('error'))
    <div data-flash-modal="{{ session('error') }}" data-flash-type="error" class="hidden" aria-hidden="true"></div>
@endif
@if (session('warning'))
    <div data-flash-modal="{{ session('warning') }}" data-flash-type="warning" class="hidden" aria-hidden="true"></div>
@endif
@if (session('info'))
    <div data-flash-modal="{{ session('info') }}" data-flash-type="info" class="hidden" aria-hidden="true"></div>
@endif
@if ($errors->any())
    <div
        data-flash-modal="{{ $errors->first() }}"
        data-flash-type="error"
        data-flash-title="Validasi Gagal"
        class="hidden"
        aria-hidden="true"
    ></div>
@endif
