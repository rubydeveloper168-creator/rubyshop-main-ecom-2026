@once
<style>
/* ============================================================
   RUBY HERO — full-bleed video/image hero with overlay copy
   ============================================================ */
.ruby-hero {
    position: relative;
    width: 100%;
    overflow: hidden;
    background: #0d0d0d;
    color: #fff;
    min-height: 680px;
}

/* ── Media layer ── */
.ruby-hero__media {
    position: absolute;
    inset: 0;
    z-index: 1;
}
.ruby-hero__media video,
.ruby-hero__media img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}

/* ── Gradient overlay ── */
.ruby-hero__overlay {
    position: absolute;
    inset: 0;
    z-index: 2;
    background:
        linear-gradient(to bottom,
            rgba(0,0,0,0.08) 0%,
            rgba(0,0,0,0.30) 50%,
            rgba(0,0,0,0.72) 85%,
            rgba(0,0,0,0.82) 100%),
        linear-gradient(to right,
            rgba(0,0,0,0.55) 0%,
            rgba(0,0,0,0.20) 55%,
            rgba(0,0,0,0.0)  100%);
}

/* ── Content wrapper ── */
.ruby-hero__content {
    position: relative;
    z-index: 3;
    display: flex;
    align-items: center;
    min-height: 680px;
    padding: 48px 40px;
}
.ruby-hero__inner {
    width: 100%;
    max-width: 1480px;
    margin: 0 auto;
}
.ruby-hero__copy {
    max-width: 600px;
}

/* ── Eyebrow badge ── */
.ruby-hero__eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    border-radius: 999px;
    border: 1px solid rgba(255,255,255,0.22);
    background: rgba(255,255,255,0.10);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    padding: 7px 14px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.92);
    margin-bottom: 18px;
}
.ruby-hero__eyebrow-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #ef4444;
    flex-shrink: 0;
    box-shadow: 0 0 6px rgba(239,68,68,0.7);
}

/* ── Headline ── */
.ruby-hero__title {
    margin: 0 0 14px;
    font-size: clamp(2rem, 4.5vw, 3.6rem);
    font-weight: 900;
    line-height: 1.15;
    letter-spacing: -0.03em;
    color: #fff;
    text-shadow: 0 2px 20px rgba(0,0,0,0.4);
}

/* ── Subtitle / category pills ── */
.ruby-hero__subtitle {
    margin: 0 0 28px;
    font-size: clamp(0.95rem, 1.6vw, 1.05rem);
    line-height: 1.6;
    color: rgba(255,255,255,0.85);
}

/* ── CTA row ── */
.ruby-hero__actions {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
}
.ruby-hero__btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border-radius: 999px;
    background: #dc2626;
    color: #fff;
    font-size: 15px;
    font-weight: 800;
    padding: 16px 30px;
    text-decoration: none;
    letter-spacing: 0.01em;
    box-shadow: 0 8px 24px rgba(220,38,38,0.35);
    transition: background 0.18s, transform 0.18s, box-shadow 0.18s;
}
.ruby-hero__btn-primary:hover {
    background: #b91c1c;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(185,28,28,0.42);
    text-decoration: none;
}
.ruby-hero__btn-primary svg {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
    transition: transform 0.18s;
}
.ruby-hero__btn-primary:hover svg {
    transform: translateX(3px);
}
.ruby-hero__btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border-radius: 999px;
    border: 1.5px solid rgba(255,255,255,0.35);
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    color: rgba(255,255,255,0.92);
    font-size: 14px;
    font-weight: 600;
    padding: 15px 24px;
    text-decoration: none;
    transition: background 0.18s, border-color 0.18s;
}
.ruby-hero__btn-secondary:hover {
    background: rgba(255,255,255,0.15);
    border-color: rgba(255,255,255,0.55);
    color: #fff;
    text-decoration: none;
}

/* ── Trust signals ── */
.ruby-hero__trust {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 16px;
}
.ruby-hero__trust-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12.5px;
    font-weight: 600;
    color: rgba(255,255,255,0.78);
    letter-spacing: 0.02em;
}
.ruby-hero__trust-icon {
    width: 16px;
    height: 16px;
    color: #4ade80;
    flex-shrink: 0;
}

/* ── Tablet ── */
@media (max-width: 1024px) {
    .ruby-hero { min-height: 520px; }
    .ruby-hero__content { min-height: 520px; padding: 36px 24px; }
    .ruby-hero__copy { margin: 0 auto; max-width: 100%; }
}

/* ── Mobile ── */
@media (max-width: 767px) {
    .ruby-hero {
        min-height: 460px;
    }
    .ruby-hero__overlay {
        background:
            linear-gradient(to bottom,
                rgba(0,0,0,0.05) 0%,
                rgba(0,0,0,0.18) 35%,
                rgba(0,0,0,0.72) 70%,
                rgba(0,0,0,0.88) 100%);
    }
    .ruby-hero__content {
        min-height: 460px;
        align-items: flex-end;
        padding: 0 16px 28px;
    }
    .ruby-hero__copy {
        max-width: 100%;
        text-align: left;
    }
    .ruby-hero__eyebrow {
        font-size: 10px;
        padding: 6px 11px;
        margin-bottom: 12px;
    }
    .ruby-hero__title {
        font-size: clamp(1.45rem, 6vw, 1.75rem);
        margin-bottom: 8px;
        letter-spacing: -0.02em;
    }
    .ruby-hero__subtitle {
        font-size: 13px;
        margin-bottom: 16px;
        color: rgba(255,255,255,0.80);
    }
    .ruby-hero__actions {
        gap: 8px;
        margin-bottom: 16px;
    }
    .ruby-hero__btn-primary {
        font-size: 13.5px;
        padding: 13px 22px;
        box-shadow: 0 6px 16px rgba(220,38,38,0.35);
    }
    .ruby-hero__btn-secondary {
        display: none;
    }
    .ruby-hero__trust {
        gap: 12px;
    }
    .ruby-hero__trust-item {
        font-size: 11.5px;
        gap: 4px;
    }
}

