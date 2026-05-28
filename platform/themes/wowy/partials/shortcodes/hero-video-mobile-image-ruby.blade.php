@once
    <style>
        .ruby-hero-video-mobile {
            position: relative;
            overflow: clip;
            width: 100%;
            background: #000;
            color: #fff;
            min-height: 800px;
        }

        .ruby-hero-video-mobile__media {
            position: absolute;
            inset: 0;
            z-index: 1;
        }

        .ruby-hero-video-mobile__media video,
        .ruby-hero-video-mobile__media img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center center;
        }

        .ruby-hero-video-mobile__overlay {
            position: absolute;
            inset: 0;
            z-index: 2;
            background:
                linear-gradient(180deg, rgba(0, 0, 0, 0.08) 0%, rgba(0, 0, 0, 0.45) 100%),
                linear-gradient(90deg, rgba(0, 0, 0, 0.62) 0%, rgba(0, 0, 0, 0.25) 44%, rgba(0, 0, 0, 0.06) 100%);
        }

        .ruby-hero-video-mobile__content {
            position: relative;
            z-index: 3;
            display: flex;
            align-items: center;
            min-height: 800px;
            padding: 24px;
        }

        .ruby-hero-video-mobile__inner {
            width: 100%;
            max-width: 1520px;
            margin: 0 auto;
        }

        .ruby-hero-video-mobile__copy {
            width: 100%;
            max-width: 652px;
        }

        .ruby-hero-video-mobile__eyebrow {
            display: inline-flex;
            align-items: center;
            border-radius: 9999px;
            border: 1px solid rgba(255, 255, 255, 0.20);
            background: rgba(255, 255, 255, 0.10);
            padding: 8px 14px;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(10px);
        }

        .ruby-hero-video-mobile__title {
            margin: 18px 0 0;
            font-size: clamp(2rem, 5.2vw, 5rem);
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -0.03em;
            color: #fff;
        }

        .ruby-hero-video-mobile__subtitle {
            margin: 16px 0 0;
            max-width: 620px;
            font-size: clamp(0.98rem, 2vw, 1.15rem);
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.90);
        }

        .ruby-hero-video-mobile__actions {
            margin-top: 28px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .ruby-hero-video-mobile__button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            background: #ed1d24;
            color: #fff;
            font-size: 15px;
            font-weight: 800;
            line-height: 1;
            padding: 21px 32px;
            text-decoration: none;
            transition:
                background-color 180ms ease-in-out,
                transform 180ms ease-in-out,
                box-shadow 180ms ease-in-out,
                font-weight 180ms ease-in-out;
            box-shadow: 0 10px 24px rgba(237, 29, 36, 0.24);
        }

        .ruby-hero-video-mobile__button:hover {
            background: #c91920;
            color: #fff;
            transform: translateY(-1px) scale(1.01);
            font-weight: 900;
            box-shadow: 0 14px 30px rgba(201, 25, 32, 0.34);
        }

        @media (max-width: 1024px) {
            .ruby-hero-video-mobile {
                min-height: 500px;
            }

            .ruby-hero-video-mobile__content {
                min-height: 500px;
                padding: 24px 16px;
            }

            .ruby-hero-video-mobile__copy {
                margin: 0 auto;
                text-align: center;
            }

            .ruby-hero-video-mobile__title {
                margin-top: 14px;
            }

            .ruby-hero-video-mobile__subtitle {
                margin-left: auto;
                margin-right: auto;
            }

            .ruby-hero-video-mobile__actions {
                justify-content: center;
            }
        }

        @media (max-width: 544px) {
            .ruby-hero-video-mobile {
                min-height: 300px;
            }

            .ruby-hero-video-mobile__content {
                min-height: 300px;
                padding: 24px 16px;
            }

            .ruby-hero-video-mobile__eyebrow {
                font-size: 10px;
                padding: 7px 12px;
            }

            .ruby-hero-video-mobile__actions {
                margin-top: 20px;
            }

            .ruby-hero-video-mobile__button {
                width: auto;
                min-width: 200px;
                max-width: 100%;
                padding: 18px 24px;
            }
        }

        @media (max-width: 767px) {
            .ruby-hero-video-mobile__content {
                align-items: flex-end;
                padding: 14px 12px 20px;
            }

            .ruby-hero-video-mobile__copy {
                display: block !important;
                max-width: 100%;
                text-align: left;
            }

            .ruby-hero-video-mobile__title {
                margin: 0;
                font-size: clamp(1.35rem, 6vw, 1.7rem);
                line-height: 1.2;
                text-shadow: 0 2px 10px rgba(0, 0, 0, 0.35);
            }

            .ruby-hero-video-mobile__subtitle {
                display: none !important;
            }

            .ruby-hero-video-mobile__actions {
                margin-top: 10px;
                justify-content: flex-start;
            }

            .ruby-hero-video-mobile__button {
                min-width: 140px;
                padding: 12px 18px;
                font-size: 13px;
                box-shadow: 0 8px 18px rgba(237, 29, 36, 0.3);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .ruby-hero-video-mobile__button {
                transition: none;
            }
        }
    </style>
@endonce

@php
    use Botble\Base\Facades\BaseHelper;
    use Botble\Media\Facades\RvMedia;
    use Illuminate\Support\Arr;

    $attributes = $attributes ?? [];

    $desktopVideo = Arr::get($attributes, 'desktop_video');
    $desktopPoster = Arr::get($attributes, 'desktop_poster');
    $mobileImage = Arr::get($attributes, 'mobile_image');

    $defaultImage = RvMedia::getDefaultImage();

    $desktopVideoUrl = $desktopVideo ? RvMedia::url($desktopVideo) : null;
    $desktopPosterUrl = $desktopPoster
        ? RvMedia::getImageUrl($desktopPoster, null, false, $defaultImage)
        : ($mobileImage ? RvMedia::getImageUrl($mobileImage, null, false, $defaultImage) : $defaultImage);
    $mobileImageUrl = $mobileImage
        ? RvMedia::getImageUrl($mobileImage, 'medium', false, $defaultImage)
        : $desktopPosterUrl;
    $mobileImageUrlOrigin = $mobileImage
        ? RvMedia::getImageUrl($mobileImage, null, false, $defaultImage)
        : $desktopPosterUrl;

    $title = Arr::get($attributes, 'title') ?: 'เครื่องมือช่างเพื่อมืออาชีพ';
    $subtitle = Arr::get($attributes, 'subtitle');
    $buttonText = Arr::get($attributes, 'button_text') ?: 'ดูสินค้า';
    $buttonLink = Arr::get($attributes, 'button_link') ?: '/';
    $hasAction = filled($buttonText) && filled($buttonLink);
@endphp

<section
    class="ruby-hero-video-mobile"
>
    <div class="ruby-hero-video-mobile__media hidden md:block">
        @if ($desktopVideoUrl)
            <video
                autoplay
                muted
                loop
                playsinline
                preload="auto"
                disablepictureinpicture="true"
                disableremoteplayback="true"
                controlslist="nodownload,nofullscreen,noremoteplayback"
            >
                <source src="{{ $desktopVideoUrl }}" type="video/mp4">
            </video>
        @else
            <img
                src="{{ $desktopPosterUrl }}"
                alt="{{ BaseHelper::clean($title) }}"
                loading="eager"
                fetchpriority="high"
                decoding="async"
            >
        @endif
    </div>

    <div class="ruby-hero-video-mobile__media md:hidden">
        <img
            src="{{ $mobileImageUrl }}"
            srcset="{{ $mobileImageUrl }} 768w, {{ $mobileImageUrlOrigin }} 1600w"
            sizes="100vw"
            alt="{{ BaseHelper::clean($title) }}"
            loading="eager"
            fetchpriority="high"
            decoding="async"
        >
    </div>

    <div class="ruby-hero-video-mobile__overlay" aria-hidden="true"></div>

    <div class="ruby-hero-video-mobile__content">
        <div class="ruby-hero-video-mobile__inner">
            <div class="ruby-hero-video-mobile__copy">
                @if ($title)
                    <h1 class="ruby-hero-video-mobile__title">
                        {!! BaseHelper::clean($title) !!}
                    </h1>
                @endif

                @if ($subtitle)
                    <p class="ruby-hero-video-mobile__subtitle">
                        {!! BaseHelper::clean($subtitle) !!}
                    </p>
                @endif

                @if ($hasAction)
                    <div class="ruby-hero-video-mobile__actions">
                        <a href="{{ $buttonLink }}" class="ruby-hero-video-mobile__button">
                            {{ $buttonText }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
