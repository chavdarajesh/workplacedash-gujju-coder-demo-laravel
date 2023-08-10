@extends('layouts.dashboard')
@section('content')
<div class="mainmidsec"> 

  <div class="templateleftpanel newauditdiv newauditformwapper">    
	<div class="templateleftpanelinner  newauditmenu">      
	  <div class="auditmenudiv">        
		  <ul>
			<li ><a href="{{route('getauditsection',['adm_id'=>$Audits->adm_id])}}" class=""> {{__('Audit')}} </a>
			  <ul class="gcspsubulaudit"> <?php $active="gcspredirecturl"; ?>
				@foreach($AuditSection as $key=> $AuditSectionItem)
			  <?php if($active=="active"){ $active="checknextpagevalidation";}
				  if($atp_id==''){ if($key==0){$active="active";} }else{  if($atp_id==$AuditSectionItem->atp_id){$active="active";} }
			  ?>
			  <li  ><a class="{{$active}} " href="javascript:void(0);" data-href="{{route('getauditsectionlist',['adm_id'=>$Audits->adm_id,'atp_id'=>$AuditSectionItem->atp_id])}}" data-adm_id="{{$Audits->adm_id}}" data-atp_id="{{$AuditSectionItem->atp_id}}"> <span class="atp_nameheading{{$AuditSectionItem->atp_id}}">{{$AuditSectionItem->atp_name}}</span> </a></li>              
			  @endforeach
			  </ul>
			</li>
			<li class="active"><a class="keyfinfindincount" href="{{route('keyfindings',['adm_id'=>$Audits->adm_id])}}" >{{__('Key Finding(s)')}} ({{$KeyFindingCount}})</a></li>
			<li class=""><a class="actionitemscount" href="{{route('actionitems',['adm_id'=>$Audits->adm_id])}}" >{{__('Action Items')}} ({{$ActionItemCount}})</a></li>
			<li><a href="javascript:void(0);" class="gcspshowtimeline">{{__('Timeline')}}</a></li>
		  </ul>  

			<div class="timelinearea">
				@if(count($GetTimeline))
				<ul>
					@foreach($GetTimeline as $GetTimelineValue)
					<li> 
						@if($GetTimelineValue->atl_type==1){{__('Started')}} @endif
			             @if($GetTimelineValue->atl_type==2){{__('Resumed')}} @endif
			             @if($GetTimelineValue->atl_type==3){{__('Rejected')}} @endif
			             @if($GetTimelineValue->atl_type==4){{__('Completed')}} @endif
						 by 
						<span class="reporttimename">{{$GetTimelineValue->name}} </span> {{__('On')}} <span class="reportdate">{{date('d M, Y, D, h:i a',strtotime($GetTimelineValue->timeline))}}
						@if($GetTimelineValue->atl_reason)	
						<p><b>{{__('Reason')}}:</b> {{$GetTimelineValue->atl_reason}}</p>
						@endif	
						</span>

					</li>
					@endforeach
				  </ul>
				@endif  
			</div>    


	  </div>
	</div>
  </div>

   <div class="templaterightpanel formcontent">
   	<input type="hidden" name="cadm_id" value="{{$Audits->adm_id}}">
   	<input type="hidden" name="catp_id" value="{{$AuditSectionDetails->atp_id}}">

  <div class="gcspauditsewctiofrm">
	<div class="row">
	  <div class="audsumhead">
		<div class="audheadtop">
		  <h3>{{$AuditTemplates->atm_audit_name}}</h3>
		  <p>{{$AuditTemplates->atm_description}}</p>
		</div>
		<div class="audsumscores">
		  <div class="scorehead"><span class="label">{{__('Inspection score')}}</span><span class="labelvalue">{{GetInspectionScore($Audits->adm_id,$Audits->adm_atm_id)}}</span></div>          
		  <div class="scorehead"><span class="label">{{__('Key Finding(s)')}}</span><span class="labelvalue keyfinfindincountright">{{$KeyFindingCount}}</span></div>          
		  <div class="scorestatus">
			<div class="auditstatus"><span class="inprogress"> {{__('In Progress')}}</span></div>
		  </div>
		</div>        
	  </div>
	</div>
	  
	@if(count($AuditQuestions))
	<div class="row p-4 gcspauditformwapper">
	  <h5 class="font-weight-bold"><i class="fa fa-angle-down"></i> {{$AuditSectionDetails->atp_name}}</h5>    
	@foreach($AuditQuestions as $AuditQuestionsValue)
	<div class="col-sm-12  mt-3 gcspquetionwpr gcspquetionwpr{{$AuditQuestionsValue->atpq_divid}}">
	  <form enctype="multipart/form-data" method="post" id="mainqustionfrm{{$AuditQuestionsValue->atpq_divid}}" action="{{route('ansewertoaudit')}}" class="ansewertoaudit">
		<input type="hidden" name="atpq_id" value="{{$AuditQuestionsValue->atpq_id}}">
		<input type="hidden" name="atpq_divid" value="{{$AuditQuestionsValue->atpq_divid}}">
		<input type="hidden" name="atpq_atp_id" value="{{$AuditQuestionsValue->atpq_atp_id}}">
		<input type="hidden" name="atpq_atm_id" value="{{$AuditQuestionsValue->atpq_atm_id}}">
		<input type="hidden" name="adm_id" value="{{$Audits->adm_id}}">
		<input type="hidden" name="atpq_type" value="{{$AuditQuestionsValue->atpq_type}}">        
		
		<div class="gcspquetioninner">
		  <div class="row">
			<div class="col-sm-10">
			  <p> @if($AuditQuestionsValue->atpq_is_mandatory==1) <span class="required p-0">*</span> @endif
				{{$AuditQuestionsValue->atpq_question}}</p>          
			  @if($AuditQuestionsValue->atpq_is_description==1 && $AuditQuestionsValue->atpq_description_text!='')
			  <p class="gcspquestiondesc"><b>{{__('Description')}}:</b> {{$AuditQuestionsValue->atpq_description_text}}</p>          
			  @endif
			</div>
			<div class="col-sm-2 questionlabel keyfnotifysection <?php echo (isset($AuditAnswerMaster[$AuditQuestionsValue->atpq_id]))?'showkfandnotify':'';?>">
				<div class="remarksicon gcspkeyfinndingwapper " >
				  <label class="lblcontainer">
					<input type="checkbox" class="gcspaddkeyfindingchange" data-atpq_id="{{$AuditQuestionsValue->atpq_id}}" name="keyfinding" value="1" <?php echo (isset($KeyFinding[$AuditQuestionsValue->atpq_id]))?'checked="checked"':'' ?> ><span class="checkmark"></span></label>
				</div>
				<div class="notifyicon notifyiconwapper">
				  <label class="lblcontainer"> {{__('Notify')}}
					<input type="checkbox" class="gcspaddnotifychange"  data-atpq_id="{{$AuditQuestionsValue->atpq_id}}"  name="notify" value="1"  <?php echo (isset($AuditUserNotify[$AuditQuestionsValue->atpq_id]))?'checked="checked"':'' ?> ><span class="checkmark"></span></label>
				</div>
			</div>  
		  </div>
		  <?php $atpq_type=$AuditQuestionsValue->atpq_type; ?>
		  {!! view('audits.auditquestionoption',compact('AuditQuestionsValue','atpq_type','Auditor','AuditAnswerMaster','CheckBoxQuestionOption','GridViewOption')) !!}

		  <div class="gcspkeyfindinnotify">
			  <div class="gckeyfinfingwpr mt-2 gckeyfinfingwpr{{$AuditQuestionsValue->atpq_id}}" style="<?php echo (isset($KeyFinding[$AuditQuestionsValue->atpq_id]))?'display: block;':'' ?>">
				<div class="row">
					<div class="col-sm-9"><b>{{__('Description of Key Finding')}}</b></div>
					<div class="col-sm-3 text-right"><button data-atpq_id="{{$AuditQuestionsValue->atpq_id}}" type="button" class="btn btn-primary gcspaddactiontoaudit">{{__('Add new action')}}</button></div>
					<div class="col-sm-12 mt-1"> 
					  <textarea class="form-control ak_keyfinding" name="ak_keyfinding"><?php if(isset($KeyFinding[$AuditQuestionsValue->atpq_id])){  echo $KeyFinding[$AuditQuestionsValue->atpq_id][0]->ak_keyfinding; } ?></textarea>
					</div>
				</div>  
			  </div>  

			  <div class="gcnotifywpr mt-2 gcnotifywpr{{$AuditQuestionsValue->atpq_id}}" style="<?php echo (isset($AuditUserNotify[$AuditQuestionsValue->atpq_id]))?'display: block;':'' ?>">
				<div class="row">
					<div class="col-sm-12 mt-1">
					  <select class="form-control multipleSelect audit_notify" multiple name="audit_notify[]">                    
						<?php if(count($Auditor)){   $audit_notify_singlequstion=array();
						if(isset($AuditUserNotify[$AuditQuestionsValue->atpq_id])){                          
						  foreach ($AuditUserNotify[$AuditQuestionsValue->atpq_id] as $key => $audit_notify_value) {
							$audit_notify_singlequstion[]=$audit_notify_value->aun_user_id;
						  }                          
						}                      
						  foreach ($Auditor as $key => $value) { ?>
						  <option <?php echo (in_array($value->id,$audit_notify_singlequstion))?'selected="selected"':''; ?> value="{{$value->id}}">{{$value->name}} - {{$value->r_name}}</option>    
						  <?php } } ?>             
					  </select>
					</div>
				</div>  
			  </div>
				
		  </div>  

		</div>        
	  </form>
	  <div class="gcspsubquestionwpr pl-3 gcspsubquestionwpr{{$AuditQuestionsValue->atpq_id}}">
		<?php if(isset($AuditAnswerMaster[$AuditQuestionsValue->atpq_id]) && $AuditQuestionsValue->atpq_type==2 && $AuditQuestionsValue->atpq_is_rules==1 && $AuditQuestionsValue->atpq_is_multiple_choice!=1){

				foreach ($AuditAnswerMaster[$AuditQuestionsValue->atpq_id] as $anskey => $ans_value) {
					if($ans_value->aam_answer){                
					 $answerdata=$ans_value->aam_answer;    
					}
				}        
				if(isset($AuditSubQuestionsArr[$answerdata])){
				$AuditSubQuestions=$AuditSubQuestionsArr[$answerdata];
				  echo view('audits.auditssubqueform',compact('GridViewOption','AuditSubQuestions','CheckBoxQuestionOption','Audits','Auditor','AuditAnswerMaster','KeyFinding','AuditUserNotify'));
				}
			  }  
	   ?> 
	  </div>


	</div>    
	@endforeach
	<div class="col-sm-12 mt-5 gcspaddnewquetionwpr">
	  <div class="row">
	  	<div class="col-sm-8">
	  	<?php  $sectionkey=array();  $atp_id;
	  	foreach($AuditSection as $key=> $AuditSectionItem){
	  		$sectionkey[]=$AuditSectionItem->atp_id;
	  	}	  	
	  	$ckey=array_search($atp_id,$sectionkey);
	  	if(isset($sectionkey[$ckey-1])){?>
	  		<a href="{{route('getauditsectionlist',['adm_id'=>$Audits->adm_id,'atp_id'=>$sectionkey[$ckey-1]])}}"  class="btn btn-primary ">{{__('Previous')}} </a>
	  	<?php }	
	  	if(isset($sectionkey[$ckey+1])){?>
	  		<a href="javascript:void(0);" data-href="{{route('getauditsectionlist',['adm_id'=>$Audits->adm_id,'atp_id'=>$sectionkey[$ckey+1]])}}"  class="btn btn-primary checknextpagevalidation">{{__('Next')}} </a>
	  	<?php }	?>
		
		</div>
		<div class="col-sm-4 text-right">
			<button type="submit" id="submit" class="btn btn-primary checkallvalidation"> {{__('Save')}} </button>
			<?php if(!isset($sectionkey[$ckey+1])){?>
			<form method="post" onsubmit="return Confirm('Are you sure you want to complate this audit and send for approval');" action="{{route('auditchangetocomplate')}}" class="d-inline">
				@csrf
				<input type="hidden" name="adm_id" value="{{$Audits->adm_id}}">
				<button type="submit" id="submit" class="btn btn-primary gcspauditcompletebtn" disabled="disabled"> {{__('Complete')}} </button>
			</form>
			<?php } ?>
		</div>
	  </div>  
	</div>
	</div>
	@endif


	

  </div>

  </div> 
</div>  
<div class="modal fade" id="AuditActionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"></div>
@endsection 