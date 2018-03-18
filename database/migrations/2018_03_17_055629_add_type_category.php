<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('category', function (Blueprint $table) {

            $table->tinyInteger('type')->default(0); // 0 - category detail 1 - category contract
            $table->tinyInteger('readonlyname')->default(0);
            $table->tinyInteger('readonlydescription')->default(0);


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
        Schema::table('category', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('readonlyname');
            $table->dropColumn('readonlydescription');
        });
    }
}
