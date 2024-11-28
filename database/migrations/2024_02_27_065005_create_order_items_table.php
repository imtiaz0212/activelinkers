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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->date('created')->nullable();
            $table->integer('order_id')->index();

            $table->string('entity_name')->nullable();
            $table->text('live_url')->nullable();
            $table->text('url')->nullable();
            $table->longText('anchor')->nullable();
            $table->string('is_other_price')->nullable();
            $table->string('link_insert')->nullable();
            $table->decimal('artical', 10, 3)->default(0.000);
            $table->decimal('url_price', 10, 3)->default(0.000);
            $table->decimal('other_price', 10, 3)->default(0.000);
            $table->decimal('total', 10, 3)->default(0.000);

            $table->softDeletes('deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
