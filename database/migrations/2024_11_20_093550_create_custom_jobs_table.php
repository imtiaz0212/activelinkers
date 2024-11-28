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
        Schema::create('custom_jobs', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('queue')->default(10)->index();
            $table->string('from');
            $table->string('to');
            $table->string('subject');
            $table->longText('details');
            $table->string('template');
            $table->tinyInteger('attempts')->default(0);
            $table->text('error')->nullable();
            $table->enum('status', ['pending', 'failed'])->default('pending')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_jobs');
    }
};
