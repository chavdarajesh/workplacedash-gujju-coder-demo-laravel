<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRootcauseItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rootcause_items', function (Blueprint $table) {
            $table->increments('rci_id');   
            $table->integer('rci_rc_id')->nullable();   
            $table->integer('rci_parent_id')->nullable();   
            $table->string('rci_name')->nullable(); 
            $table->longText('rci_desctiption')->nullable(); 
            $table->boolean('rci_status')->nullable();
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
        Schema::dropIfExists('rootcause_items');
    }
}
