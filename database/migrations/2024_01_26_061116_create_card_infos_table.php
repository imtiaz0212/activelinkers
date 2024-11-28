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
        Schema::create('card_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->index();
            $table->date('created')->nullable();
            $table->string('privilege')->nullable();
            $table->integer('user_id')->index();
            $table->string('card_no')->index();
            $table->string('method')->nullable();
            $table->date('card_exp')->nullable();
            $table->string('card_cvv')->nullable();
            $table->softDeletes('deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_info');
    }
};
