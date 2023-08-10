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
$required='';
if($AuditQuestionsValue->atpq_is_mandatory==1){$required='required';}
?>
<div class="mt-2">
    @if($atpq_type==3)
        <?php $inputtypetext='datetime-local'; 
            if($AuditQuestionsValue->atpq_is_date==1 && $AuditQuestionsValue->atpq_is_time==''){$inputtypetext='date';}            
            $min=$AuditQuestionsValue->atpq_start_date; $max=$AuditQuestionsValue->atpq_end_date;            
            if($inputtypetext=='datetime-local'){$min=$AuditQuestionsValue->atpq_start_date.'T00:00'; $max=$AuditQuestionsValue->atpq_end_date.'T00:00';}
        ?>
        <div class="form-group">
            <input {{$required}} type="{{$inputtypetext}}" name="aam_answer" class="form-control gcspansewertoaudit {{$required}}" value="<?php if(!empty($answerdata)){echo $answerdata[0];} ?>" min="{{$min}}" max="{{$max}}">
        </div>
    @endif
    @if($atpq_type==4)
        <div class="form-group">            
            <div class="form-check">
                <input {{$required}} <?php if(in_array(1, $answerdata)){echo 'checked="checked"';} ?> class="form-check-input gcspansewertoaudit {{$required}}" type="checkbox" name="aam_answer" value="1" id="{{$AuditQuestionsValue->atpq_id}}">
                <label class="form-check-label" for="{{$AuditQuestionsValue->atpq_id}}">
                {{$AuditQuestionsValue->atpq_declaration_text}}
                </label>
            </div>
        </div>
    @endif
    @if($atpq_type==6)
        <div class="form-group gcsptreeviewwapepe">            
            <select {{$required}} class="site_id_audit gcspansewertoaudit {{$required}}" id="{{$AuditQuestionsValue->atpq_id.time()}}" data-formtype="add" name="aam_answer">
            <?php if(!empty($answerdata)){$sid=$answerdata[0];}else{$sid='';} ?>    
                {!! GetSiteDropDown(null,$sid) !!}
            </select>
        </div>
    @endif
    @if($atpq_type==7)
        <div class="form-group">
            <textarea {{$required}} class="form-control gcspansewertoaudit {{$required}}" name="aam_answer"><?php if(!empty($answerdata)){echo $answerdata[0];} ?></textarea>
        </div>
    @endif
    @if($atpq_type==8)
        <div class="form-group">
            <input {{$required}} type="text" name="aam_answer" class="form-control gcspansewertoaudit gcspinputtype{{ $AuditQuestionsValue->atpq_is_text_type }} {{$required}}" value="<?php if(!empty($answerdata)){echo $answerdata[0];} ?>">
        </div>
    @endif
    @if($atpq_type==9)
        <div class="form-group answerdropdown">            
            <select {{$required}} class="form-control multipleSelect aam_answer gcspansewertoaudit {{$required}}"  name="aam_answer">
            <option value="">{{__('Select user')}}</option>   
            <?php if(!empty($answerdata)){$uid=$answerdata[0];}else{$uid='';} ?>                     
            <?php if(count($Auditor)){
              foreach ($Auditor as $key => $value) { ?>
              <option <?php echo ($uid==$value->id)?'selected="selected"':''; ?> value="{{$value->id}}">{{$value->name}} - {{$value->r_name}}</option>    
              <?php } } ?>             
            </select>
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
        <div class="form-group gc-uploadbtn">            
            <div class="gcspuploadedwpr">
                <label for="file-upload{{$AuditQuestionsValue->atpq_id}}" class="custom-file-upload auditattachement">
                    {{__('Attachments')}}
                </label>

                <?php if($AuditQuestionsValue->atpq_no_of_files==1){?>
                    <input  id="file-upload{{$AuditQuestionsValue->atpq_id}}" class="file-upload-audit <?php if(empty($answerdata)){ echo $required;}?>" data-maxfile="{{$AuditQuestionsValue->atpq_no_of_files}}" name="attachedmain[]" type="file"  accept="{{$FileTypeAccepts}}" />
                <?php }else{ ?>
                    <input  id="file-upload{{$AuditQuestionsValue->atpq_id}}" class="file-upload-audit <?php if(empty($answerdata)){ echo $required;}?>" data-maxfile="{{$AuditQuestionsValue->atpq_no_of_files}}" name="attachedmain[]" multiple="" type="file"  accept="{{$FileTypeAccepts}}" />
                <?php } ?>                    

            </div>                
            <div id="fileinstedtimg{{$AuditQuestionsValue->atpq_divid}}"></div>
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
                    echo '<span data-fileid="0"  class="pip pip'.$answerdataID[$key].'"><a title="{{$value->attachement_name}}" href="'.url('storage/'.$value).'" target="_blank"><img class="imageThumb" src="'.$attachamentsrc.'" title=""></a><br><span class="removeimgaudit" data-aam_id="'.$answerdataID[$key].'"><i class="fa fa-times-circle"></i></span></span>';    
                }
            }    
            ?>
            <p class="mt-2"><b>Note:</b> {{$FileNote}}</p>
        </div>
    @endif

    @if($atpq_type==2)
    <div class="form-group"> 
        @if($AuditQuestionsValue->atpq_is_multiple_choice!=1)
            <div class="radio-toolbar">
                <?php  if(array_key_exists($AuditQuestionsValue->atpq_id,$CheckBoxQuestionOption)){ ?>
                @foreach($CheckBoxQuestionOption[$AuditQuestionsValue->atpq_id] as $chekedkey=> $CheckBoxQuestionOptionItem)
                <div class="colorcode colorcode{{$CheckBoxQuestionOptionItem->acqo_optcolor}}">
                    <input <?php echo ($chekedkey==0)?$required:'';?> type="radio" <?php if(in_array($CheckBoxQuestionOptionItem->acqo_id, $answerdata)){echo 'checked="checked"';} ?> id="radio{{$CheckBoxQuestionOptionItem->acqo_id}}" name="aam_answer" value="{{$CheckBoxQuestionOptionItem->acqo_id}}" class="gcspansewertoaudit <?php echo ($chekedkey==0)?$required:'';?>">
                    <label for="radio{{$CheckBoxQuestionOptionItem->acqo_id}}" >{{$CheckBoxQuestionOptionItem->acqo_option}}</label>
                </div> 
                @endforeach
                <?php } ?>   
            </div>
        @else
            <div class="checkbox-toolbar {{$required}}">
            <?php  if(array_key_exists($AuditQuestionsValue->atpq_id,$CheckBoxQuestionOption)){
                $checkboxansarr=array();
                if(!empty($answerdata)){$checkboxansarr=explode(',', $answerdata[0]); }
            ?>
            @foreach($CheckBoxQuestionOption[$AuditQuestionsValue->atpq_id] as $chekedkey=>  $CheckBoxQuestionOptionItem)
            <div class="form-check form-check-inline">
                <input class="form-check-input gcspansewertoaudit <?php echo ($chekedkey==0)?$required:'';?>" type="checkbox" id="checkbox{{$CheckBoxQuestionOptionItem->acqo_id}}" name="aam_answer[]" value="{{$CheckBoxQuestionOptionItem->acqo_id}}" <?php if(in_array($CheckBoxQuestionOptionItem->acqo_id, $checkboxansarr)){echo 'checked="checked"';} ?>>
                <label class="form-check-label" for="checkbox{{$CheckBoxQuestionOptionItem->acqo_id}}">{{$CheckBoxQuestionOptionItem->acqo_option}}</label>
            </div> 
            @endforeach
            <?php } ?>   
        </div>
        @endif
    </div>    
    @endif

    @if($atpq_type==5)
        
        <div class="gridviewtbl">
        <?php $divid=$AuditQuestionsValue->atpq_divid; $noofrows=$AuditQuestionsValue->atpq_no_of_rows; $noofcolumns=$AuditQuestionsValue->atpq_no_of_columns; ?>
            {{ view('audits.addgridviewtable',compact('divid','noofrows','noofcolumns','AuditQuestionsValue','GridViewOption','answerdata')) }}
        </div>

    @endif
</div>