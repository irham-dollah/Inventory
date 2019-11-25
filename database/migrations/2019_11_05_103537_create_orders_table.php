<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->unsignedBigInteger('item_id');
            $table->integer('pic_id')->unsigned();
            $table->decimal('price', 5, 2);
            $table->integer('quantity');
            $table->string('status');
            $table->timestamps();

            // $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            // $table->foreign('name')->references('name')->on('users')->onDelete('cascade');
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
