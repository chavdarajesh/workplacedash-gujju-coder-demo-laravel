<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class AuditQuestions extends Model
{ 
    protected $primaryKey = 'atpq_id';
    protected $table = 'audit_template_parts_questions';    
}
