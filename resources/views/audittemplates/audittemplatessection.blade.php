@extends('layouts.dashboard')
@section('content')
<div class="mainmidsec"> 
  <div class="templateleftpanel">    
    <div class="templateleftpanelinner">
        <div class="gcsptmpheading">
          <div class="gcsptmpimg">
            @if($AuditTemplates->atm_icon)
            <img src="{{url('storage/'.$AuditTemplates->atm_icon)}}">
            @else
            <img src="{{asset('images/auditicon.png')}}">
            @endif
          </div>
          <div class="gcsptmoname"><h3>{{$AuditTemplates->atm_audit_id}}</h3>
            <span>{{$AuditTemplates->atm_audit_name}}</span>
          </div>
        </div>
        <div class="tmpsctionmain">
            <ul>
              @foreach($AuditSection as $key=> $AuditSectionItem)
              <?php $active="";
                  if($atp_id==''){ if($key==0){$active="active";} }else{  if($atp_id==$AuditSectionItem->atp_id){$active="active";} }
              ?>
              <li class="{{$active}}" ><a href="{{route('getsetionslist',['atm_id'=>$AuditSectionItem->atp_atm_id,'atp_id'=>$AuditSectionItem->atp_id])}}"> <span class="atp_nameheading{{$AuditSectionItem->atp_id}}">{{$AuditSectionItem->atp_name}}</span> </a></li>              
              @endforeach
            </ul>
        </div>
        <div class="tmpsctionaddnew">          
          <a href="javascript:void(0);" class="gcspaddtmpsection"><i class="fa fa-plus " aria-hidden="true"></i> {{__('Add new from')}}</a>
          <div class="form-group p-1 mt-1 gcspnewsectionarea">              
            <form id="storesection" action="{{route('storesection')}}" method="post" enctype="multipart/form-data">
            @csrf
              <input type="hidden" value="{{$AuditTemplates->atm_id}}" name="atp_atm_id">
              <input type="text" required placeholder="Section Name" class="form-control" value="" name="atp_name">
              <input type="submit" class="btn btn-primary mt-1" value="Save" name="Save">
            </form>
          </div>          
        </div>  
    </div>
  </div>

   <div class="templaterightpanel formcontent">
    
  <div class="row">
  <div class="col-sm-6">
    <span><h2 ><span class="atp_nameheading">{{$AuditSectionDetails->atp_name}}</span><span class="editpencil editpencilatpname ml-2"><i class="fa fa-edit"></i></span></h2></span>
    <input type="text" value="{{$AuditSectionDetails->atp_name}}" class="form-control mt-1 editpencilatpnametext" data-atp_id="{{$AuditSectionDetails->atp_id}}" name="atp_name">
  </div>
  <div class="col-sm-6 text-right">
      <div class="pull-right permit_delete">
        <div class="switchlabelfull">
          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input changesectionstatus" data-atp_id="{{$AuditSectionDetails->atp_id}}" name="atp_status" id="customSwitches" {{($AuditSectionDetails->atp_status==1)?'checked':''}}>
            <label class="custom-control-label" for="customSwitches">{{__('Enable')}}</label>
          </div>
        </div>
        @if(count($AuditSection)>1)
        <div class="delete_permits"><a href="{{route('delelteseaction',['atp_id'=>$AuditSectionDetails->atp_id])}}"  class="delelteseaction" >{{__('Delete All')}} </a></div>
        @endif
      </div>
    </div>
  </div>

  <div class="gcspauditsewctiofrm">
    <div class="row mt-5">
        <div class="col-sm-8">{{__('Question')}}</div>
        <div class="col-sm-4">{{__('Response Type')}}</div>
    </div> 

    @if(count($AuditQuestions))
    @foreach($AuditQuestions as $AuditQuestionsValue)
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
            {{ view('audittemplates.editquestionoption',compact('divid','atpq_type','CheckBoxOption','AuditQuestionsValue','GridViewOption'
            ,'CheckBoxQuestionOption')) }}
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

      <div class="col-sm-12 gcsprulescontaner gcsprulescontanerhide gcsprulescontaner{{$AuditQuestionsValue->atpq_divid}}" style="{{($AuditQuestionsValue->atpq_is_rules==1)?'display: block;':''}}">
        <?php  $acqo_id=array(); $aco_name=array(); 
          $divid=$AuditQuestionsValue->atpq_divid;
          $atp_id=$AuditQuestionsValue->atpq_atp_id;
          $atp_atm_id=$AuditQuestionsValue->atpq_atm_id;
          $atpq_id=$AuditQuestionsValue->atpq_id;

            if(array_key_exists($AuditQuestionsValue->atpq_id, $CheckBoxQuestionOption)) {
              foreach ($CheckBoxQuestionOption[$AuditQuestionsValue->atpq_id] as $key => $value) {
                  $acqo_id[]=$value->acqo_id;
                  $aco_name[]=$value->acqo_option;//['acqo_option'];
              }               
         ?>
          {{ view('audittemplates.rulestabs',compact('divid','aco_name','acqo_id','atp_id','atp_atm_id','atpq_id','AuditSubQuestions','CheckBoxOption','GridViewOption','CheckBoxQuestionOption')) }}
         <?php } ?> 
      </div>

    </div>
    @endforeach
    @endif




    <div class="row mt-5  mb-5 gcspaddnewquetionwpr">
        <div class="col-sm-8"><a href="{{route('addnewquestion')}}" data-atp_id="{{$AuditSectionDetails->atp_id}}" data-atp_atm_id="{{$AuditSectionDetails->atp_atm_id}}" class="btn btn-primary addnewquestion"><i class="fa fa-plus" aria-hidden="true"></i> {{__('Add options')}} </a></div>
        <input type="hidden" name="atpq_atp_id" value="{{$AuditSectionDetails->atp_id}}">
        <input type="hidden" name="atpq_atm_id" value="{{$AuditSectionDetails->atp_atm_id}}">
        <div class="col-sm-4 text-right"><button type="submit" id="submit" class="btn btn-primary"> {{__('Save')}} </button></div>
    </div>

  </div>

  </div> 
</div>  
@endsection 