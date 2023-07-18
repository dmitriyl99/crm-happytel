<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            //$table->foreign('product_id')->references('id')->on('listproduct');
            $table->unsignedBigInteger('product_income_id');
            //$table->foreign('product_income_id')->references('id')->on('product_incomes');
            $table->unsignedBigInteger('sold_by_id');
            //$table->foreign('sold_by_id')->references('id')->on('users');
            $table->integer('count');
            $table->string('barcode');
            $table->integer('selling_price_uzs');
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
        Schema::dropIfExists('product_sales');
    }
}
