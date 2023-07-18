<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_incomes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            //$table->foreign('product_id')->references('id')->on('listproduct');
            $table->integer('count');
            $table->string('barcode');
            $table->integer('purchase_price_uzs');
            $table->integer('selling_price_uzs');
            $table->integer('selling_price_usd');
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
        Schema::dropIfExists('product_incomes');
    }
}
