<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('page_url')->unique();
            $table->text('title');
            $table->longText('description');
            $table->text('featured_image')->nullable();
            $table->string('status')->default('draft');
            $table->string('content_type')->nullable()->index();
            $table->text('meta_title')->nullable();
            $table->text('meta_teg')->nullable();
            $table->text('meta_description')->nullable();
            $table->softDeletes('deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
