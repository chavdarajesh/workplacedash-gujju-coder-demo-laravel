<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentsRating extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents_rating', function (Blueprint $table) {
            $table->increments('ir_id');            
            $table->integer('rating')->nullable();
            $table->string('severity')->nullable();
            $table->string('likelihood')->nullable();
            $table->integer('rating_type')->nullable();                                
            $table->string('rating_text')->nullable();                                            
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
        Schema::dropIfExists('incidents_rating');
    }
}
