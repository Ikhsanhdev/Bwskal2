<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UnduhanSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unduhan', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('category_id')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->string('mime');
            $table->longText('file');
            $table->unsignedInteger('hit')->nullable()->default(0);
            $table->boolean('is_private')->nullable()->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('unduhan_kategori', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unduhan_kategori');
        Schema::dropIfExists('unduhan');
    }
}
