<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->integer('categorydetail_id')->unsigned();
            $table->foreign('categorydetail_id')->references('id')->on('category_details');
            $table->string('imagepath', 255);
            $table->string('name', 120);
            $table->string('description', 255);
            $table->decimal('value', 15, 2)->default(0);
            $table->tinyInteger('isactive')->default(1);
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
        Schema::drop('company_categories');
    }
}
