<?php

namespace App\Http\Controllers\Admin;

use App\Support\SeoAutoPostService;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class SeoMachineController extends BaseController
{
    public function index(): View
    {
        $this->pageTitle('SEO Machine Dashboard');

        $historyTableExists = DB::getSchemaBuilder()->hasTable('seo_machine_post_histories');
        $runTableExists = DB::getSchemaBuilder()->hasTable('seo_machine_runs');

        $history = collect();
        $lastRun = null;
        $stats = [
            'total_posts' => 0,
            'today_posts' => 0,
        ];

        if ($historyTableExists) {
            $history = DB::table('seo_machine_post_histories')
                ->orderByDesc('id')
                ->limit(30)
                ->get();

            $stats['total_posts'] = DB::table('seo_machine_post_histories')->count();
            $stats['today_posts'] = DB::table('seo_machine_post_histories')
                ->whereDate('published_at', now()->toDateString())
                ->count();
        }

        if ($runTableExists) {
            $lastRun = DB::table('seo_machine_runs')->orderByDesc('id')->first();
        }

        return view('admin.seo-machine', [
            'data' => [
                'schedule_at' => (string) env('SEO_AUTO_POST_DAILY_AT', '02:10'),
                'schedule_count' => (int) env('SEO_AUTO_POST_DAILY_COUNT', 1),
                'history_table_exists' => $historyTableExists,
                'run_table_exists' => $runTableExists,
                'stats' => $stats,
                'history' => $history,
                'last_run' => $lastRun,
            ],
        ]);
    }

    public function runNow(Request $request, SeoAutoPostService $service): BaseHttpResponse
    {
        $count = max(1, min(10, (int) $request->input('count', 1)));
        $runId = null;

        if (DB::getSchemaBuilder()->hasTable('seo_machine_runs')) {
            $runId = DB::table('seo_machine_runs')->insertGetId([
                'status' => 'running',
                'count_requested' => $count,
                'result_json' => null,
                'error_message' => null,
                'started_at' => now(),
                'finished_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        try {
            $results = $service->run($count, false);
            $publishedCount = collect($results)->where('status', 'published')->count();

            if ($runId) {
                DB::table('seo_machine_runs')->where('id', $runId)->update([
                    'status' => 'success',
                    'result_json' => json_encode($results, JSON_UNESCAPED_UNICODE),
                    'finished_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return $this->httpResponse()->setMessage("Run completed. Published {$publishedCount} post(s).");
        } catch (Throwable $e) {
            if ($runId) {
                DB::table('seo_machine_runs')->where('id', $runId)->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                    'finished_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return $this->httpResponse()
                ->setError()
                ->setMessage('Run failed: ' . $e->getMessage());
        }
    }
}

