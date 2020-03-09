<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('organizer_id');
            $table->unsignedBigInteger('department_id')->nullable();
            
            $table->string('event_name')->unique();
            $table->string('event_overview');

            $table->string('event_code')->unique();
            $table->string('event_certificate')->nullable();
            $table->string('event_eventid')->nullable();
            $table->string('event_image')->nullable();

            $table->string('location')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->string('max_participants')->nullable();
            $table->string('allow_prereg')->nullable();
            $table->string('prereg_slot')->nullable();
            $table->string('prereg_validity')->nullable();
            $table->string('fee')->nullable();

            $table->string('form_type')->nullable();
            $table->string('archive')->nullable();
            $table->string('status');
            
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
        Schema::dropIfExists('events');
    }
}
