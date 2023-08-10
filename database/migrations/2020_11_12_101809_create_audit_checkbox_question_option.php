<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditCheckboxQuestionOption extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_checkbox_question_option', function (Blueprint $table) {
            $table->increments('acqo_id');
            $table->integer('acqo_atp_id')->nullable();
            $table->integer('acqo_atm_id')->nullable();            
            $table->integer('acqo_atpq_id')->nullable();
            $table->string('acqo_option')->nullable();
            $table->integer('acqo_optcolor')->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_checkbox_question_option');
    }
}
