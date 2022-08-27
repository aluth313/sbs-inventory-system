<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCustpay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custpays', function (Blueprint $table) {
            $table->increments('id');
            $table->string('payment_no');
            $table->string('service_id');
            $table->integer('customer_id');
            $table->string('supplier_name');
            $table->integer('nilai_pembayaran');
            $table->text('description');
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
        Schema::dropIfExists('custpays');
    }
}
