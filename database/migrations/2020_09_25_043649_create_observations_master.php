<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObservationsMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('observations_master', function (Blueprint $table) {
            $table->increments('ob_id');
            $table->string('ob_srno')->nullable();
            $table->integer('site_id')->nullable();
            $table->string('ob_describethelocation')->nullable();            
            $table->integer('oc_id')->nullable();
            $table->longText('description')->nullable();
            $table->dateTime('obdatetime')->nullable();
            $table->integer('riskpotentiallevel')->nullable();
            $table->boolean('action_required')->nullable();
            $table->longText('Comments')->nullable();
            $table->integer('listing_type')->nullable();
            $table->integer('ob_more_information_required')->nullable();
            $table->longText('ob_information_required')->nullable();
            $table->longText('ob_reply_information_requested')->nullable();
            $table->boolean('status')->nullable();
            $table->longText('ob_closing_comments')->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('observations_master');
    }
}
