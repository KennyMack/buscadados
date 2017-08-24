<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table)
        {
            $table->string('lastname');
            $table->tinyInteger('type');
            $table->tinyInteger('isactive');
            $table->tinyInteger('firstlogin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table)
        {
            $table->dropColumn('lastname');
            $table->dropColumn('type');
            $table->dropColumn('isactive');
            $table->dropColumn('firstlogin');
        });
    }
}
