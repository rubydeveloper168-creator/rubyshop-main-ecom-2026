@php
    use Botble\Media\Facades\RvMedia;
    use Illuminate\Support\Arr;
    use Illuminate\Support\Facades\Log;

    $attributes = $attributes ?? [];
    $title = Arr::get($attributes, 'title', __('Shop By Category'));
    $buttonText = Arr::get($attributes, 'button_text');
    $buttonLink = Arr::get($attributes, 'button_link');
    $rawCards = $content ?? Arr::get($attributes, 'cards', []);

    if (is_string($rawCards)) {
        $rawCards = json_decode($rawCards, true) ?: [];
    }

    if (is_array($rawCards) && ! empty($rawCards)) {
        $firstItem = Arr::first($rawCards);

        if (is_array($firstItem) && array_key_exists('key', $firstItem) && array_key_exists('value', $firstItem)) {
            $normalized = [];

            foreach ($rawCards as $card) {
                $item = [];

                foreach ((array) $card as $entry) {
                    $key = Arr::get($entry, 'key');
                    if ($key !== null) {
                        $item[$key] = Arr::get($entry, 'value');
                    }
                }

                if (! empty(array_filter($item, fn ($value) => filled($value)))) {
                    $normalized[] = $item;
                }
            }

            $rawCards = $normalized;
        }
    }

    $accentColors = [
        '#476e8a',
        '#2f120e',
        '#0a7b3b',
        '#20386a',
        '#b91c1c',
        '#c81e1e',
    ];

    $logCardDebug = static function (array $context): void {
        if (! config('app.debug')) {
            return;
        }

        Log::debug('Shop By Category Cards shortcode image debug', $context);
    };

    $cards = collect($rawCards)
        ->map(function ($item, $index) use ($accentColors, $logCardDebug) {
            $card = is_array($item) ? $item : [];

            $title = Arr::get($card, 'title');
            $subtitle = Arr::get($card, 'subtitle');
            $image = Arr::get($card, 'image');
            $link = Arr::get($card, 'link');

            if (! $title && ! $subtitle && ! $image && ! $link) {
                return null;
            }

            $resolvedImage = $image
                ? RvMedia::getImageUrl($image, 'medium', false, RvMedia::getDefaultImage())
                : RvMedia::getDefaultImage();
            $usedFallback = ! $image || $resolvedImage === RvMedia::getDefaultImage();

            $logCardDebug([
                'index' => $index,
                'title' => $title,
                'subtitle' => $subtitle,
                'raw_image' => $image,
                'resolved_image' => $resolvedImage,
                'used_fallback' => $usedFallback,
                'link' => $link,
            ]);

            return [
                'title' => $title,
                'subtitle' => $subtitle,
                'image' => $resolvedImage,
                'link' => $link,
                'accent' => $accentColors[$index % count($accentColors)],
            ];
        })
        ->filter()
        ->values();

    $sectionId = 'shop-by-category-cards-' . uniqid();
@endphp

@if ($cards->isNotEmpty())
    <section class="shop-by-category-cards" id="{{ $sectionId }}" data-shop-by-category-root>
        <div class="shop-by-category-cards__inner">
            <div class="shop-by-category-cards__header">
                <h2 class="shop-by-category-cards__title">{!! BaseHelper::clean($title) !!}</h2>
            </div>

            <div class="shop-by-category-cards__carousel">
                <button type="button" class="shop-by-category-cards__arrow shop-by-category-cards__arrow--prev" data-shop-by-category-prev aria-label="{{ __('Previous cards') }}">
                    <i class="fas fa-arrow-left"></i>
                </button>

                <div class="shop-by-category-cards__track" data-shop-by-category-slider>
                    @foreach ($cards as $card)
                        @php
                            $isLinked = filled($card['link']);
                        @endphp

                        <article class="shop-by-category-cards__card" style="--card-accent: {{ $card['accent'] }};">
                            @if ($isLinked)
                                <a href="{{ $card['link'] }}" class="shop-by-category-cards__card-link" aria-label="{{ Arr::get($card, 'title') }}">
                            @endif

                            <div class="shop-by-category-cards__image-wrap">
                                <img
                                    src="{{ $card['image'] }}"
                                    alt="{{ $card['title'] ?: __('Category image') }}"
                                    class="shop-by-category-cards__image"
                                    loading="lazy"
                                    decoding="async"
                                >
                            </div>

                            <div class="shop-by-category-cards__content">
                                @if ($card['title'])
                                    <h3 class="shop-by-category-cards__card-title">{!! BaseHelper::clean($card['title']) !!}</h3>
                                @endif

                                @if ($card['subtitle'])
                                    <p class="shop-by-category-cards__card-subtitle">{!! BaseHelper::clean($card['subtitle']) !!}</p>
                                @endif
                            </div>

                            @if ($isLinked)
                                </a>
                            @endif
                        </article>
                    @endforeach
                </div>

                <button type="button" class="shop-by-category-cards__arrow shop-by-category-cards__arrow--next" data-shop-by-category-next aria-label="{{ __('Next cards') }}">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>

            @if ($buttonText && $buttonLink)
                <div class="shop-by-category-cards__cta">
                    <a href="{{ $buttonLink }}" class="shop-by-category-cards__cta-button">
                        {!! BaseHelper::clean($buttonText) !!}
                    </a>
                </div>
            @endif
        </div>
    </section>
