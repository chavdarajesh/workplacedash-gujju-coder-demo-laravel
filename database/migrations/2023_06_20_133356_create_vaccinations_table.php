<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccinations', function (Blueprint $table) {
            $table->id();
            $table->boolean('vaccinated')->default(0);
            $table->datetime('date_administered')->nullable();
            $table->string('vaccine_type')->nullable();
            $table->string('other_vaccine_type')->nullable();
            $table->string('picture')->nullable();
            $table->boolean('second_vaccinated')->default(0);
            $table->datetime('second_date_administered')->nullable();
            $table->string('second_other_vaccine_type')->nullable();
            $table->string('second_vaccine_type')->nullable();
            $table->string('second_picture')->nullable();
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
        Schema::dropIfExists('vaccinations');
    }
}
