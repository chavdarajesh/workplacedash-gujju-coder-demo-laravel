@if(count($AuditSubQuestions[$option_id]))
    @foreach($AuditSubQuestions[$option_id] as $AuditQuestionsValue)
    <div class="row mt-3 gcspquetionwpr gcspquetionwpr{{$AuditQuestionsValue->atpq_divid}}">
      <form method="post" id="mainqustionfrm{{$AuditQuestionsValue->atpq_divid}}" action="{{route('addupdatequstion')}}" class="addupdatequstion">
        <input type="hidden" name="atpq_id" value="{{$AuditQuestionsValue->atpq_id}}">
        <input type="hidden" name="atpq_divid" value="{{$AuditQuestionsValue->atpq_divid}}">
        <input type="hidden" name="atpq_atp_id" value="{{$AuditQuestionsValue->atpq_atp_id}}">
        <input type="hidden" name="atpq_atm_id" value="{{$AuditQuestionsValue->atpq_atm_id}}">
        <div class="col-sm-8 gcspquetioninner">
          <div class="form_txt_edit"><textarea maxlength="500" name="atpq_question" class="form-control" >{{$AuditQuestionsValue->atpq_question}}</textarea></div>
          <div class="questionruleswpr">
            <?php $divid=$AuditQuestionsValue->atpq_divid; $atpq_type=$AuditQuestionsValue->atpq_type; ?>
            {{ view('audittemplates.editquestionoption',compact('divid','atpq_type','CheckBoxOption','AuditQuestionsValue','GridViewOption','CheckBoxQuestionOption')) }}
          </div>      
        </div>
        <div class="col-sm-4  gcspquetioninner gpqustiondelete">
          <a href="javascript:void(0);" data-divid="{{$AuditQuestionsValue->atpq_divid}}" data-atpq_id="{{$AuditQuestionsValue->atpq_id}}" class="gpqustiondeletetag gpqustionremove"><i class="fa fa-trash"></i></a>
          <select required class="form-control atpq_type" data-divid="{{$AuditQuestionsValue->atpq_divid}}" data-atpq_id="{{$AuditQuestionsValue->atpq_id}}" name="atpq_type">
            <option value="">{{__('Please choose option')}}</option>
            <option value="1" {{($AuditQuestionsValue->atpq_type==1)?'selected':''}} >{{__('Attachments')}}</option>
            <option value="2" {{($AuditQuestionsValue->atpq_type==2)?'selected':''}} >{{__('Check Box')}}</option>
            <option value="3" {{($AuditQuestionsValue->atpq_type==3)?'selected':''}} >{{__('Date / Time')}}</option>
            <option value="4" {{($AuditQuestionsValue->atpq_type==4)?'selected':''}} >{{__('Declaration')}}</option>
            <option value="5" {{($AuditQuestionsValue->atpq_type==5)?'selected':''}} >{{__('Grid View')}}</option>
            <option value="6" {{($AuditQuestionsValue->atpq_type==6)?'selected':''}} >{{__('Site List From Master')}}</option>
            <option value="7" {{($AuditQuestionsValue->atpq_type==7)?'selected':''}} >{{__('Text Area')}}</option>
            <option value="8" {{($AuditQuestionsValue->atpq_type==8)?'selected':''}} >{{__('Text Field')}}</option>
            <option value="9" {{($AuditQuestionsValue->atpq_type==9)?'selected':''}} >{{__('User List From Master')}}</option>            
          </select>

          <a href="javascript:void(0);" data-toggle="modal" class="CheckBoxOptionModal CheckBoxOptionModal{{$AuditQuestionsValue->atpq_divid}}" data-target="#CheckBoxOptionModal{{$AuditQuestionsValue->atpq_divid}}" style="{{($AuditQuestionsValue->atpq_type==2)?'display: block;':''}}"><i class="fa fa-plus"></i> {{__('Add options')}}</a>
        </div>
      </form>

     

    </div>
    @endforeach
    @endif