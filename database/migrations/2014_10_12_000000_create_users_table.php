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
            $table->string('role');

            $table->string('email')->nullable();
            $table->string('title')->nullable();
            $table->string('firstname')->nullable();

            $table->string('middlename')->nullable();
            $table->string('lastname')->nullable();
            $table->string('nickname')->nullable();

            $table->string('certificate_name')->nullable();
            $table->string('contactno')->nullable();
            $table->string('address')->nullable();

            $table->string('occupation')->nullable();
            $table->string('sex')->nullable();
            $table->string('birthday')->nullable();

            $table->string('department_id')->nullable();
            $table->string('course_id')->nullable();
            $table->string('section_id')->nullable();
            $table->string('year')->nullable();

            $table->string('username')->unique();
            $table->string('password');
            $table->string('temppassword');
            $table->string('institution')->nullable();

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
