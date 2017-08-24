<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('rg');

            $table->string('history', 255)->nullable();
            $table->string('logopath', 255)->nullable();
            $table->string('logourl', 255)->nullable();
            $table->string('phone', 60)->nullable();
            $table->string('ie', 60)->nullable();
            $table->string('im', 60)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('rg', 40);

            $table->dropColumn('history');
            $table->dropColumn('logopath');
            $table->dropColumn('logourl');
            $table->dropColumn('phone');
            $table->dropColumn('ie');
            $table->dropColumn('im');
        });
    }
}
