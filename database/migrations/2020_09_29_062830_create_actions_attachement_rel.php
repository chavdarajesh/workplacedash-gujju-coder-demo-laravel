<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionsAttachementRel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions_attachement_rel', function (Blueprint $table) {
           $table->increments('aa_id'); 
            $table->integer('am_id')->nullable();
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
        Schema::dropIfExists('actions_attachement_rel');
    }
}