@media (prefers-reduced-motion: reduce) {
    .ruby-hero__btn-primary,
    .ruby-hero__btn-secondary { transition: none; }
}
</style>
@endonce

@php
    use Botble\Base\Facades\BaseHelper;
    use Botble\Media\Facades\RvMedia;
    use Illuminate\Support\Arr;

    $attributes = $attributes ?? [];

    $desktopVideo   = Arr::get($attributes, 'desktop_video');
    $desktopPoster  = Arr::get($attributes, 'desktop_poster');
    $mobileImage    = Arr::get($attributes, 'mobile_image');
    $defaultImage   = RvMedia::getDefaultImage();

    $desktopVideoUrl = $desktopVideo ? RvMedia::url($desktopVideo) : null;
    $desktopPosterUrl = $desktopPoster
        ? RvMedia::getImageUrl($desktopPoster, null, false, $defaultImage)
        : ($mobileImage ? RvMedia::getImageUrl($mobileImage, null, false, $defaultImage) : $defaultImage);
    $mobileImageUrl = $mobileImage
        ? RvMedia::getImageUrl($mobileImage, 'medium', false, $defaultImage)
        : $desktopPosterUrl;
    $mobileImageUrlFull = $mobileImage
        ? RvMedia::getImageUrl($mobileImage, null, false, $defaultImage)
        : $desktopPosterUrl;

    $eyebrow    = Arr::get($attributes, 'eyebrow')      ?: 'RUBYSHOP · เครื่องมือช่างมืออาชีพ';
    $title      = Arr::get($attributes, 'title')        ?: 'เครื่องพ่นสีและ<br>เครื่องมือช่างมืออาชีพ';
    $subtitle   = Arr::get($attributes, 'subtitle')     ?: 'พ่นสี · พ่นปูน · กรีดผนัง · เครื่องมือครบครัน';
    $buttonText = Arr::get($attributes, 'button_text')  ?: 'เลือกซื้อเลย';
    $buttonLink = Arr::get($attributes, 'button_link')  ?: '/products';
    $btn2Text   = Arr::get($attributes, 'button2_text') ?: 'ดูหมวดหมู่';
    $btn2Link   = Arr::get($attributes, 'button2_link') ?: '/product-categories';
    $hasAction  = filled($buttonText) && filled($buttonLink);
@endphp

<section class="ruby-hero" aria-label="Hero">
    {{-- Desktop media --}}
    <div class="ruby-hero__media hidden md:block">
        @if ($desktopVideoUrl)
            <video autoplay muted loop playsinline preload="auto"
                disablepictureinpicture disableremoteplayback
                controlslist="nodownload,nofullscreen,noremoteplayback"
                poster="{{ $desktopPosterUrl }}">
                <source src="{{ $desktopVideoUrl }}" type="video/mp4">
            </video>
        @else
            <img src="{{ $desktopPosterUrl }}"
                 alt="{{ BaseHelper::clean($title) }}"
                 loading="eager" fetchpriority="high" decoding="async">
        @endif
    </div>

    {{-- Mobile media --}}
    <div class="ruby-hero__media md:hidden">
        <img src="{{ $mobileImageUrl }}"
             srcset="{{ $mobileImageUrl }} 768w, {{ $mobileImageUrlFull }} 1600w"
             sizes="100vw"
             alt="{{ BaseHelper::clean($title) }}"
             loading="eager" fetchpriority="high" decoding="async">
    </div>

    <div class="ruby-hero__overlay" aria-hidden="true"></div>

    <div class="ruby-hero__content">
        <div class="ruby-hero__inner">
            <div class="ruby-hero__copy">

                {{-- Eyebrow badge --}}
                <div class="ruby-hero__eyebrow">
                    <span class="ruby-hero__eyebrow-dot" aria-hidden="true"></span>
                    {{ $eyebrow }}
                </div>

                {{-- Headline --}}
                @if ($title)
                    <h1 class="ruby-hero__title">{!! BaseHelper::clean($title) !!}</h1>
                @endif

                {{-- Subtitle --}}
                @if ($subtitle)
                    <p class="ruby-hero__subtitle">{!! BaseHelper::clean($subtitle) !!}</p>
                @endif

                {{-- CTAs --}}
                @if ($hasAction)
                    <div class="ruby-hero__actions">
                        <a href="{{ $buttonLink }}" class="ruby-hero__btn-primary">
                            {{ $buttonText }}
                            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M3 8h10M9 4l4 4-4 4"/>
                            </svg>
                        </a>
                        @if (filled($btn2Text) && filled($btn2Link))
                            <a href="{{ $btn2Link }}" class="ruby-hero__btn-secondary">{{ $btn2Text }}</a>
                        @endif
                    </div>
                @endif

                {{-- Trust signals --}}
                <div class="ruby-hero__trust">
                    <span class="ruby-hero__trust-item">
                        <svg class="ruby-hero__trust-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 8l4 4 8-8"/></svg>
                        ส่งทั่วไทย
                    </span>
                    <span class="ruby-hero__trust-item">
                        <svg class="ruby-hero__trust-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 8l4 4 8-8"/></svg>
                        รับประกันคุณภาพ
                    </span>
                    <span class="ruby-hero__trust-item">
                        <svg class="ruby-hero__trust-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 8l4 4 8-8"/></svg>
                        ช่างมืออาชีพใช้จริง
                    </span>
                </div>

            </div>
        </div>
    </div>
</section>
