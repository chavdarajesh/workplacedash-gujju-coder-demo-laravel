<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuditTemplates extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'atm_id';
    protected $table = 'audit_templates_master';    
}
