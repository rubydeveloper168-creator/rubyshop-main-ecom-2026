<?php

use App\Support\SeoAutoPostService;
use Botble\Blog\Models\Category;
use Botble\Blog\Models\Post;
use Botble\Setting\Facades\Setting;
use Botble\Slug\Facades\SlugHelper;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('seo:auto-post {--count=1} {--dry-run}', function (SeoAutoPostService $service) {
    $count = max(1, (int) $this->option('count'));
    $dryRun = (bool) $this->option('dry-run');

    $this->info(sprintf('Running seo:auto-post count=%d dryRun=%s', $count, $dryRun ? 'true' : 'false'));

    $results = $service->run($count, $dryRun);

    foreach ($results as $row) {
        if ($row['status'] === 'published') {
            $this->line(sprintf(
                'Published: product #%d -> post #%d (%s)',
                $row['product_id'],
                $row['post_id'],
                $row['post_url']
            ));
        } elseif ($row['status'] === 'dry-run') {
            $this->line(sprintf('Dry-run pick: product #%d %s', $row['product_id'], $row['product_name']));
        } else {
            $this->warn($row['message']);
        }
    }
})->purpose('Create blog posts from unpublished products with dedupe protection');

Artisan::command('seo:fix-blog-root-path', function () {
    $postKey = SlugHelper::getPermalinkSettingKey(Post::class);
    $categoryKey = SlugHelper::getPermalinkSettingKey(Category::class);

    Setting::set($postKey, '');
    Setting::set($categoryKey, '');
    Setting::save();

    $updated = DB::table('slugs')
        ->whereIn('reference_type', [Post::class, Category::class])
        ->update(['prefix' => '', 'updated_at' => now()]);

    $this->info("Done. Updated {$updated} slug row(s) to root path.");
    $this->line('Blog post URL format is now: /{slug}');
})->purpose('Force blog URLs to root path (no /blog prefix)');

Schedule::command('seo:auto-post --count=' . (int) env('SEO_AUTO_POST_DAILY_COUNT', 1))
    ->dailyAt((string) env('SEO_AUTO_POST_DAILY_AT', '02:10'))
    ->withoutOverlapping()
    ->runInBackground();
