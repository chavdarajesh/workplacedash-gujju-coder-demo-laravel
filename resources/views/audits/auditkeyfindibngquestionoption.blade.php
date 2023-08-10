<?php $answerdata=array(); $answerdataID=array(); 
if(isset($AuditAnswerMaster[$AuditQuestionsValue->atpq_id])){
    foreach ($AuditAnswerMaster[$AuditQuestionsValue->atpq_id] as $anskey => $ans_value) {
        if($ans_value->aam_answer){
            if($ans_value->aam_opt_id){
                $answerdata[$ans_value->aam_opt_id]=$ans_value->aam_answer;
            }else{
                $answerdata[]=$ans_value->aam_answer;    
            }
            
            $answerdataID[]=$ans_value->aam_id;
        }
    }
}
?>
<div class="mt-21">
    @if($atpq_type==3)
        <?php $inputtypetext='datetime-local'; 
            if($AuditQuestionsValue->atpq_is_date==1 && $AuditQuestionsValue->atpq_is_time==''){$inputtypetext='date';}            
            $min=$AuditQuestionsValue->atpq_start_date; $max=$AuditQuestionsValue->atpq_end_date;            
            if($inputtypetext=='datetime-local'){$min=$AuditQuestionsValue->atpq_start_date.'T00:00'; $max=$AuditQuestionsValue->atpq_end_date.'T00:00';}
        ?>
        <div class="form-group">
            <p><b>{{__('Answer')}}:- </b> <?php if(!empty($answerdata)){echo $answerdata[0];} ?></p>
        </div>
    @endif
    @if($atpq_type==4)
        <div class="form-group">  
        <b>{{__('Answer')}}:- </b>          
            <div class="form-check">
                <input disabled="disabled" <?php if(in_array(1, $answerdata)){echo 'checked="checked"';} ?> class="form-check-input gcspansewertoaudit11" type="checkbox" name="aam_answer" value="1" id="{{$AuditQuestionsValue->atpq_id}}">
                <label class="form-check-label" for="{{$AuditQuestionsValue->atpq_id}}">
                {{$AuditQuestionsValue->atpq_declaration_text}}
                </label>
            </div>
        </div>
    @endif
    @if($atpq_type==6)
        <div class="form-group ">
            <b>{{__('Answer')}}:- </b>
            <?php if(!empty($answerdata)){$sid=$answerdata[0];}else{$sid='';} ?>    
                {{ GetSiteAreaName($sid) }}            
        </div>

    @endif
    @if($atpq_type==7)
        <div class="form-group">
            <p><b>{{__('Answer')}}:- </b> <?php if(!empty($answerdata)){echo $answerdata[0];} ?></p>
        </div>
    @endif
    @if($atpq_type==8)
        <div class="form-group">
            <p><b>{{__('Answer')}}:- </b> <?php if(!empty($answerdata)){echo $answerdata[0];} ?></p>
        </div>
    @endif
    @if($atpq_type==9)
        <div class="form-group answerdropdown">            
            <b>{{__('Answer')}}:- </b>
            <?php if(!empty($answerdata)){$uid=$answerdata[0];}else{$uid='';} ?>                     
            <?php if(count($Auditor)){
              foreach ($Auditor as $key => $value) {
                if($uid==$value->id){?>
                    {{$value->name}} - {{$value->r_name}}
                <?php }              ?>              
              <?php } } ?>             
            
        </div>
    @endif

    @if($atpq_type==1)
        <?php
        $FileTypeAccepts='.xlsx,.xls,image/*,.doc,.docx,.ppt,.pptx,.pdf'; 
        $FileNote=__('Attachment to be').' JPG, PNG, GIF, PPT, DOC, XLS or PDF '.__('formats').' ('.__('below').' 1 MB).';
        if($AuditQuestionsValue->atpq_file_type==1){
            $FileNote=__('Attachment to be').' JPG, PNG, GIF, PPT, DOC, XLS or PDF '.__('formats').' ('.__('below').' '.$AuditQuestionsValue->atpq_file_size.' MB).';
            $FileTypeAccepts='.xlsx,.xls,image/*,.doc,.docx,.ppt,.pptx,.pdf'; 
        }
        if($AuditQuestionsValue->atpq_file_type==2){
            $FileNote=__('Attachment to be').' JPG, PNG or GIF '.__('formats').' ('.__('below').' '.$AuditQuestionsValue->atpq_file_size.' MB).';
            $FileTypeAccepts='image/*'; 
        }
        if($AuditQuestionsValue->atpq_file_type==3){
            $FileNote=__('Attachment to be').' PPT, DOC, XLS or PPT '.__('formats').' ('.__('below').' '.$AuditQuestionsValue->atpq_file_size.' MB).';
            $FileTypeAccepts='.xlsx,.xls,.doc,.docx,.ppt,.pptx,.pdf'; 
        }?>            
        <div class="form-group gc-uploadbtn mt-0">
        <b class="d-block">{{__('Answer')}}:- </b>
            <?php
            if(!empty($answerdata)){
                foreach ($answerdata as $key => $value) {
                    $attachamentsrc=url('storage/'.$value);
                    $path_info = pathinfo($attachamentsrc);                    
                    if($path_info['extension']=='pdf'){$attachamentsrc=asset('images/pdf.png');}
                    if($path_info['extension']=='docx'){$attachamentsrc=asset('images/doc.png');}
                    if($path_info['extension']=='xlsx'){$attachamentsrc=asset('images/excel.png');}
                    if($path_info['extension']=='bin'){$attachamentsrc=asset('images/ppt.png');}
                    if($path_info['extension']=='pptx'){$attachamentsrc=asset('images/ppt.png');}
                    echo '<span data-fileid="0"  class="pip pip'.$answerdataID[$key].'"><a title="{{$value->attachement_name}}" href="'.url('storage/'.$value).'" target="_blank"><img class="imageThumb" src="'.$attachamentsrc.'" title=""></a><br></span>';    
                }
            }    
            ?>            
        </div>
    @endif

    @if($atpq_type==2)
    <div class="form-group"> 
        @if($AuditQuestionsValue->atpq_is_multiple_choice!=1)
        <b>{{__('Answer')}}:- </b>
            <div class="radio-toolbar">
                <?php  if(array_key_exists($AuditQuestionsValue->atpq_id,$CheckBoxQuestionOption)){ ?>
                @foreach($CheckBoxQuestionOption[$AuditQuestionsValue->atpq_id] as $CheckBoxQuestionOptionItem)
                <?php if(in_array($CheckBoxQuestionOptionItem->acqo_id, $answerdata)){ ?>
                <div class="colorcode colorcode{{$CheckBoxQuestionOptionItem->acqo_optcolor}}">
                    <input  type="radio" checked="checked" id="radio{{$CheckBoxQuestionOptionItem->acqo_id.$AuditQuestionsValue->atpq_id}}" name="aam_answer{{$CheckBoxQuestionOptionItem->acqo_id.$AuditQuestionsValue->atpq_id}}" value="{{$CheckBoxQuestionOptionItem->acqo_id}}" class="gcspansewertoaudit11">
                    <label for="radio{{$CheckBoxQuestionOptionItem->acqo_id.$AuditQuestionsValue->atpq_id}}" >{{$CheckBoxQuestionOptionItem->acqo_option}}</label>
                </div>
                <?php } ?> 
                @endforeach
                <?php } ?>   
            </div>
        @else
            <div class="checkbox-toolbar">
                <b>{{__('Answer')}}:- </b>
            <?php  if(array_key_exists($AuditQuestionsValue->atpq_id,$CheckBoxQuestionOption)){
                $checkboxansarr=array();
                if(!empty($answerdata)){$checkboxansarr=explode(',', $answerdata[0]); }
            ?>
            @foreach($CheckBoxQuestionOption[$AuditQuestionsValue->atpq_id] as $CheckBoxQuestionOptionItem)
            <?php if(in_array($CheckBoxQuestionOptionItem->acqo_id, $answerdata)){ ?>
            <div class="form-check form-check-inline">                
                <label class="form-check-label" for="checkbox{{$CheckBoxQuestionOptionItem->acqo_id}}">{{$CheckBoxQuestionOptionItem->acqo_option}}</label>
            </div> 
            <?php } ?>
            @endforeach
            <?php } ?>   
        </div>
        @endif
    </div>    
    @endif

    @if($atpq_type==5)        
        <div class="gridviewtbl">
            <b>{{__('Answer')}}:- </b>
        <?php $divid=$AuditQuestionsValue->atpq_divid; $noofrows=$AuditQuestionsValue->atpq_no_of_rows; $noofcolumns=$AuditQuestionsValue->atpq_no_of_columns; ?>
            {{ view('audits.addgridviewtable',compact('divid','noofrows','noofcolumns','AuditQuestionsValue','GridViewOption','answerdata')) }}
        </div>

    @endif
</div>