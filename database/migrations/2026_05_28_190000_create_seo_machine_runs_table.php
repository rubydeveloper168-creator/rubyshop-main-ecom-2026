<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('seo_machine_runs', function (Blueprint $table): void {
            $table->id();
            $table->string('status', 30)->default('running');
            $table->unsignedInteger('count_requested')->default(1);
            $table->longText('result_json')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_machine_runs');
    }
};

