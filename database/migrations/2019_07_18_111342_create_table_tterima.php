<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTterima extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tanda_terima', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cust_id');
            $table->string('item_name');
            $table->string('tipe');
            $table->string('sn');
            $table->string('keterangan');
            $table->string('keluhan');
            $table->string('kelengkapan');
            $table->integer('estimasi_selesai');
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
        Schema::dropIfExists('tanda_terima');
    }
}
