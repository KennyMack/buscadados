<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateImageCatTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_cat_temps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('session_id', 255);
            $table->timestamps();
        });

        DB::statement("ALTER TABLE image_cat_temps ADD image MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('image_cat_temps');
    }
}
