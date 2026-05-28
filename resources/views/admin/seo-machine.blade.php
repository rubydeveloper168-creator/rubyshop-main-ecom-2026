@extends(BaseHelper::getAdminMasterLayoutTemplate())

@php
    $stats = $data['stats'];
    $history = $data['history'];
    $lastRun = $data['last_run'];
@endphp

@section('content')
    <div class="row row-cards">
        <div class="col-12">
            <div class="card">
                <div class="card-body d-flex flex-wrap gap-3 align-items-center justify-content-between">
                    <div>
                        <h3 class="mb-1">SEO Machine Dashboard</h3>
                        <p class="text-secondary mb-0">Auto blog posting with anti-duplicate product logic.</p>
                    </div>
                    <form method="POST" action="{{ route('seo-machine.run-now') }}" class="d-flex gap-2 align-items-center">
                        @csrf
                        <label for="run-count" class="mb-0 text-secondary">Posts</label>
                        <input id="run-count" type="number" min="1" max="10" name="count" value="1" class="form-control" style="width: 90px;">
                        <button class="btn btn-primary" type="submit">Run now</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-secondary text-uppercase small">Total Auto Posts</div>
                    <div class="fs-1 fw-bold">{{ number_format($stats['total_posts']) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-secondary text-uppercase small">Published Today</div>
                    <div class="fs-1 fw-bold">{{ number_format($stats['today_posts']) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-secondary text-uppercase small">Daily Schedule</div>
                    <div class="fw-bold">{{ $data['schedule_at'] }}</div>
                    <div class="text-secondary small">count={{ $data['schedule_count'] }}</div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Last Run</h3>
                </div>
                <div class="card-body">
                    @if (! $data['run_table_exists'])
                        <div class="alert alert-warning mb-0">Run log table not found. Please run <code>php artisan migrate</code>.</div>
                    @elseif (! $lastRun)
                        <div class="text-secondary">No run log yet.</div>
                    @else
                        <div class="d-flex flex-wrap gap-4">
                            <div><span class="text-secondary">Status:</span> <strong>{{ strtoupper($lastRun->status) }}</strong></div>
                            <div><span class="text-secondary">Requested:</span> <strong>{{ $lastRun->count_requested }}</strong></div>
                            <div><span class="text-secondary">Started:</span> <strong>{{ $lastRun->started_at }}</strong></div>
                            <div><span class="text-secondary">Finished:</span> <strong>{{ $lastRun->finished_at ?: '-' }}</strong></div>
                        </div>
                        @if ($lastRun->error_message)
                            <div class="alert alert-danger mt-3 mb-0">{{ $lastRun->error_message }}</div>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Auto Post History</h3>
                </div>
                <div class="card-body p-0">
                    @if (! $data['history_table_exists'])
                        <div class="p-3 alert alert-warning m-3">History table not found. Please run <code>php artisan migrate</code>.</div>
                    @elseif ($history->isEmpty())
                        <div class="p-3 text-secondary">No history yet.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product</th>
                                        <th>Product Slug</th>
                                        <th>Post ID</th>
                                        <th>Published At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($history as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->product_name }}</td>
                                            <td>{{ $item->product_slug ?: '-' }}</td>
                                            <td>{{ $item->post_id ?: '-' }}</td>
                                            <td>{{ $item->published_at ?: '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

