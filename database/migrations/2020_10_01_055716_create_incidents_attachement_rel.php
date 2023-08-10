<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentsAttachementRel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents_attachement_rel', function (Blueprint $table) {
            $table->increments('ia_id'); 
            $table->integer('im_id')->nullable();
            $table->string('attachament')->nullable();
            $table->string('attachement_name')->nullable();
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
        Schema::dropIfExists('incidents_attachement_rel');
    }
}
