<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentsMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents_master', function (Blueprint $table) {
            $table->increments('im_id');   
            $table->string('im_srno')->nullable();                     
            $table->longText('im_description')->nullable();
            $table->integer('im_ic_id')->nullable();
            $table->integer('im_site_id')->nullable();
            $table->integer('im_shift')->nullable();                        
            $table->dateTime('im_datetime')->nullable();
            $table->integer('im_ratinganincident')->nullable();
            $table->integer('im_investigationisrequired')->nullable();
            $table->string('im_machineno_extralocation')->nullable();
            $table->string('im_extendofdamange')->nullable();
            $table->string('im_immediateactiontaken')->nullable();
            $table->integer('im_anyvictim')->nullable();
            $table->integer('im_investigateteamlead')->nullable();
            $table->dateTime('im_dateofcomplete')->nullable();
            $table->integer('im_actionapproved')->nullable();
            $table->integer('im_lastsubmitedstep')->nullable();                                    
            $table->integer('im_approved_by')->nullable();
            $table->dateTime('im_approved_at')->nullable();
            $table->integer('im_created_by')->nullable();
            $table->boolean('im_status')->nullable();
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
        Schema::dropIfExists('incidents_master');
    }
}
