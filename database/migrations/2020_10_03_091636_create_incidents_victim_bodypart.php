<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentsVictimBodypart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents_victim_bodypart', function (Blueprint $table) {
            $table->increments('ivbp_id');   
            $table->integer('ivbp_im_id')->nullable();   
            $table->integer('ivbp_iv_id')->nullable();
            $table->integer('ivbp_bpm_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incidents_victim_bodypart');
    }
}
