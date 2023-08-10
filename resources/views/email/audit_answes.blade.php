<?php $answerdata=array(); $answerdataID=array(); 
    foreach ($getauditQuestionAns as $anskey => $ans_value) {
        if($ans_value->aam_answer){
            if($ans_value->aam_opt_id){
                $answerdata[$ans_value->aam_opt_id]=$ans_value->aam_answer;
            }else{
                $answerdata[]=$ans_value->aam_answer;    
            }
            
            $answerdataID[]=$ans_value->aam_id;
        }
    }
$required='';
$atpq_type=$getauditQuestion->atpq_type;
?>
<div class="fieldfull" style="font-size: 16px;">
    @if($atpq_type==3)
            <?php if(!empty($answerdata)){echo date('m-d-Y h:i a',strtotime($answerdata[0]));} ?>
    @endif
    @if($atpq_type==4)
        <div class="fieldfullnoevent">        
            <input <?php if(in_array(1, $answerdata)){echo 'checked="checked"';} ?> disabled="disabled"  type="checkbox"  value="1" >
            <label class="form-check-label" >
            {{$getauditQuestion->atpq_declaration_text}}
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
                    echo '<a title="{{$value->attachement_name}}" href="'.url('storage/'.$value).'" target="_blank"><img width="70" height="70" style="width: 70px;z-index: 1; height: 70px; margin-right: 10px;" class="imageThumb" src="'.$attachamentsrc.'" title=""></a></span>';    
                }
            }else{echo '-';}    
            ?>        
    @endif

    @if($atpq_type==2)    
            <div class="radio-toolbar fieldfullnoevent">
                <?php  if(array_key_exists($getauditQuestion->atpq_id,$CheckBoxQuestionOption)){
                    $checkboxansarr=array();
                    if(!empty($answerdata)){$checkboxansarr=explode(',', $answerdata[0]); }
                 ?>
                @foreach($CheckBoxQuestionOption[$getauditQuestion->atpq_id] as $chekedkey=> $CheckBoxQuestionOptionItem)
                <div class="colorcode pb-0 pr-1 colorcode{{$CheckBoxQuestionOptionItem->acqo_optcolor}}">
                    <?php if(in_array($CheckBoxQuestionOptionItem->acqo_id, $checkboxansarr)){?>
                    <label for="radio{{$CheckBoxQuestionOptionItem->acqo_id}}" >{{$CheckBoxQuestionOptionItem->acqo_option}}</label>
                <?php } ?>
                </div> 
                @endforeach
                <?php } ?>   
            </div>            
    @endif

    @if($atpq_type==5)        
        <div class="gridviewtbl">
        <?php $divid=$getauditQuestion->atpq_divid; $noofrows=$getauditQuestion->atpq_no_of_rows; $noofcolumns=$getauditQuestion->atpq_no_of_columns; ?>
            <div class="table-responsive {{$noofcolumns}} {{$noofrows}} gridviewfrontend">
                <table cellpadding="10"  align="left" width="100%" cellspacing="0" border="1" class="table table-bordered" style="text-align: left; border-color: #cccccc;     border: 1px solid #ccc;">
                    <thead>
                    <tr>
                <?php 
                $required='';
                if($getauditQuestion->atpq_is_mandatory==1){$required='required';}
                ?>
                    <?php for ($j=1; $j <=$noofcolumns ; $j++) {
                        $ago_keyword='col'.$j.$getauditQuestion->atpq_atp_id.$getauditQuestion->atpq_id;
                        $colvalue=(array_key_exists($ago_keyword, $GridViewOption))?$GridViewOption[$ago_keyword]:'';
                        ?> 
                        @if($j==1)
                            <th style="background: #cccccc52;">{{$getauditQuestion->atpq_table_heading}}</th>
                        @endif
                        <th style="background: #cccccc52;">{{$colvalue}}</th>
                    <?php } ?>
                    </tr>
                </thead>
                <?php for ($i=1; $i <=$noofrows ; $i++) {?> 
                    <tr>
                    <?php for ($j=1; $j <=$noofcolumns ; $j++) {
                        $ago_keyword='row'.$i.$getauditQuestion->atpq_atp_id.$getauditQuestion->atpq_id;
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