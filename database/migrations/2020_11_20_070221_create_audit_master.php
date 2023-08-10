<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_master', function (Blueprint $table) {
            $table->increments('adm_id'); 
            $table->string('adm_srno')->nullable();                                  
            $table->integer('adm_ac_id')->nullable();
            $table->integer('adm_atm_id')->nullable();
            $table->integer('adm_site_id')->nullable();
            $table->integer('adm_main_site_id')->nullable();
            $table->integer('adm_af_id')->nullable();
            $table->date('adm_start_from')->nullable();
            $table->date('adm_end_on')->nullable();
            $table->integer('adm_auditor')->nullable();
            $table->integer('adm_created_by')->nullable();
            $table->integer('adm_status')->nullable();
            $table->timestamp('adm_status_date')->nullable();            
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
        Schema::dropIfExists('audit_master');
    }
}