@endif

@once
    <style>
        .shop-by-category-cards {
            background: #fff;
            padding: 1rem 0 2.5rem;
        }

        .shop-by-category-cards__inner {
            max-width: 1480px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .shop-by-category-cards__header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1.4rem;
        }

        .shop-by-category-cards__title {
            font-size: clamp(2rem, 4vw, 3.75rem);
            line-height: 1;
            font-weight: 800;
            text-align: center;
            letter-spacing: -0.04em;
            color: #000;
        }

        .shop-by-category-cards__carousel {
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .shop-by-category-cards__arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 2;
            width: 3rem;
            height: 3rem;
            border-radius: 9999px;
            border: 0;
            background: #f2f2f2;
            color: #111;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
            transition: transform 0.15s ease, background 0.15s ease;
        }

        .shop-by-category-cards__arrow:hover {
            background: #e8e8e8;
            transform: scale(1.03);
        }

        .shop-by-category-cards__arrow--prev {
            left: -0.5rem;
        }

        .shop-by-category-cards__arrow--next {
            right: -0.5rem;
        }

        .shop-by-category-cards__track {
            display: flex;
            gap: 1rem;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            padding: 0.25rem 3rem 0.5rem;
            width: 100%;
            scrollbar-width: none;
        }

        .shop-by-category-cards__track::-webkit-scrollbar {
            display: none;
        }

        .shop-by-category-cards__card {
            flex: 0 0 auto;
            width: min(14rem, 78vw);
            background: #f4f4f4;
            border-radius: 0.375rem;
            border-bottom: 5px solid var(--card-accent);
            overflow: hidden;
            scroll-snap-align: center;
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.03);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .shop-by-category-cards__card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
        }

        .shop-by-category-cards__card-link {
            display: flex;
            height: 100%;
            min-height: 100%;
            flex-direction: column;
            color: inherit;
            text-decoration: none;
        }

        .shop-by-category-cards__image-wrap {
            min-height: 11.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem 1rem 0.35rem;
        }

        .shop-by-category-cards__image {
            max-width: 100%;
            max-height: 10rem;
            object-fit: contain;
        }

        .shop-by-category-cards__content {
            padding: 0.5rem 1rem 1rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            min-height: 5.5rem;
            justify-content: center;
        }

        .shop-by-category-cards__card-title {
            font-size: 1rem;
            line-height: 1.25;
            font-weight: 800;
            color: #111;
            text-wrap: balance;
        }

        .shop-by-category-cards__card-subtitle {
            font-size: 0.72rem;
            line-height: 1.25;
            font-weight: 800;
            color: #111;
            text-transform: uppercase;
            letter-spacing: 0.01em;
        }

        .shop-by-category-cards__cta {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }

        .shop-by-category-cards__cta-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 3.5rem;
            padding: 0 1.75rem;
            border-radius: 0.25rem;
            background: #ffcc00;
            color: #111;
            font-weight: 800;
            text-decoration: none;
            transition: transform 0.15s ease, filter 0.15s ease;
        }

        .shop-by-category-cards__cta-button:hover {
            transform: translateY(-1px);
            filter: brightness(0.98);
        }

        @media (max-width: 767px) {
            .shop-by-category-cards {
                padding-top: 0.5rem;
            }

            .shop-by-category-cards__header {
                margin-bottom: 1.25rem;
            }

            .shop-by-category-cards__card {
                width: min(15rem, 84vw);
            }

            .shop-by-category-cards__arrow {
                display: none;
            }

            .shop-by-category-cards__track {
                padding-left: 0;
                padding-right: 0;
            }
        }
    </style>

    <script>
        (function () {
            const init = (root) => {
                const slider = root.querySelector('[data-shop-by-category-slider]');
                const prev = root.querySelector('[data-shop-by-category-prev]');
                const next = root.querySelector('[data-shop-by-category-next]');

                if (!slider || !prev || !next) {
                    return;
                }

                const getScrollAmount = () => {
                    const card = slider.querySelector('.shop-by-category-cards__card');
                    const cardWidth = card ? card.getBoundingClientRect().width : slider.clientWidth;
                    return cardWidth + 16;
                };

                prev.addEventListener('click', () => {
                    slider.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
                });

                next.addEventListener('click', () => {
                    slider.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
                });
            };

            const boot = () => {
                document.querySelectorAll('[data-shop-by-category-root]').forEach(init);
            };

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', boot);
            } else {
                boot();
            }
        })();
    </script>
@endonce
