<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditTemplatePartsQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_template_parts_questions', function (Blueprint $table) {
            $table->increments('atpq_id');   
            $table->integer('atpq_atp_id')->nullable();                     
            $table->integer('atpq_atm_id')->nullable();
            $table->integer('atpq_parent_id')->nullable();
            $table->integer('atpq_option_id')->nullable();
            $table->integer('atpq_type')->nullable();
            $table->string('atpq_divid')->nullable();
            $table->longText('atpq_question')->nullable();
            $table->integer('atpq_is_mandatory')->nullable();                        
            $table->integer('atpq_is_description')->nullable();
            $table->longText('atpq_description_text')->nullable();
            $table->integer('atpq_file_type')->nullable();            
            $table->integer('atpq_no_of_files')->nullable();
            $table->integer('atpq_file_size')->nullable();
            $table->integer('atpq_is_multiple_choice')->nullable();
            $table->integer('atpq_is_rules')->nullable();
            $table->integer('atpq_is_date')->nullable();
            $table->integer('atpq_is_time')->nullable();
            $table->date('atpq_start_date')->nullable();
            $table->date('atpq_end_date')->nullable();
            $table->longText('atpq_declaration_text')->nullable();                                    
            $table->integer('atpq_is_row_headers')->nullable();
            $table->integer('atpq_no_of_rows')->nullable();
            $table->integer('atpq_no_of_columns')->nullable();
            $table->string('atpq_table_heading')->nullable();            
            $table->integer('atpq_is_text_type')->nullable();
            $table->integer('atpq_created_by')->nullable();
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
        Schema::dropIfExists('audit_template_parts_questions');
    }
}
