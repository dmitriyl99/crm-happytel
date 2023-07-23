<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductIncomeIdColumnInNewpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('newp', function (Blueprint $table) {
            $table->unsignedBigInteger('product_income_id')->nullable();
            $table->foreign('product_income_id')->references('id')->on('product_incomes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('newp', function (Blueprint $table) {
            //
        });
    }
}
