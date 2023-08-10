<div class="mt-2">
    @if($atpq_type==4)
    <div class="form-group">
        <label ><b>{{__('Declaration Text')}} </b></label>
        <textarea name="atpq_declaration_text" class="form-control DeclarationText ">{{$AuditQuestionsValue->atpq_declaration_text}}</textarea>
    </div>
    @endif
    <div class="form-group hideDescription" style="{{($AuditQuestionsValue->atpq_is_description==1)?'display: block;':''}}">
        <label ><b>{{__('Description')}}</b></label>
        <textarea  name="atpq_description_text" class="form-control">{{$AuditQuestionsValue->atpq_description_text}}</textarea>
    </div>
    @if($atpq_type==2)
    @if($atpq_type==2 && $AuditQuestionsValue->atpq_parent_id==null)
    <div class="form-check form-check-inline gcsprulesckdiv{{$divid}}  gcsprulesckdiv " style="{{($AuditQuestionsValue->atpq_is_multiple_choice==1)?'display: none;':''}}">
        <input class="form-check-input gcsphaverules" {{($AuditQuestionsValue->atpq_is_rules==1)?'checked':''}} name="atpq_is_rules" data-divid="{{$divid}}" type="checkbox" id="Rules{{$divid}}" value="1">
        <label class="form-check-label" for="Rules{{$divid}}">{{__('Rules')}} <i class="fa fa-arrow-circle-down" aria-hidden="true"></i></label>
    </div>
    @endif
    <div class="form-check form-check-inline">
        <input class="form-check-input" data-divid="{{$divid}}" {{($AuditQuestionsValue->atpq_is_multiple_choice==1)?'checked':''}} name="atpq_is_multiple_choice" type="checkbox" id="MultipleChoice{{$divid}}" value="1">
        <label class="form-check-label" for="MultipleChoice{{$divid}}">{{__('Multiple Choice')}}</label>
    </div>
    @endif
    <div class="form-check form-check-inline">
        <input class="form-check-input" {{($AuditQuestionsValue->atpq_is_mandatory==1)?'checked':''}} name="atpq_is_mandatory" type="checkbox" id="Mandatory{{$divid}}" value="1">
        <label class="form-check-label" for="Mandatory{{$divid}}">{{__('Mandatory')}}</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input gcspshowdescription" {{($AuditQuestionsValue->atpq_is_description==1)?'checked':''}} name="atpq_is_description" data-divid="{{$divid}}" type="checkbox" id="Description{{$divid}}" value="1">
        <label class="form-check-label" for="Description{{$divid}}">{{__('Description')}}</label>
    </div>
    @if($atpq_type==3)
    <div class="form-check form-check-inline">
        <input class="form-check-input" {{($AuditQuestionsValue->atpq_is_date==1)?'checked':''}} name="atpq_is_date" type="checkbox" id="Date{{$divid}}" value="1">
        <label class="form-check-label" for="Date{{$divid}}">{{__('Date')}}</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" {{($AuditQuestionsValue->atpq_is_time==1)?'checked':''}} name="atpq_is_time" data-divid="{{$divid}}" type="checkbox" id="Time{{$divid}}" value="1">
        <label class="form-check-label" for="Time{{$divid}}">{{__('Time')}}</label>
    </div>
    @endif
    @if($atpq_type==5)
    <div class="form-check form-check-inline">
        <input class="form-check-input gcspdisablerowheadcheck" {{($AuditQuestionsValue->atpq_is_row_headers==1)?'checked':''}} name="atpq_is_row_headers" data-divid="{{$divid}}" type="checkbox" id="RowHeaders{{$divid}}" value="1">
        <label class="form-check-label" for="RowHeaders{{$divid}}">{{__('Row Headers')}}</label>
    </div>    
    @endif 
    @if($atpq_type==8)
    <div class="form-check form-check-inline">
        <select name="atpq_is_text_type" class="form-control">
            <option value="">{{__('Choose Type')}}</option>
            <option value="1" {{($AuditQuestionsValue->atpq_is_text_type==1)?'selected':''}}>{{__('Alphanumeric')}}</option>
            <option value="2" {{($AuditQuestionsValue->atpq_is_text_type==2)?'selected':''}}>{{__('Only Numbers')}}</option>
            <option value="3" {{($AuditQuestionsValue->atpq_is_text_type==3)?'selected':''}}>{{__('Only Text')}}</option>
        </select>
        
    </div>    
    @endif       
