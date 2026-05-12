<?php

namespace Botble\Page\Providers;

use Botble\Base\Facades\DashboardMenu;
use Botble\Base\Supports\DashboardMenuItem;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Page\Models\Page;
use Botble\Page\Repositories\Eloquent\PageRepository;
use Botble\Page\Repositories\Interfaces\PageInterface;
use Botble\Shortcode\View\View;
use Botble\Theme\Events\RenderingAdminBar;
use Botble\Theme\Facades\AdminBar;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Support\Arr;

/**
 * @since 02/07/2016 09:50 AM
 */
class PageServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this->app->bind(PageInterface::class, function () {
            return new PageRepository(new Page());
        });

        $this
            ->setNamespace('packages/page')
            ->loadAndPublishConfigurations(['permissions', 'general'])
            ->loadHelpers()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->loadMigrations();

        DashboardMenu::default()->beforeRetrieving(function (): void {
            DashboardMenu::make()
                ->registerItem(
                    DashboardMenuItem::make()
                        ->id('cms-core-page')
                        ->priority(2)
                        ->name('packages/page::pages.menu_name')
                        ->icon('ti ti-notebook')
                        ->route('pages.index')
                        ->permissions('pages.index')
                );
        });

        $this->app['events']->listen(RenderingAdminBar::class, function (): void {
            AdminBar::registerLink(
                trans('packages/page::pages.menu_name'),
                route('pages.create'),
                'add-new',
                'pages.create'
            );
        });

        if (function_exists('shortcode')) {
            ViewFacade::composer(['packages/page::themes.page'], function (View $view): void {
                $view->withShortcodes();
            });

            add_filter(BASE_FILTER_FORM_EDITOR_BUTTONS_FOOTER, function (?string $footer, array $attributes) {
                if (! request()->routeIs('pages.edit')) {
                    return $footer;
                }

                if (! Arr::get($attributes, 'with-short-code', false)) {
                    return $footer;
                }

                $editorId = Arr::get($attributes, 'id');

                if ($editorId !== 'content') {
                    return $footer;
                }

                $shortcodes = shortcode()->getAll();

                $payload = collect($shortcodes)->map(
                    function (array $shortcode, string $key): array {
                        return [
                            'key' => $key,
                            'name' => $shortcode['name'] ?? null,
                            'description' => $shortcode['description'] ?? null,
                            'has_admin_config' => isset($shortcode['admin_config']),
                            'has_preview_image' => ! empty($shortcode['previewImage']),
                        ];
                    }
                )->values()->all();

                $footer .= '<script>
                    (function () {
                        const payload = ' . json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . ';
                        console.groupCollapsed("[RUBY DEBUG] /admin/pages/edit shortcode list");
                        console.log("route:", window.location.pathname);
                        console.log("editorId:", ' . json_encode($editorId) . ');
                        console.log("count:", payload.length);
                        console.table(payload);
                        console.log("window.BB_SHORTCODES:", window.BB_SHORTCODES || null);
                        console.groupEnd();
                    })();
                </script>';

                return $footer;
            }, 130, 2);
        }

        $this->app->booted(function (): void {
            $this->app->register(HookServiceProvider::class);
        });

        $this->app->register(EventServiceProvider::class);
    }
}
