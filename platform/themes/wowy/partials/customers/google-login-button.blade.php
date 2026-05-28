@if (Route::has('customer.google.login'))
<a href="{{ route('customer.google.login') }}"
   style="display:flex;align-items:center;justify-content:center;gap:10px;border:1.5px solid #e5e7eb;border-radius:10px;padding:11px 16px;background:#fff;color:#374151;font-size:14px;font-weight:600;text-decoration:none;width:100%;box-sizing:border-box;transition:border-color 0.18s,box-shadow 0.18s;font-family:inherit"
   onmouseover="this.style.borderColor='#4285F4';this.style.boxShadow='0 0 0 3px rgba(66,133,244,0.12)'"
   onmouseout="this.style.borderColor='#e5e7eb';this.style.boxShadow='none'">
    <img src="https://www.rubyshop.co.th/storage/logo/g-icon.png" alt="Google"
        style="height:20px;width:20px;object-fit:contain;flex-shrink:0" loading="lazy" decoding="async" />
    <span>{{ __('Continue with Google') }}</span>
</a>
@endif
