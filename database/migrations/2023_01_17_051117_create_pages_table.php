<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->longText('content')->nullable();
            $table->string('banner')->nullable();
            $table->string('template')->nullable();
            $table->integer('is_meta')->default(0);
            $table->integer('status')->default(0);
            $table->longText('meta_fields')->nullable();
            $table->integer('order')->default(0);
            $table->bigInteger('visitor')->default(0);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('keywords')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
};
