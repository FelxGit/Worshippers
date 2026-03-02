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
            $table->id();
            $table->integer('role_id')->nullable();
            $table->string('email', 255)->unique();
            $table->string('username', 255);
            $table->string('password', 255);
            $table->string('name', 255);
            $table->string('firstname', 255)->nullable();
            $table->string('middlename', 255)->nullable();
            $table->string('lastname', 255)->nullable();
            $table->string('nick_name', 255)->nullable();
            $table->string('avatar', 255)->nullable();
            $table->date('birth_date')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->string('zip_code');
            $table->string('address', 255);
            $table->string('tel');
            $table->rememberToken()->nullable();
            $table->date('email_verified_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
