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
        Schema::create('link_lists', function (Blueprint $table) {
            $table->id();

            $table->date('created')->nullable();
            $table->string('privilege')->nullable();
            $table->integer('publisher_id')->index()->nullable();
            
            $table->string('product_id')->index()->nullable();
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->string('owner')->nullable();
            $table->text('niche')->nullable();
            $table->text('description')->nullable();

            $table->string('link_type')->nullable();
            $table->string('link_validity')->nullable();
            $table->string('homepage_link')->default('no');
            $table->string('sidebar_link')->default('no');
            $table->string('footer_link')->default('no');

            $table->string('cbd')->default('no');
            $table->string('crypto')->default('no');
            $table->string('casino')->default('no');
            $table->string('da')->default(0);
            $table->string('pa')->default(0);
            $table->string('dr')->default(0);
            $table->string('ahref_rank')->default(0);
            $table->string('traffic')->default(0);
            $table->string('organic_keyword')->default(0);

            $table->string('cf')->default(0);
            $table->string('tf')->default(0);
            $table->string('direct')->default(0);
            $table->string('organic_search')->default(0);
            $table->string('social')->default(0);
            
            $table->text('images')->nullable();

            $table->softDeletes('deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('link_lists');
    }
};
