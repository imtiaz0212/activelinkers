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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->date('created')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->text('image')->nullable();
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
        Schema::dropIfExists('teams');
    }
};
