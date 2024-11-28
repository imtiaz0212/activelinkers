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
        Schema::create('link_prices', function (Blueprint $table) {
            $table->id();
            $table->string('product_id')->index()->nullable();

            $table->decimal('regular_price', 20, 3)->default(0.000);
            $table->decimal('sale_price', 20, 3)->default(0.000);
            $table->decimal('owner_price', 20, 3)->default(0.000);

            $table->decimal('merchant_cbd_price', 20, 3)->default(0.000);
            $table->decimal('owner_cbd_price', 20, 3)->default(0.000);

            $table->decimal('merchant_crypto_price', 20, 3)->default(0.000);
            $table->decimal('owner_crypto_price', 20, 3)->default(0.000);
            
            $table->decimal('merchant_casino_price', 20, 3)->default(0.000);
            $table->decimal('owner_casino_price', 20, 3)->default(0.000);

            $table->decimal('merchant_homepage_price', 20, 3)->default(0.000);
            $table->decimal('owner_homepage_price', 20, 3)->default(0.000);

            $table->decimal('merchant_sidebar_price', 20, 3)->default(0.000);
            $table->decimal('owner_sidebar_price', 20, 3)->default(0.000);

            $table->decimal('merchant_footer_price', 20, 3)->default(0.000);
            $table->decimal('owner_footer_price', 20, 3)->default(0.000);

            $table->softDeletes('deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('link_prices');
    }
};
