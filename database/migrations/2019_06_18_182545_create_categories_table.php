<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name');
        });

        Schema::create('category_post', function(Blueprint $table){
           $table->bigIncrements('id');
           $table->unsignedBigInteger('post_id')->index();
           $table->foreign('post_id')->references('id')->on('posts')->onDelete("cascade");
           $table->unsignedBigInteger('category_id')->index();
           $table->foreign('category_id')->references('id')->on('categories')->onDelete("cascade");
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
        Schema::dropIfExists('categories');
        Schema::dropIfExists('category_post');
    }
}
