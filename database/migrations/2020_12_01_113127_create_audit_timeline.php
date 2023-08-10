<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditTimeline extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_timeline', function (Blueprint $table) {
            $table->increments('atl_id');               
            $table->integer('atl_adm_id')->nullable();
            $table->integer('atl_userid')->nullable();            
            $table->integer('atl_type')->nullable();            
            $table->timestamp('timeline')->useCurrent();
            $table->longText('atl_reason')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_timeline');
    }
}
