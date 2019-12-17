<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('event_id');

            // for event info
            $table->string('certificate_name')->nullable();
            $table->string('nickname')->nullable();

            $table->string('is_attend')->nullable();
            $table->string('is_paid')->nullable();
            $table->string('is_register')->nullable();

            $table->timestamp('date_registered')->nullable();
            $table->timestamp('date_attendance')->nullable();

            $table->string('get_certificate')->nullable();
            $table->string('get_eventid')->nullable();
            
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
        Schema::dropIfExists('participants');
    }
}
