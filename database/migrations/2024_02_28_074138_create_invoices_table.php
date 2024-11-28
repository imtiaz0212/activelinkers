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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->date('created')->nullable();
            $table->date('updated')->nullable();
            $table->date('payment_date')->nullable();

            $table->integer('order_id')->index()->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('ref_code')->nullable();
            $table->string('privilege')->nullable();
            $table->integer('user_id')->index()->nullable();
            $table->string('email')->nullable();

            $table->text('discription')->nullable();

            $table->decimal('subtotal', 10, 3)->default(0.000);
            $table->decimal('discount', 10, 3)->default(0.000);
            $table->decimal('grand_total', 10, 3)->default(0.000);

            $table->integer('method_id')->default(0);
            $table->integer('is_payment')->default(0);
            $table->integer('is_send')->default(0);
            $table->integer('is_waening')->default(0);
            $table->integer('is_remove')->default(0);

            $table->string('status')->default('unpaid');
            $table->string('invoice_type')->default('order');

            $table->softDeletes('deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
