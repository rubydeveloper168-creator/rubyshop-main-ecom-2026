@if (Route::has('line.login'))
<a href="{{ route('line.login') }}"
   style="display:flex;align-items:center;justify-content:center;gap:10px;border:1.5px solid #06C755;border-radius:10px;padding:11px 16px;background:#06C755;color:#fff;font-size:14px;font-weight:600;text-decoration:none;width:100%;box-sizing:border-box;transition:background 0.18s,box-shadow 0.18s;font-family:inherit"
   onmouseover="this.style.background='#05b04c';this.style.boxShadow='0 0 0 3px rgba(6,199,85,0.18)'"
   onmouseout="this.style.background='#06C755';this.style.boxShadow='none'">
    <img src="https://www.rubyshop.co.th/storage/home/sm-5b321ca4f02e2.jpg" alt="LINE"
        style="height:20px;width:20px;border-radius:4px;object-fit:cover;flex-shrink:0" loading="lazy" decoding="async" />
    <span>{{ __('Continue with LINE') }}</span>
</a>
@endif
