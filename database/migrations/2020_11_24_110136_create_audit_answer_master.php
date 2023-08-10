<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditAnswerMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_answer_master', function (Blueprint $table) {
            $table->increments('aam_id');            
            $table->integer('aam_atpq_id')->nullable();
            $table->integer('aam_atp_id')->nullable();
            $table->integer('aam_atm_id')->nullable();
            $table->integer('aam_adm_id')->nullable();
            $table->integer('aam_opt_id')->nullable();
            $table->longText('aam_answer')->nullable();
            $table->longText('aam_question')->nullable();            
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
        Schema::dropIfExists('audit_answer_master');
    }
}
