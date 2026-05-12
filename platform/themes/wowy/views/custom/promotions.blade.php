@php
    use Botble\Base\Facades\BaseHelper;
    use Botble\Media\Facades\RvMedia;
@endphp

<section class="bg-[#0f172a] py-10 md:py-14">
    <style>
        .promotion-card h2,
        .promotion-card p {
            margin: 0 !important;
            line-height: 1.5 !important;
        }

        .promotion-card .promotion-meta {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            min-height: 120px;
        }

        .promotion-card .promotion-cta {
            margin-top: auto;
        }

        .promotion-card .promotion-cta,
        .promotion-card .promotion-cta span,
        .promotion-card a {
            position: static !important;
            float: none !important;
            clear: both;
        }

        .promotion-card > a {
            display: flex !important;
            flex-direction: column;
            text-decoration: none;
        }

        .promotion-card .promotion-title,
        .promotion-card .promotion-desc,
        .promotion-card .promotion-cta {
            display: block;
            width: 100%;
        }

        .promotion-card .promotion-title,
        .promotion-card .promotion-desc {
            min-height: 0;
        }
    </style>

    <div class="mx-auto max-w-screen-2xl px-4 sm:px-6 lg:px-10">
        <div class="rounded-2xl border border-amber-500/30 bg-gradient-to-r from-[#111827] via-[#1f2937] to-[#374151] p-6 md:p-8">
            <p class="mb-2 text-xs font-semibold uppercase tracking-[0.3em] text-amber-400">{{ __('Rubyshop Deals') }}</p>
            <h1 class="text-3xl font-black text-white md:text-5xl">{{ __('Promotion Center') }}</h1>
            <p class="mt-3 max-w-3xl text-sm text-slate-200 md:text-base">
                {{ __('โปรโมชันสำหรับงานช่างและงานก่อสร้าง อัปเดตล่าสุด พร้อมรายละเอียดสินค้าและสิทธิพิเศษแบบครบถ้วน') }}
            </p>
        </div>

        @if ($promotions->isEmpty())
            <div class="mt-8 rounded-2xl border border-dashed border-slate-600 bg-slate-800/50 p-8 text-center text-slate-300">
                {{ __('No promotions found. Create a new page in Admin with template ":template" to show it here.', ['template' => 'promotion-detail']) }}
            </div>
        @else
            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($promotions as $promotion)
                    @php
                        $promotionSlug = optional($promotion->slugable)->key ?: $promotion->slug;
                        $promotionUrl = $promotionSlug ? url($promotionSlug) : route('promotion.custom', ['slug' => $promotion->slug]);

                        $image = $promotion->image ? RvMedia::getImageUrl($promotion->image, 'medium') : null;

                        if (! $image && preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', (string) $promotion->content, $matches)) {
                            $firstImage = $matches[1] ?? null;

                            if ($firstImage) {
                                $image = str_starts_with($firstImage, 'http')
                                    ? $firstImage
                                    : RvMedia::getImageUrl($firstImage, 'medium');
                            }
                        }

                        $image = $image ?: Theme::asset()->url('images/slider/slider-11.png');
                    @endphp
                    <article class="promotion-card group overflow-hidden rounded-2xl border border-slate-700 bg-slate-900 shadow-lg transition hover:-translate-y-1 hover:border-amber-500/60">
                        <a href="{{ $promotionUrl }}" class="block">
                            <div class="relative overflow-hidden bg-slate-100 p-3">
                                <div class="flex aspect-square items-center justify-center rounded-xl bg-white">
                                <img
                                    src="{{ $image }}"
                                    alt="{{ $promotion->name }}"
                                    class="h-full w-full object-contain transition duration-300 group-hover:scale-[1.02]"
                                    loading="lazy"
                                    decoding="async"
                                >
                                </div>
                            </div>
                            <div class="promotion-meta p-4">
                                <h2 class="promotion-title text-base font-bold text-white">{{ $promotion->name }}</h2>
                                <p class="promotion-desc text-sm text-slate-300">
                                    {{ $promotion->description ?: __('Click to view full promotion details and conditions.') }}
                                </p>
                                <div class="promotion-cta pt-2">
                                    <span class="inline-flex items-center gap-2 text-sm font-semibold text-amber-400">
                                        {{ __('View Details') }}
                                        <i class="fas fa-arrow-right text-xs"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>