</div>
@if($atpq_type==1)
<div class="mt-3">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label>{{__('File type')}}<span class="required">*</span></label>
                <select name="atpq_file_type" class="form-control" >
                    <option value="">{{__('File type')}}</option>
                    <option value="1" {{($AuditQuestionsValue->atpq_file_type==1)?'selected':''}}>{{__('All')}}</option>
                    <option value="2" {{($AuditQuestionsValue->atpq_file_type==2)?'selected':''}}>{{__('Only Images')}}</option>
                    <option value="3" {{($AuditQuestionsValue->atpq_file_type==3)?'selected':''}}>{{__('Only Documents')}}</option>
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>{{__('No of Files')}}<span class="required">*</span></label>
                <select name="atpq_no_of_files" class="form-control" >
                    <option value="">{{__('Choose Max Files')}}</option>
                    <option value="1"  {{($AuditQuestionsValue->atpq_no_of_files==1)?'selected':''}} >1</option>
                    <option value="5"  {{($AuditQuestionsValue->atpq_no_of_files==5)?'selected':''}} >5</option>
                    <option value="10" {{($AuditQuestionsValue->atpq_no_of_files==10)?'selected':''}} >10</option>
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label>{{__('File Size')}}<span class="required">*</span></label>
                <select name="atpq_file_size" class="form-control" >
                    <option value="">{{__('Choose Max Filesize')}}</option>
                    <option {{($AuditQuestionsValue->atpq_file_size==1)?'selected':''}}  value="1">1 MB</option>
                    <option {{($AuditQuestionsValue->atpq_file_size==5)?'selected':''}}  value="5">5 MB</option>
                    <option {{($AuditQuestionsValue->atpq_file_size==10)?'selected':''}} value="10">10 MB</option>
                    <option {{($AuditQuestionsValue->atpq_file_size==20)?'selected':''}} value="20">20 MB</option>
                </select>
            </div>
        </div>    
    </div>    
</div>
@endif
@if($atpq_type==3)
<div class="mt-3">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>{{__('Choose Max Filesize')}}<span class="required">*</span></label>
                <input type="text" required value="{{($AuditQuestionsValue->atpq_start_date)?date('d-m-Y',strtotime($AuditQuestionsValue->atpq_start_date)):''}}" name="atpq_start_date" class="form-control gcspdatepicker">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>{{__('Select End Date')}}<span class="required">*</span></label>
                <input type="text" value="{{($AuditQuestionsValue->atpq_end_date)?date('d-m-Y',strtotime($AuditQuestionsValue->atpq_end_date)):''}}" required name="atpq_end_date" class="form-control gcspdatepicker">
            </div>
        </div>        
    </div>    
</div>
@endif
@if($atpq_type==5)
<div class="mt-3">
    <div class="row gcspgridviewinput{{$divid}}">
        <div class="col-sm-6">
            <div class="form-group">
                <label>{{__('No of Rows')}}<span class="required">*</span></label>
                <input type="text" required value="{{$AuditQuestionsValue->atpq_no_of_rows}}" name="atpq_no_of_rows" data-divid="{{$divid}}" data-atpq_id="{{$AuditQuestionsValue->atpq_id}}" class="form-control gcspgriedvireadd">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>{{__('No of Columns')}}<span class="required">*</span></label>
                <input type="numbers" required value="{{$AuditQuestionsValue->atpq_no_of_columns}}" max="15" name="atpq_no_of_columns" data-divid="{{$divid}}" data-atpq_id="{{$AuditQuestionsValue->atpq_id}}" class="form-control gcspgriedvireadd">
            </div>
        </div>        
    </div> 
    <div class="gridviewtbl gridview{{$divid}}">
        <?php $divid=$AuditQuestionsValue->atpq_divid; $noofrows=$AuditQuestionsValue->atpq_no_of_rows; $noofcolumns=$AuditQuestionsValue->atpq_no_of_columns; ?>
            {{ view('audittemplates.addgridviewtable',compact('divid','noofrows','noofcolumns','AuditQuestionsValue','GridViewOption')) }}
    </div>
</div>    
@endif



