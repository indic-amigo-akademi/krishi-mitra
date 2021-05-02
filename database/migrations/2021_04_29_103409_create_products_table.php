<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id');
            $table
                ->foreign('seller_id')
                ->references('id')
                ->on('sellers');
            $table->string('type');
            $table->text('desc');
            $table->double('price');
            $table->string('cover');
            $table->string('name');
            $table->string('unit');
            $table->integer('quantity')->nullable();
            $table->string('slug');
            $table->double('discount');
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
        Schema::dropIfExists('products');
    }
}
