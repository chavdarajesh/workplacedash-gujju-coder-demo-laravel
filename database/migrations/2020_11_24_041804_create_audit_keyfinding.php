<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditKeyfinding extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_keyfinding', function (Blueprint $table) {
            $table->increments('ak_id');   
            $table->integer('ak_atpq_id')->nullable();
            $table->integer('ak_atp_id')->nullable();
            $table->integer('ak_atm_id')->nullable();
            $table->integer('ak_adm_id')->nullable();
            $table->longText('ak_keyfinding')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_keyfinding');
    }
}
