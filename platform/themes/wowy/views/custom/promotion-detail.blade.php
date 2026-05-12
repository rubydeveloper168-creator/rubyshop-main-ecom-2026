@php
    use Botble\Base\Facades\BaseHelper;
    use Botble\Media\Facades\RvMedia;
    use Illuminate\Support\Str;

    // Use hero image only when explicitly set in Page image field.
    // Do not auto-pick first content image to avoid duplicate rendering.
    $heroImage = $page->image ? RvMedia::getImageUrl($page->image, 'medium') : null;

    $contentHtml = apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, BaseHelper::clean($page->content), $page);

    if ($heroImage && preg_match('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', (string) $contentHtml, $firstImageMatch)) {
        $firstImageTag = $firstImageMatch[0] ?? '';
        $firstImageSrc = $firstImageMatch[1] ?? '';

        $normalizeImagePath = function (string $url): string {
            $path = parse_url($url, PHP_URL_PATH) ?: $url;
            $path = strtolower(trim($path));

            // Treat resized media variants as the same image (e.g. -800x800).
            return preg_replace('/-\d+x\d+(?=\.[a-z0-9]+$)/i', '', $path) ?: $path;
        };

        if ($firstImageTag && $firstImageSrc) {
            $heroNormalized = $normalizeImagePath($heroImage);
            $firstNormalized = $normalizeImagePath(str_starts_with($firstImageSrc, 'http') ? $firstImageSrc : url($firstImageSrc));

            if ($heroNormalized === $firstNormalized) {
                $contentHtml = Str::replaceFirst($firstImageTag, '', (string) $contentHtml);
            }
        }
    }
@endphp

<section class="bg-[#0b1220] pb-12">
    <style>
        .promotion-detail-content p {
            margin-bottom: 1rem !important;
            line-height: 1.7 !important;
        }

        .promotion-detail-content img {
            display: block;
            max-width: 100%;
            height: auto;
            margin: 0 auto 1rem;
        }

        .promotion-detail-content * {
            max-width: 100%;
            word-break: break-word;
        }

        .promotion-detail-content ul,
        .promotion-detail-content ol {
            margin-bottom: 1rem;
            padding-left: 1.25rem;
        }
    </style>

    <div class="border-b border-amber-500/20 bg-slate-900">
        <div class="mx-auto max-w-screen-2xl px-4 py-8 sm:px-6 lg:px-10">
            <p class="mb-2 text-xs font-bold uppercase tracking-[0.3em] text-amber-400">{{ __('Construction Promotion') }}</p>
            <h1 class="text-2xl font-black text-white md:text-5xl">{{ $page->name }}</h1>
            @if ($page->description)
                <p class="mt-3 text-sm text-slate-200 md:text-base">{{ $page->description }}</p>
            @endif
        </div>
    </div>

    @if ($heroImage)
        <div class="mx-auto mt-6 max-w-screen-2xl px-4 sm:px-6 lg:px-10">
            <div class="overflow-hidden rounded-2xl border border-slate-700 bg-slate-900">
                <img
                    src="{{ $heroImage }}"
                    alt="{{ $page->name }}"
                    class="h-auto w-full object-cover"
                    loading="eager"
                    fetchpriority="high"
                    decoding="async"
                >
            </div>
        </div>
    @endif

    <div class="mx-auto mt-8 max-w-screen-2xl px-4 sm:px-6 lg:px-10">
        <div class="mb-6">
            <a href="{{ route('promotion.index') }}" class="inline-flex items-center gap-2 rounded-md border border-slate-600 px-4 py-2 text-sm font-semibold text-slate-200 hover:border-amber-400 hover:text-amber-300">
                <i class="fas fa-arrow-left text-xs"></i>
                {{ __('Back to Promotions') }}
            </a>
        </div>

        <div class="rounded-2xl border border-slate-700 bg-white p-6 shadow-xl md:p-10">
            <div class="ck-content promotion-detail-content max-w-none text-slate-800">
                {!! $contentHtml !!}
            </div>
        </div>
    </div>
</section>
