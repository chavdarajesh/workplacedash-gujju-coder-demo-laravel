<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditCheckboxOptoin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_checkbox_optoin', function (Blueprint $table) {
            $table->increments('aco_id');
            $table->string('aco_grpid_id')->nullable();            
            $table->string('aco_name')->nullable(); 
            $table->integer('optcolor')->nullable();            
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
        Schema::dropIfExists('audit_checkbox_optoin');
    }
}
