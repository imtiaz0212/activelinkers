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
        Schema::create('site_lists', function (Blueprint $table) {
            $table->id();

            $table->date('created')->nullable();
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->string('check_url')->nullable();
            $table->string('owner')->nullable();
            $table->text('niche')->nullable();

            $table->decimal('general_price', 20, 3)->default(0.000);
            $table->decimal('other_price', 20, 3)->default(0.000);

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

            $table->date('link_validity')->nullable();
            $table->string('image')->nullable();

            $table->integer('country_id')->nullable();
            $table->string('country_traffic')->nullable();

            $table->string('meta_title')->nullable();
            $table->string('meta_tag')->nullable();
            $table->string('meta_description')->nullable();

            $table->softDeletes('deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_lists');
    }
};
