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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->date('created')->nullable();
            $table->integer('service_id')->index();
            $table->string('type')->nullable();
            $table->string('title')->nullable();
            $table->decimal('monthly',4,2)->default(0.00);
            $table->decimal('yearly',4,2)->default(0.00);
            $table->text('short_description')->nullable();
            $table->text('features')->nullable();
            $table->tinyInteger('is_recommended')->default(0);
            $table->softDeletes('deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
