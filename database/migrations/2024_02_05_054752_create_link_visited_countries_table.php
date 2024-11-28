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
        Schema::create('link_visited_countries', function (Blueprint $table) {
            $table->id();
            $table->integer('link_id')->index()->nullable();
            $table->string('product_id')->index()->nullable();

            $table->integer('country_id')->index()->nullable();
            
            $table->string('percent')->default(0);

            $table->softDeletes('deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('link_visited_countries');
    }
};
