<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditGridviewOption extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_gridview_option', function (Blueprint $table) {
            $table->increments('ago_id');   
            $table->integer('ago_atp_id')->nullable();
            $table->integer('ago_atm_id')->nullable();
            $table->integer('ago_atpq_id')->nullable();
            $table->string('ago_keyword')->nullable();                                 
            $table->string('ago_value')->nullable();                                 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_gridview_option');
    }
}
