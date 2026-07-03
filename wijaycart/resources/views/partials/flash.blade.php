@if(session('success'))
<div data-flash-toast="{{ session('success') }}" data-flash-type="success" class="hidden"></div>
@endif
@if(session('error'))
<div data-flash-toast="{{ session('error') }}" data-flash-type="error" class="hidden"></div>
@endif
@if(session('warning'))
<div data-flash-toast="{{ session('warning') }}" data-flash-type="warning" class="hidden"></div>
@endif
@if(session('info'))
<div data-flash-toast="{{ session('info') }}" data-flash-type="info" class="hidden"></div>
@endif
