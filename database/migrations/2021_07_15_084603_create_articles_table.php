<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->string('header')->nullable();
            $table->longText('body')->nullable();
            $table->string('video_path')->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->integer('view_count')->default(0);
            $table->integer('status')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('article_category_id')->nullable();
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('article_category_id')->references('id')->on('article_categories');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
