<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\User;
use DB;
use Auth;
use App\AuditTemplates;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\CheckBoxOption;
use App\AuditQuestions;

class AuditTemplatesControllers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {        
        $this->middleware('FrontUsers');
    }
    public function index()
    {                
       $cuser = Auth::user();
       if(!$cuser->can('Audit Template')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }  
       $AuditTemplates=AuditTemplates::all();      
       $page_title='Audit Templates';
       return view('audittemplates.audittemplates',compact('page_title','cuser','AuditTemplates'));    
    }
    public function store(Request $request)
    {
        $parentuser = Auth::user();
        $atm_icon='';        
        if($request->file('atm_icon')){
            $atm_icon = Storage::putFile('public/'.$parentuser->companyname, $request->file('atm_icon')); 
            $atm_icon=str_replace('public/', '', $atm_icon);    
        }
        $AuditTemplates = new \App\AuditTemplates;
        $AuditTemplates->atm_audit_name = $request->atm_audit_name;
        $AuditTemplates->atm_description = $request->atm_description;
        $AuditTemplates->atm_audit_id = $request->atm_audit_id;
        $AuditTemplates->atm_icon = $atm_icon;
        $AuditTemplates->atm_scoring_required = $request->atm_scoring_required;
        $AuditTemplates->atm_status = $request->atm_status;
        $AuditTemplates->atm_created_by = $parentuser->id;        
        $AuditTemplates->save();
        $atm_id=$AuditTemplates->atm_id;
        DB::table('audit_templates_parts')->insert(array('atp_name'=>'Section A','atp_atm_id'=>$atm_id,'atp_status'=>1)); 

        return Redirect::route('audittemplates')->with('success',__('Audit Templates successfully added.'));
    }
    public function create(Request $request)
    {        
        return view('audittemplates.create');
    }
    
    public function edit(Request $request, $id)
    {
        $AuditTemplates=AuditTemplates::where('atm_id',$request->id)->first();
        return view('audittemplates.edit', compact('AuditTemplates'));
    }

    public function update(Request $request)
    { 
        $parentuser = Auth::user();      
        $atm_icon='';        
        if($request->file('atm_icon')){
            $atm_icon = Storage::putFile('public/'.$parentuser->companyname, $request->file('atm_icon')); 
            $atm_icon=str_replace('public/', '', $atm_icon);    
        }  
        $AuditTemplates = \App\AuditTemplates::find($request->atm_id);
        $AuditTemplates->atm_audit_name = $request->atm_audit_name;
        $AuditTemplates->atm_description = $request->atm_description;
        $AuditTemplates->atm_audit_id = $request->atm_audit_id;
        if($atm_icon!=''){
            $AuditTemplates->atm_icon = $atm_icon;
        }    
        $AuditTemplates->atm_scoring_required = $request->atm_scoring_required;
        $AuditTemplates->atm_status = $request->atm_status;        
        $AuditTemplates->save();   
        return Redirect::route('audittemplates')->with('success',__('Audit Templates successfully updated.'));
    }

    public function delete($id)
    {
        AuditTemplates::where('atm_id',$id)->delete();
        return $id;
    }

    public function DeleteIcon($id)
    {   
        $AuditTemplates = \App\AuditTemplates::find($id);
        Storage::delete('public/'.$AuditTemplates->atm_icon);
        $AuditTemplates->atm_icon = Null;
        $AuditTemplates->save();           
        return $id;                            
    }

    public function GetSetions(Request $request)
    {           
        AuditQuestions::whereNull('atpq_question')->delete();
        $atm_id=$request->atm_id;
        $atp_id=$request->atp_id;
        $cuser = Auth::user();
        $page_title='Template Settings';
        $AuditTemplates = \App\AuditTemplates::find($atm_id);        
        if(!$AuditTemplates){
            return Redirect::route('audittemplates')->with('error',__('Audit Templates not found.'));
        }
        $AuditSection = DB::table('audit_templates_parts')->where('atp_atm_id',$atm_id)->orderby('atp_id','ASC')->get();        
        if($atp_id){
            $AuditSectionDetails = DB::table('audit_templates_parts')->where('atp_id',$atp_id)->first();
            if(!$AuditSectionDetails){
                return Redirect::route('getsetions',['atm_id'=>$atm_id]);
            }           
        }else{
            $AuditSectionDetails = DB::table('audit_templates_parts')->where('atp_atm_id',$atm_id)->orderby('atp_id','ASC')->first();        
        }
        $AuditQuestions=AuditQuestions::whereNull('atpq_parent_id')->where('atpq_atm_id',$AuditSectionDetails->atp_atm_id)->where('atpq_atp_id',$AuditSectionDetails->atp_id)->get(); 

        $AuditSubQuestions=AuditQuestions::whereNotNull('atpq_parent_id')->where('atpq_atm_id',$AuditSectionDetails->atp_atm_id)->where('atpq_atp_id',$AuditSectionDetails->atp_id)->get()->groupBy('atpq_option_id');         

        $CheckBoxOption = CheckBoxOption::get()->groupBy('aco_grpid_id');    
        $GridViewOptionVal=DB::table('audit_gridview_option')->where('ago_atp_id',$AuditSectionDetails->atp_id)->get();
        $GridViewOption=array();
        if($GridViewOptionVal){
            foreach ($GridViewOptionVal as $key => $value) {
                $GridViewOption[$value->ago_keyword]=$value->ago_value;
            }
        } 
        $CheckBoxQuestionOption = DB::table('audit_checkbox_question_option')->where('acqo_atp_id',$AuditSectionDetails->atp_id)->get()->groupBy('acqo_atpq_id')->toArray();           

        return view('audittemplates.audittemplatessection', compact('cuser','page_title','AuditTemplates','AuditSection','atp_id','AuditSectionDetails','AuditQuestions','CheckBoxOption','GridViewOption','AuditSubQuestions','CheckBoxQuestionOption'));
    }

    public function StoreSection(Request $request)
    {   
        $id =DB::table('audit_templates_parts')->insertGetId(array('atp_name'=>$request->atp_name,'atp_atm_id'=>$request->atp_atm_id,'atp_status'=>1));        
        return '<li><a href="'.route('getsetionslist',['atm_id'=>$request->atp_atm_id,'atp_id'=>$id]).'">'.$request->atp_name.'</a></li>';
    }

    public function AddNewQuestion(Request $request)
    {   
        $divid=time().rand(0,10000); 
        $atp_id=$request->atp_id;
        $atp_atm_id =$request->atp_atm_id;        
        $AuditSectionDetails = DB::table('audit_templates_parts')->where('atp_id',$atp_id)->first(); 

        $AuditQuestions = new \App\AuditQuestions;    
        $AuditQuestions->atpq_atp_id = $atp_id;
        $AuditQuestions->atpq_atm_id = $atp_atm_id;            
        $AuditQuestions->save();
        $atpq_id=$AuditQuestions->atpq_id;
        $divid=$atp_id.$atp_atm_id.$atpq_id;

        $AuditQuestions = \App\AuditQuestions::find($atpq_id);
        $AuditQuestions->atpq_divid = $divid;            
        $AuditQuestions->save();

        return view('audittemplates.addquestion',compact('divid','AuditSectionDetails','atpq_id','AuditQuestions'));
    }
    public function AddNewSubQuestion(Request $request)
    {   
        
        $atp_id = $request->atp_id;
        $atp_atm_id = $request->atp_atm_id; 
        $atpq_id = $request->atpq_id; 
        $atpq_parent_id = $request->atpq_id; 
        $option_id = $request->option_id;
        $divid = $request->divid;  
        $subdivid = $atp_id.$atp_atm_id.$atpq_id;

        $AuditSectionDetails = DB::table('audit_templates_parts')->where('atp_id',$atp_id)->first(); 

        $AuditQuestions = new \App\AuditQuestions;    
        $AuditQuestions->atpq_atp_id = $atp_id;
        $AuditQuestions->atpq_atm_id = $atp_atm_id;            
        $AuditQuestions->atpq_parent_id = $atpq_parent_id;            
        $AuditQuestions->atpq_option_id = $option_id;            
        $AuditQuestions->save();
        $atpq_id=$AuditQuestions->atpq_id;
        $divid=$atp_id.$atp_atm_id.$atpq_id;
        $subdivid=$divid;
        $AuditQuestions = \App\AuditQuestions::find($atpq_id);
        $AuditQuestions->atpq_divid = $divid;            
        $AuditQuestions->save();
        

        return view('audittemplates.addsubquestion',compact('subdivid','option_id','divid','atp_id','atp_atm_id','atpq_id'));
    }
    public function AddNewQuestionOption(Request $request)
    {  
        $atpq_type=$request->atpq_type;
        $atpq_id=$request->atpq_id;
        $divid=$request->divid;         

        $AuditQuestions = \App\AuditQuestions::find($atpq_id);
        $AuditQuestions->atpq_type = $atpq_type;            
        $AuditQuestions->save();

        $CheckBoxOption = CheckBoxOption::get()->groupBy('aco_grpid_id');         
        $AuditQuestionsValue = AuditQuestions::where('atpq_id',$atpq_id)->first();

        $GridViewOptionVal=DB::table('audit_gridview_option')->where('ago_atpq_id',$atpq_id)->get();
        $GridViewOption=array();
        if($GridViewOptionVal){
            foreach ($GridViewOptionVal as $key => $value) {
                $GridViewOption[$value->ago_keyword]=$value->ago_value;
            }
        } 

        $CheckBoxQuestionOption = DB::table('audit_checkbox_question_option')->where('acqo_atpq_id',$atpq_id)->get()->groupBy('acqo_atpq_id')->toArray();

        return view('audittemplates.editquestionoption',compact('divid','atpq_type','CheckBoxOption','AuditQuestionsValue','GridViewOption','CheckBoxQuestionOption'));
    }

    public function AddGridViewTable(Request $request)
    {  
        $noofrows=$request->noofrows;
        $noofcolumns=$request->noofcolumns;
        $divid=$request->divid; 
        $atpq_id=$request->atpq_id; 
        $GridViewOption = array();
        $AuditQuestionsValue = AuditQuestions::where('atpq_id',$atpq_id)->first();

        $GridViewOptionVal=DB::table('audit_gridview_option')->where('ago_atpq_id',$atpq_id)->get();
        $GridViewOption=array();
        if($GridViewOptionVal){
            foreach ($GridViewOptionVal as $key => $value) {
                $GridViewOption[$value->ago_keyword]=$value->ago_value;
            }
        }  

        return view('audittemplates.addgridviewtable',compact('divid','noofrows','noofcolumns','AuditQuestionsValue','GridViewOption'));
    }
    public function CheckBoxOptionChange(Request $request)
    {          
        $aco_grpid_id=$request->aco_grpid_id;
        $divid=$request->divid;
        $CheckBoxOption = CheckBoxOption::where('aco_grpid_id',$aco_grpid_id)->get();               
        return view('audittemplates.checkboxoption',compact('divid','aco_grpid_id','CheckBoxOption'));
    }

    public function CheckBoxOptionSave(Request $request)
    {
        $parentuser = Auth::user();        
        $aco_name=$request->aco_name;
        $optcolor=$request->optcolor;        
        $aco_grpid_id=$request->aco_grpid_id;
        $divid=$request->divid;
        $atpq_id=$request->atpq_id;
        $atpq_atp_id=$request->atpq_atp_id;
        $atp_id=$request->atpq_atp_id;
        $atp_atm_id=$request->atpq_atm_id;
        
        $predefineoption=$request->predefineoption;
        $Addthisasanewoption=$request->Addthisasanewoption;
        if($aco_grpid_id!=$predefineoption && $Addthisasanewoption==1){
            foreach ($aco_name as $key => $value) {
                $CheckBoxOption = new \App\CheckBoxOption;
                $CheckBoxOption->aco_name = $value;
                $CheckBoxOption->aco_grpid_id = $aco_grpid_id;  
                $CheckBoxOption->optcolor = $optcolor[$key];  
                $CheckBoxOption->save();            
            }            
        }
        $acqo_id=array();
        DB::table('audit_checkbox_question_option')->where('acqo_atpq_id',$atpq_id)->delete();
        foreach ($aco_name as $key => $value) {
            $insertArr=array('acqo_atp_id'=>$atpq_atp_id,'acqo_atm_id'=>$atp_atm_id,'acqo_atpq_id'=>$atpq_id,'acqo_option'=>$value,'acqo_optcolor'=>$optcolor[$key]);
            $id=DB::table('audit_checkbox_question_option')->insertGetId($insertArr);
            $acqo_id[]=$id;
        } 
        $AuditSubQuestions=AuditQuestions::whereNotNull('atpq_parent_id')->where('atpq_atm_id',$atp_atm_id)->where('atpq_atp_id',$atp_id)->get()->groupBy('atpq_option_id');         
        return view('audittemplates.rulestabs',compact('divid','aco_name','acqo_id','atp_id','atp_atm_id','atpq_id','AuditSubQuestions'));
    }
    public function DelelteSeaction(Request $request)
    {
        $atp_id=$request->atp_id;
        DB::table('audit_templates_parts')->where('atp_id',$atp_id)->delete();            
    }
    public function ChangeSectionStatus(Request $request)
    {
        $atp_id=$request->atp_id;
        $atp_status=$request->atp_status;
        DB::table('audit_templates_parts')->where('atp_id',$atp_id)->update(['atp_status'=>$atp_status]);            
    }
    public function ChangeSectionName(Request $request)
    {
        $atp_id=$request->atp_id;
        $atp_name=$request->atp_name;
        DB::table('audit_templates_parts')->where('atp_id',$atp_id)->update(['atp_name'=>$atp_name]);            
    }

    public function DeleteQustion(Request $request)
    {
        AuditQuestions::where('atpq_divid',$request->atpq_divid)->delete();
        DB::table('audit_gridview_option')->where('ago_atpq_id',$request->atpq_id)->delete();            
        DB::table('audit_checkbox_question_option')->where('acqo_atpq_id',$request->atpq_id)->delete();            
        return $request->atpq_divid;
    }

    public function AddUpdateQustion(Request $request)
    {        
        if($request->atpq_id){
            $AuditQuestions = \App\AuditQuestions::find($request->atpq_id);
        }else{
            $AuditQuestions = new \App\AuditQuestions;    
        }        
        $AuditQuestions->atpq_atp_id = $request->atpq_atp_id;
        $AuditQuestions->atpq_atm_id = $request->atpq_atm_id;
        $AuditQuestions->atpq_type = $request->atpq_type;
        $AuditQuestions->atpq_divid = $request->atpq_divid;
        $AuditQuestions->atpq_question = $request->atpq_question;
        $AuditQuestions->atpq_is_mandatory = $request->atpq_is_mandatory;
        $AuditQuestions->atpq_is_description = $request->atpq_is_description;
        $AuditQuestions->atpq_description_text = ($request->atpq_is_description)?$request->atpq_description_text:null;
        $AuditQuestions->atpq_file_type = $request->atpq_file_type;
        $AuditQuestions->atpq_no_of_files = $request->atpq_no_of_files;
        $AuditQuestions->atpq_file_size = $request->atpq_file_size;
        $AuditQuestions->atpq_is_multiple_choice = $request->atpq_is_multiple_choice;
        $AuditQuestions->atpq_is_rules = $request->atpq_is_rules;
        $AuditQuestions->atpq_is_date = $request->atpq_is_date;
        $AuditQuestions->atpq_is_time = $request->atpq_is_time;
        $AuditQuestions->atpq_start_date = ($request->atpq_start_date)?date('Y-m-d',strtotime($request->atpq_start_date)):null;
        $AuditQuestions->atpq_end_date = ($request->atpq_end_date)?date('Y-m-d',strtotime($request->atpq_end_date)):null;
        $AuditQuestions->atpq_declaration_text = $request->atpq_declaration_text;
        $AuditQuestions->atpq_is_row_headers = $request->atpq_is_row_headers;
        $AuditQuestions->atpq_no_of_rows = $request->atpq_no_of_rows;
        $AuditQuestions->atpq_no_of_columns = $request->atpq_no_of_columns;
        $AuditQuestions->atpq_table_heading = $request->atpq_table_heading;        
        $AuditQuestions->atpq_is_text_type = $request->atpq_is_text_type;
        $AuditQuestions->atpq_created_by = $request->atpq_created_by;        
        $AuditQuestions->save();
        return $AuditQuestions->atpq_id;
    }

    public function AddValueToGridOption(Request $request)
    {
        $ago_atp_id=$request->ago_atp_id;
        $ago_atpq_id=$request->ago_atpq_id;
        $ago_keyword=$request->ago_keyword;
        $ago_value=$request->ago_value;
        $ago_atm_id=$request->ago_atm_id;
        $insertArr=array('ago_atm_id'=>$ago_atm_id,'ago_atp_id'=>$ago_atp_id,'ago_atpq_id'=>$ago_atpq_id,'ago_keyword'=>$ago_keyword,'ago_value'=>$ago_value);
        $exitsgridvalue=DB::table('audit_gridview_option')->where('ago_atp_id',$ago_atp_id)->where('ago_atpq_id',$ago_atpq_id)->where('ago_keyword',$ago_keyword)->first();
        if($exitsgridvalue){
            DB::table('audit_gridview_option')->where('ago_id',$exitsgridvalue->ago_id)->update($insertArr);
        }else{
            DB::table('audit_gridview_option')->insert($insertArr);    
        }
        
    }

}
