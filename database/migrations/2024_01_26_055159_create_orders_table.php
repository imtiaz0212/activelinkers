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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('order_no')->index();
            $table->date('created')->nullable();
            $table->date('updated')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('privilege')->nullable();
            $table->integer('user_id')->index();
            $table->integer('email_from_id')->index();
            $table->string('billing_type')->nullable();
            $table->string('name')->nullable();
            $table->string('company')->nullable();
            $table->text('address')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->date('delivery_date')->nullable();
            
            $table->decimal('subtotal', 10, 3)->default(0.000);
            $table->decimal('service_charge', 10, 3)->default(0.000);
            $table->decimal('tax', 10, 3)->default(0.000);
            $table->decimal('discount', 10, 3)->default(0.000);
            $table->decimal('grand_total', 10, 3)->default(0.000);
            $table->longText('description')->nullable();
            $table->string('prepaid_status')->nullable();
            $table->string('status')->default('pending');

            $table->softDeletes('deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
