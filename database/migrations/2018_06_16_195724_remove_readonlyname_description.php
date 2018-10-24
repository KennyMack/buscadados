<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveReadonlynameDescription extends Migration
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
            $table->dropColumn('readonlyname');
            $table->dropColumn('readonlydescription');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category', function (Blueprint $table) {
            $table->tinyInteger('readonlyname')->default(0);
            $table->tinyInteger('readonlydescription')->default(0);
        });
    }
}
