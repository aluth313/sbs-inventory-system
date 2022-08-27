<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTmpPurchase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_tmp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('kategori');
            $table->integer('item_cd');
            $table->string('item_name');
            $table->string('item_unit');
            $table->integer('item_price');
            $table->integer('item_total');
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
        Schema::dropIfExists('purchase_tmp');
    }
}
