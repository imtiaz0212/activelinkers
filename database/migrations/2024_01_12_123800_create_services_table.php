<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->date('created')->nullable();
            $table->integer('service_category_id')->index();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('short_description')->nullable();
            $table->text('page_url')->nullable();
            $table->string('reach')->nullable();
            $table->string('reach_percent')->nullable();
            $table->text('icon')->nullable();
            $table->string('tag_title')->nullable();
            $table->text('tags')->nullable();
            $table->text('images')->nullable();
            $table->text('description')->nullable();
            $table->softDeletes('deleted_at');
            $table->timestamps();
        });
    }

    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