@if($atpq_type==2)
<!-- Modal -->
<div class="gcspckoptmodal modal fade right CheckBoxOptionModalPopup" id="CheckBoxOptionModal{{$divid}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
  
  <input type="hidden" name="divid" value="{{$divid}}">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalPreviewLabel">{{__('Choose an option')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>         
      <div class="modal-body">
            <div class="gcsppredefineoptionwp gcsppredefineoptionwp{{$divid}}">
            @foreach($CheckBoxOption as $keycbo =>  $CheckBoxOptionItem)
            <div class="form-check mb-2">
                @foreach($CheckBoxOptionItem as $CheckBoxOptionItemValue)
                <input class="form-check-input gcspckbaddpreoption" data-divid="{{$divid}}" type="radio" name="predefineoption" id="exampleRadios{{$keycbo}}{{$divid}}" value="{{$CheckBoxOptionItemValue->aco_grpid_id}}" >
                <label class="form-check-label" for="exampleRadios{{$keycbo}}{{$divid}}">
                    <div class="resrowbadge">
                @break
                @endforeach
                
                        @foreach($CheckBoxOptionItem as $CheckBoxOptionItemValue)
                        <span class="optcolor{{$CheckBoxOptionItemValue->optcolor}}"> {{$CheckBoxOptionItemValue->aco_name}} </span>
                        @endforeach
                    </div>
                </label>
            </div>
            @endforeach
            </div>
            <div class="mb-5"></div>
            <div class="gcspoptioncontaner gcspoptioncontaner{{$divid}}">
                <input type="hidden" name="aco_grpid_id" value="{{$divid}}" >

            <?php  if(array_key_exists($AuditQuestionsValue->atpq_id,$CheckBoxQuestionOption)){ ?>
            @foreach($CheckBoxQuestionOption[$AuditQuestionsValue->atpq_id] as $CheckBoxQuestionOptionItem)

            <div class="row mb-2">
            <div class="col-sm-6"><input type="text" class="form-control aco_name" data-divid="{{$divid}}" required name="aco_name[]" value="{{$CheckBoxQuestionOptionItem->acqo_option}}"></div>
            <div class="col-sm-1 gcspcolopickerrel">
                <input type="hidden" class="form-control gcsptopncolorvalue" value="{{$CheckBoxQuestionOptionItem->acqo_optcolor}}" name="optcolor[]">
                <span class="gcspcolorcircle gcspcolorcirclechange optcolor{{$CheckBoxQuestionOptionItem->acqo_optcolor}}"></span>
                <div class="gcspcolopickerwpr">
                    <span class="gcspcolorcircle optcolor1" data-value="1"></span>
                    <span class="gcspcolorcircle optcolor2" data-value="2"></span>
                    <span class="gcspcolorcircle optcolor3" data-value="3"></span>
                    <span class="gcspcolorcircle optcolor4" data-value="4"></span>
                    <span class="gcspcolorcircle optcolor5" data-value="5"></span>
                    <span class="gcspcolorcircle optcolor6" data-value="6"></span>
                    <span class="gcspcolorcircle optcolor7" data-value="7"></span>
                    <span class="gcspcolorcircle optcolor8" data-value="8"></span>
                </div>    
            </div>
            <div class="col-sm-1"><a data-divid="{{$divid}}" class="gcspremoveoptioninpopup" href="javascript:void(0);"><i class="fa fa-trash"></i></a></div>
            </div>
            @endforeach
        <?php } ?>

            </div>
            <div class="gcspaddnewoptionvaluewpr mb-3">
                <a data-divid="{{$divid}}" href="javascript:void(0);"><i class="fa fa-plus mr-1"></i>{{__('Add Another')}}</a>
            </div>
            <div class="gcspaddnewoptionsavecheck mb-3 ">
                <div class="form-check">
                    <input class="form-check-input"  data-divid="{{$divid}}" type="checkbox" value="1" name="Addthisasanewoption" id="Addthisasanewoption{{$divid}}" >
                    <label class="form-check-label" for="Addthisasanewoption{{$keycbo}}{{$divid}}">{{__('Add this as a new option')}}</label>
                </div>
            </div>
            <div class="gcspfooter">
                <button type="button" class="btn btn-primary gcspsavenewoption"  disabled="disabled" data-divid="{{$divid}}">{{__('Apply')}}</button>
                <button type="button" class="btn btn-secondary closemodal" data-dismiss="modal">{{__('Cancel')}}</button>
            </div>
            
    </div>      
    </div>
  </div>

</div>
<!-- Modal -->
@endif