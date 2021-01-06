<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomizeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customize', function (Blueprint $table) {
            
            $table->id();
            $table->string('custom_number');
            $table->bigInteger('user_id');
            $table->string('fullname');
            $table->string('address1');
            $table->string('address2');
            $table->string('city');
            $table->string('state');
            $table->string('postcode');
            $table->string('mobile');
            $table->string('description');
            $table->enum('status', ['pending','processing','accepted','completed','declined']);
            $table->float('grand_total')->nullable();
            $table->float('deposit')->nullable();
            $table->tinyInteger('fully_paid')->default(false);            
            $table->tinyInteger('deposit_paid')->default(false);                        
            $table->string('payment_id')->nullable();
            $table->string('paydeposit_id')->nullable();
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
        Schema::dropIfExists('customize');
    }
}
