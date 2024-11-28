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
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->date('created')->nullable();
            $table->string('title')->nullable();
            $table->text('page_url')->nullable();
            $table->string('reach')->nullable();
            $table->string('reach_percent')->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->text('advantage')->nullable();
            $table->text('images')->nullable();
            $table->softDeletes('deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};
