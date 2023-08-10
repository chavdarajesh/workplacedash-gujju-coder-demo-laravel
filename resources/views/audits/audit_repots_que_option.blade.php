<?php $answerdata=array(); $answerdataID=array(); 
if(isset($AuditAnswerMaster[$AuditQuestionsItem->atpq_id])){
    foreach ($AuditAnswerMaster[$AuditQuestionsItem->atpq_id] as $anskey => $ans_value) {
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
if($AuditQuestionsItem->atpq_is_mandatory==1){$required='required';}
?>
<div class="fieldfull">
    @if($atpq_type==3)
            <?php if(!empty($answerdata)){echo date('Y-m-d h:i a',strtotime($answerdata[0]));} ?>
    @endif
    @if($atpq_type==4)
        <div class="fieldfullnoevent">        
            <input <?php if(in_array(1, $answerdata)){echo 'checked="checked"';} ?>  type="checkbox"  value="1" >
            <label class="form-check-label" >
            {{$AuditQuestionsItem->atpq_declaration_text}}
            </label>
        </div>                    
    @endif
    @if($atpq_type==6)
        <?php if(!empty($answerdata)){echo GetSiteAreaName($answerdata[0]);}else{echo '-';} ?>        
    @endif
    @if($atpq_type==7)
        <?php if(!empty($answerdata)){echo $answerdata[0];}else{echo '-';} ?>
    @endif
    @if($atpq_type==8)
        <?php if(!empty($answerdata)){echo $answerdata[0];}else{echo '-';} ?>
    @endif
    @if($atpq_type==9)
        <?php if(!empty($answerdata)){echo GetUserNameWithRole($answerdata[0]);}else{echo '-';} ?> 
    @endif

    @if($atpq_type==1)
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
                    echo '<span data-fileid="0"  class="pip pip'.$answerdataID[$key].'"><a title="{{$value->attachement_name}}" href="'.url('storage/'.$value).'" target="_blank"><img class="imageThumb" src="'.$attachamentsrc.'" title=""></a></span>';    
                }
            }else{echo '-';}    
            ?>        
    @endif

    @if($atpq_type==2)    
            <div class="radio-toolbar fieldfullnoevent">
                <?php  if(array_key_exists($AuditQuestionsItem->atpq_id,$CheckBoxQuestionOption)){
                    $checkboxansarr=array();
                    if(!empty($answerdata)){$checkboxansarr=explode(',', $answerdata[0]); }
                 ?>
                @foreach($CheckBoxQuestionOption[$AuditQuestionsItem->atpq_id] as $chekedkey=> $CheckBoxQuestionOptionItem)
                <div class="colorcode pb-0 pr-1 colorcode{{$CheckBoxQuestionOptionItem->acqo_optcolor}}">
                    <input <?php echo ($chekedkey==0)?$required:'';?> type="radio" <?php if(in_array($CheckBoxQuestionOptionItem->acqo_id, $checkboxansarr)){echo 'checked="checked"';} ?> id="radio{{$CheckBoxQuestionOptionItem->acqo_id}}" name="aam_answer{{$AuditQuestionsItem->atpq_id.$chekedkey}}" value="{{$CheckBoxQuestionOptionItem->acqo_id}}" class=" <?php echo ($chekedkey==0)?$required:'';?>">
                    <label for="radio{{$CheckBoxQuestionOptionItem->acqo_id}}" >{{$CheckBoxQuestionOptionItem->acqo_option}}</label>
                </div> 
                @endforeach
                <?php } ?>   
            </div>            
    @endif

    @if($atpq_type==5)        
        <div class="gridviewtbl">
        <?php $divid=$AuditQuestionsItem->atpq_divid; $noofrows=$AuditQuestionsItem->atpq_no_of_rows; $noofcolumns=$AuditQuestionsItem->atpq_no_of_columns; ?>
            <div class="table-responsive {{$noofcolumns}} {{$noofrows}} gridviewfrontend">
                <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
                    <thead>
                    <tr>
                <?php 
                $required='';
                if($AuditQuestionsItem->atpq_is_mandatory==1){$required='required';}
                ?>
                    <?php for ($j=1; $j <=$noofcolumns ; $j++) {
                        $ago_keyword='col'.$j.$AuditQuestionsItem->atpq_atp_id.$AuditQuestionsItem->atpq_id;
                        $colvalue=(array_key_exists($ago_keyword, $GridViewOption))?$GridViewOption[$ago_keyword]:'';
                        ?> 
                        @if($j==1)
                            <th>{{$AuditQuestionsItem->atpq_table_heading}}</th>
                        @endif
                        <th>{{$colvalue}}</th>
                    <?php } ?>
                    </tr>
                </thead>
                <?php for ($i=1; $i <=$noofrows ; $i++) {?> 
                    <tr>
                    <?php for ($j=1; $j <=$noofcolumns ; $j++) {
                        $ago_keyword='row'.$i.$AuditQuestionsItem->atpq_atp_id.$AuditQuestionsItem->atpq_id;
                        $rowvalue=(array_key_exists($ago_keyword, $GridViewOption))?$GridViewOption[$ago_keyword]:'';
                        ?> 
                        @if($j==1)
                            <td class="firstcoltitle"><span>{{$rowvalue}}</span></td>
                        @endif
                        <td>
                                <?php echo (array_key_exists($i.$j, $answerdata))?$answerdata[$i.$j]:''; ?>
                        </td>
                    <?php } ?>
                    </tr>
                <?php } ?>
                </table>
                </div>


        </div>

    @endif
</div>