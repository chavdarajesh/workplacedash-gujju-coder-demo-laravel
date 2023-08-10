<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditUsernotify extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_usernotify', function (Blueprint $table) {
            $table->increments('aun_id');   
            $table->integer('aun_atpq_id')->nullable();
            $table->integer('aun_atp_id')->nullable();
            $table->integer('aun_atm_id')->nullable();
            $table->integer('aun_adm_id')->nullable();
            $table->integer('aun_user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_usernotify');
    }
}
