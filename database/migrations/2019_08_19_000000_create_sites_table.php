<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->increments('id');
            $table->text('site_name')->nullable();
            $table->text('site_id')->nullable();
            $table->text('site_timezone')->nullable();
            $table->integer('site_headofsafety')->nullable();
            $table->integer('site_supervisor')->nullable();
            $table->text('sos_mobile')->nullable();
            $table->text('sos_email')->nullable();
            $table->boolean('status')->nullable();
            $table->integer('site_type')->nullable();
            $table->integer('site_parent')->nullable();
            $table->integer('sub_parent')->nullable();            
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
        Schema::dropIfExists('sites');
    }
}
