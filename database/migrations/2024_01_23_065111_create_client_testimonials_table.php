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
        Schema::create('client_testimonials', function (Blueprint $table) {
            $table->id();
            $table->date('created')->nullable();
            $table->string('name')->nullable();
            $table->string('designation')->nullable();
            $table->string('star')->nullable();
            $table->text('description')->nullable();
            $table->text('avatar')->nullable();
            $table->softDeletes('deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_testimonials');
    }
};
