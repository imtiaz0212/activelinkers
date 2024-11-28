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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index();
            $table->date('created')->nullable();
            $table->string('title')->nullable();
            $table->text('page_url')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('read_time')->nullable();
            $table->text('featured_image')->nullable();
            $table->softDeletes('deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
