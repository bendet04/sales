<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->biginteger('customer_id');
            $table->integer('discount_id')->nullable();
            $table->string('installation_address');
            $table->string('installation_date')->nullable();
            $table->string('pic_contact');
            $table->string('document');
            $table->string('order_status');
            $table->decimal('total_price', 12, 0);
            $table->decimal('discount_amount', 12, 0)->nullable();;
            $table->decimal('grand_price', 12, 0);
            $table->integer('payment_scheme');
            $table->integer('payment_status');
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
        Schema::dropIfExists('order');
    }
}
