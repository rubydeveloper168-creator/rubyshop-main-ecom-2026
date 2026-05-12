<?php

namespace App\Http\Controllers;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Page\Models\Page;
use Botble\Slug\Facades\SlugHelper;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class PromotionController extends Controller
{
    private const PROMOTION_TEMPLATE = 'promotion-detail';

    // Legacy map: keep old Blade promotions working while migrating to Admin Pages.
    private array $promotionMap = [
        'rb-899-rubyshop' => 'promotion4',
        'rb-1009-rubyshop' => 'promotion30',
        'rb-899-v2' => 'promotion31',
    ];

    public function index(): string
    {
        Theme::layout('full-width');
        Theme::set('pageTitle', __('Promotions'));
        Theme::breadcrumb()
            ->add(__('หน้าหลัก'), route('public.index'))
            ->add(__('Promotions'), route('promotion.index'));

        $promotions = Page::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->with('slugable')
            ->orderByDesc('created_at')
            ->get()
            ->filter(function (Page $page): bool {
                $slug = (string) optional($page->slugable)->key;

                return $page->template === self::PROMOTION_TEMPLATE
                    || Str::startsWith($slug, 'promo-')
                    || Str::startsWith($slug, 'promotion-');
            })
            ->values();

        return Theme::scope('custom.promotions', compact('promotions'))->render();
    }

    public function show($slug)
    {
        $resolvedSlug = SlugHelper::getSlug($slug, SlugHelper::getPrefix(Page::class));

        if ($resolvedSlug && $resolvedSlug->reference_type === Page::class) {
            $page = Page::query()
                ->whereKey($resolvedSlug->reference_id)
                ->where('status', BaseStatusEnum::PUBLISHED)
                ->first();

            if ($page) {
                // Use the canonical page URL render path (same as /{slug}),
                // to keep layout/content identical and avoid duplicate custom wrappers.
                return redirect()->to(url($resolvedSlug->key));
            }
        }

        // Legacy fallback support for hardcoded promotion views.
        if (isset($this->promotionMap[$slug])) {
            $viewPath = 'promotion.' . $this->promotionMap[$slug];

            if (View::exists($viewPath)) {
                return view($viewPath);
            }
        }

        $viewPath = 'promotion.' . Str::slug($slug, '');
        if (View::exists($viewPath)) {
            return view($viewPath);
        }

        return abort(404);
    }
}
