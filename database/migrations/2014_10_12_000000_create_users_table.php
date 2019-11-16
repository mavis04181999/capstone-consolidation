<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');

            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');

            $table->text('address')->nullable();
            $table->string('contactno')->nullable();
            $table->string('email')->unique();

            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('section_id')->nullable();
            $table->string('year')->nullable();

            $table->string('username')->unique();
            $table->string('temppassword');
            $table->string('password');
            $table->string('role');

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
