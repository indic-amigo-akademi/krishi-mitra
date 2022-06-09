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
            $table->id()->comment('Unique ID of the order');
            $table->unsignedBigInteger('user_id')->comment('User ID of the user who placed the order');
            $table->unsignedBigInteger('product_id')->comment('Product ID of the product in the order');
            $table->unsignedBigInteger('address_id')->comment('Address ID of the address where the order is placed');
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users');
            $table
                ->foreign('product_id')
                ->references('id')
                ->on('products');
            $table
                ->foreign('address_id')
                ->references('id')
                ->on('addresses');
            $table->unsignedBigInteger('order_id')->comment('Order ID of the order');
            $table->integer('qty')->comment('Quantity of the product in the order');
            $table->double('price')->comment('Price of the product in the order');
            $table->double('discount')->comment('Discount of the product in the order');
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])->comment('Status of the order');
            $table->string('type')->comment('Category of the product in the order');
            $table->timestamps();
            $table->softDeletes();
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
