<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditTemplatesMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_templates_master', function (Blueprint $table) {
            $table->increments('atm_id');
            $table->longText('atm_audit_name')->nullable();
            $table->longText('atm_description')->nullable();
            $table->string('atm_audit_id')->nullable();            
            $table->string('atm_icon')->nullable();            
            $table->integer('atm_scoring_required')->nullable();            
            $table->integer('atm_status')->nullable();            
            $table->integer('atm_created_by')->nullable();            
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
        Schema::dropIfExists('audit_templates_master');
    }
}
