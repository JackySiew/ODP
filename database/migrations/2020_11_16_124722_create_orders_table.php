<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
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
            $table->integer('user_id');
            $table->enum('status', ['pending','processing','completed','declined']);
            $table->float('grand_total');
            $table->integer('item_count');
            $table->tinyInteger('is_paid')->default(false);            
            $table->enum('payment_method', ['cash','card','stripe','paypal'])->default('stripe');

            $table->string('fullname');
            $table->string('address1');
            $table->string('address2');
            $table->string('city');
            $table->string('state');
            $table->string('postcode');
            $table->string('mobile');
            $table->string('notes')->nullable();
            $table->string('payment_id');
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
        Schema::dropIfExists('orders');
    }
}
