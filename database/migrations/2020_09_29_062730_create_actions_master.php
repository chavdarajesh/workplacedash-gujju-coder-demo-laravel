<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionsMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions_master', function (Blueprint $table) {
            $table->increments('am_id');            
            $table->integer('am_parent_id')->nullable();
            $table->integer('am_module_type')->nullable();
            $table->integer('am_site_id')->nullable();
            $table->longText('am_description')->nullable();
            $table->string('am_control')->nullable();
            $table->dateTime('am_due_date')->nullable();
            $table->longText('am_remark')->nullable();  
            $table->integer('am_atpq_id')->nullable();
            $table->integer('am_atp_id')->nullable();
            $table->integer('am_adm_id')->nullable();                    
            $table->boolean('am_status')->nullable();
            $table->integer('am_created_by')->nullable();
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
        Schema::dropIfExists('actions_master');
    }
}
