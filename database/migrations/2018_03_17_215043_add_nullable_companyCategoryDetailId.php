<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullableCompanyCategoryDetailId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('company_categories', function (Blueprint $table) {
            $table->integer('categorydetail_id')->unsigned()->nullable()->change();
            $table->integer('category_id')->nullable()->unsigned();
            $table->foreign('category_id')->references('id')->on('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('company_categories', function (Blueprint $table) {
            //$table->integer('categorydetail_id')->nullable(false)->change();
            $table->dropColumn('category_id');
        });
    }
}
