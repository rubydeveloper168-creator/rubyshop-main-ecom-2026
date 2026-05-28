<?php

namespace App\Support;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SeoAutoPostService
{
    public function run(int $count = 1, bool $dryRun = false): array
    {
        $results = [];

        for ($i = 0; $i < $count; $i++) {
            $product = $this->pickNextProduct();

            if (! $product) {
                $results[] = [
                    'status' => 'stopped',
                    'message' => 'No unused published product left.',
                ];

                break;
            }

            if ($dryRun) {
                $results[] = [
                    'status' => 'dry-run',
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                ];

                continue;
            }

            $results[] = DB::transaction(function () use ($product): array {
                $post = $this->createPostFromProduct($product);
                $this->rememberPublishedProduct($product, $post);

                return [
                    'status' => 'published',
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'post_id' => $post->id,
                    'post_url' => $post->url,
                ];
            });
        }

        return $results;
    }

    protected function pickNextProduct(): ?Product
    {
        return Product::query()
            ->where('status', 'published')
            ->where('is_variation', 0)
            ->where(function ($query): void {
                $query->where('price', '>=', 1200)
                    ->orWhere('sale_price', '>=', 1200);
            })
            ->whereNotExists(function ($query): void {
                $query->selectRaw('1')
                    ->from('seo_machine_post_histories as h')
                    ->whereColumn('h.product_id', 'ec_products.id');
            })
            ->orderByDesc('id')
            ->first();
    }

    protected function createPostFromProduct(Product $product): object
    {
        $title = $this->buildTitle($product);
        $summary = trim((string) strip_tags((string) $product->description));
        $details = trim((string) strip_tags((string) $product->content));

        $postId = DB::table('posts')->insertGetId([
            'name' => $title,
            'description' => Str::limit($summary !== '' ? $summary : $title, 160),
            'content' => $this->buildContent($product, $summary, $details),
            'image' => $product->image,
            'is_featured' => false,
            'status' => 'published',
            'author_id' => 1,
            'author_type' => 'Botble\\ACL\\Models\\User',
            'views' => 0,
            'format_type' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $slug = Str::slug($title) . '-' . $postId;
        DB::table('slugs')->insert([
            'key' => $slug,
            'reference_id' => $postId,
            'reference_type' => 'Botble\\Blog\\Models\\Post',
            'prefix' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $category = DB::table('categories')
            ->where('status', 'published')
            ->orderByDesc('is_default')
            ->orderBy('id')
            ->first();

        if ($category) {
            DB::table('post_categories')->insert([
                'post_id' => $postId,
                'category_id' => $category->id,
            ]);
        }

        return (object) [
            'id' => $postId,
            'url' => url('/' . $slug),
        ];
    }

    protected function rememberPublishedProduct(Product $product, object $post): void
    {
        DB::table('seo_machine_post_histories')->insert([
            'product_id' => $product->id,
            'post_id' => $post->id,
            'product_name' => (string) $product->name,
            'product_slug' => $product->slug,
            'published_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    protected function buildTitle(Product $product): string
    {
        return sprintf('%s | รีวิวสเปก การใช้งาน และจุดเด่น', trim((string) $product->name));
    }

    protected function buildContent(Product $product, string $summary, string $details): string
    {
        $productUrl = url('/products/' . $product->slug);

        $sections = [
            '<h2>แนะนำสินค้า</h2>',
            '<p>' . e($summary !== '' ? $summary : $product->name) . '</p>',
            '<h2>จุดเด่นที่น่าสนใจ</h2>',
            '<ul>',
            '<li>เหมาะกับงานช่างที่ต้องการความเร็วและความสม่ำเสมอ</li>',
            '<li>ใช้งานได้จริงในหน้างาน พร้อมรองรับงานต่อเนื่อง</li>',
            '<li>สามารถเปรียบเทียบกับรุ่นอื่นก่อนตัดสินใจซื้อได้</li>',
            '</ul>',
            '<h2>ข้อมูลสินค้า</h2>',
            '<p>' . e(Str::limit($details !== '' ? $details : $summary, 800)) . '</p>',
            '<h2>ลิงก์สินค้า</h2>',
            '<p>ดูรายละเอียดสินค้าได้ที่ <a href="' . e($productUrl) . '">' . e($productUrl) . '</a></p>',
        ];

        return implode("\n", $sections);
    }
}
