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
        Schema::create('publishers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('address')->nullable();
            $table->string('avatar')->nullable();
            $table->string('privilege')->default('publisher');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_valid')->default(true);
            $table->dateTime('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->softDeletes('deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publishers');
    }
};
