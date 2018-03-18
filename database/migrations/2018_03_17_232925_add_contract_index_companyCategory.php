<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContractIndexCompanyCategory extends Migration
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
            $table->integer('contract_index')->default(-1);
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
            $table->dropColumn('contract_index');
        });
    }
}
