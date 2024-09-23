<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('category_id')->nullable()->default(0);
            $table->string('title');
            $table->string('slug');
            $table->text('cover')->nullable();
            $table->longText('content');
            $table->unsignedInteger('hit_total')->default(0)->nullable();
            $table->unsignedInteger('hit_week')->default(0)->nullable();
            $table->unsignedInteger('hit_week_total')->default(0)->nullable();
            $table->boolean('is_active')->default(true)->nullable();
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
        Schema::dropIfExists('posts');
    }
}
