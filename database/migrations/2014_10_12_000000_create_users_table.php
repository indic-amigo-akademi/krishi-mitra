<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id()->comment('Unique ID of the user');
            $table->string('name')->comment('Name of the user');
            $table->string('username')->unique()->comment('Username of the user');
            $table->string('email')->unique()->comment('Email of the user');
            $table->bigInteger('phone')->comment('Phone number of the user');
            $table->string('password')->comment('Password of the user');
            $table->enum('role', ['sysadmin', 'admin', 'seller', 'user'])->comment('Role of the user');
            $table->boolean('active')->default(true)->comment('Whether the user is active or not');
            $table->dateTime('email_verified_at')->nullable()->comment('When the user verified his/her email');
            $table->rememberToken()->comment('Remember token of the user');
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
        Schema::dropIfExists('users');
    }
}
