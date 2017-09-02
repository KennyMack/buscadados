<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyCatImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_cat_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_category_id')->unsigned();
            $table->foreign('company_category_id')->references('id')->on('company_categories');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('imagepath', 255);
            $table->string('imageurl', 255);
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
        Schema::drop('company_cat_images');
    }
}
