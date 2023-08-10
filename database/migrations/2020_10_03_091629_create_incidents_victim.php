<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentsVictim extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents_victim', function (Blueprint $table) {
            
            $table->increments('iv_id');   
            $table->integer('iv_im_id')->nullable();   
            $table->integer('iv_vtm_id')->nullable();
            $table->string('iv_name')->nullable();
            $table->string('iv_gender')->nullable();
            $table->string('iv_age_range')->nullable();
            $table->integer('iv_age_range_min')->nullable();
            $table->integer('iv_age_range_max')->nullable();
            $table->longText('iv_details_injury')->nullable();
            $table->integer('iv_taken_hospital')->nullable();
            $table->string('iv_when_returntowork')->nullable();
            $table->longText('iv_details_treatment')->nullable();            
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
        Schema::dropIfExists('incidents_victim');
    }
}
