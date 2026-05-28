<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('seo_machine_post_histories', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('product_id')->unique();
            $table->unsignedBigInteger('post_id')->nullable();
            $table->string('product_name');
            $table->string('product_slug')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_machine_post_histories');
    }
};

