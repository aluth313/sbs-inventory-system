<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePosting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_posting', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_service');
            $table->integer('kategori');
            $table->integer('id_item');
            $table->string('item');
            $table->integer('harga');
            $table->integer('jumlah');
            $table->integer('total');
            $table->integer('status');
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
        Schema::dropIfExists('transaction_posting');
    }
}
