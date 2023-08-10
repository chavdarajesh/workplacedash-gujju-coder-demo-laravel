@extends('layouts.dashboard')
@section('content')
<div class="mainmidsec"> 

	<div class="templateleftpanel newauditdiv newauditformwapper">    
		<div class="templateleftpanelinner  newauditmenu">      
			<div class="auditmenudiv">        
					<ul>
						<li ><a href="{{route('getauditsection',['adm_id'=>$Audits->adm_id])}}" class=""> {{__('Audit')}} </a>
							<ul class="gcspsubulaudit">
								@foreach($AuditSection as $key=> $AuditSectionItem)
							<?php $active="";?>
							<li  ><a class="{{$active}}" href="{{route('getauditsectionlist',['adm_id'=>$Audits->adm_id,'atp_id'=>$AuditSectionItem->atp_id])}}"> <span class="atp_nameheading{{$AuditSectionItem->atp_id}}">{{$AuditSectionItem->atp_name}}</span> </a></li>              
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
					<li> @if($GetTimelineValue->atl_type==1){{__('Started')}} @endif
			             @if($GetTimelineValue->atl_type==2){{__('Resumed')}} @endif
			             @if($GetTimelineValue->atl_type==3){{__('Rejected')}} @endif
			             @if($GetTimelineValue->atl_type==4){{__('Completed')}} @endif
						 {{__('By')}} 
						<span class="reporttimename">{{$GetTimelineValue->name}} </span> {{__('On')}} <span class="reportdate">{{date('d M, Y, D, h:i a',strtotime($GetTimelineValue->timeline))}}</span></li>

					@endforeach
				  </ul>
				@endif  
			</div>    

			</div>
		</div>
	</div>

	 <div class="templaterightpanel formcontent">


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


		@if(count($GetActions))
		@foreach($GetActions as $KeyFindingsItem)
		<div class="row p-4 gcspauditformwapper">
			@foreach($KeyFindingsItem as $key=> $KeyFindingsItemValue)
			@if($key==0)
			<h5 class="font-weight-bold hidekeyfindindsec" data-ak_atp_id="{{$KeyFindingsItemValue->ak_atp_id}}"><i class="fa fa-angle-down"></i> {{$KeyFindingsItemValue->atp_name}}</h5>
			@endif
			<div class="col-sm-12  mt-3 gcspquetionwpr {{$KeyFindingsItemValue->atpq_id}}  gcspquetionwpr{{$KeyFindingsItemValue->ak_atp_id}}">
				<div class="gcspquetioninner">
					<div class="row">
						<div class="col-sm-12">
							<p>{{$KeyFindingsItemValue->atpq_question}}</p>
							@if($KeyFindingsItemValue->atpq_is_description==1 && $KeyFindingsItemValue->atpq_description_text!='')
							<p class="gcspquestiondesc"><b>{{__('Description')}}:</b> {{$KeyFindingsItemValue->atpq_description_text}}</p>          
							@endif
							<?php if(isset($ActionsAdded[$KeyFindingsItemValue->atpq_id])){?>
							<div class="getactioneapperloop">
								
									<form enctype="multipart/form-data" method="post" id="mainqustionfrm{{$KeyFindingsItemValue->atpq_divid}}" action="javascript:void(0);" class="ansewertoaudit  gcspgetkeyfindings">
										<div class="row">
									    <input type="hidden" name="atpq_id" value="{{$KeyFindingsItemValue->atpq_id}}">
									    <input type="hidden" name="atpq_divid" value="{{$KeyFindingsItemValue->atpq_divid}}">
									    <input type="hidden" name="atpq_atp_id" value="{{$KeyFindingsItemValue->atpq_atp_id}}">
									    <input type="hidden" name="atpq_atm_id" value="{{$KeyFindingsItemValue->atpq_atm_id}}">
									    <input type="hidden" name="adm_id" value="{{$Audits->adm_id}}">
									    <input type="hidden" name="atpq_type" value="{{$KeyFindingsItemValue->atpq_type}}">
										<div class="col-sm-8"><h5><b>{{__('Corrective Actions')}} ({{count($ActionsAdded[$KeyFindingsItemValue->atpq_id])}})</b></h5></div>
										<div class="col-sm-4 text-right"><button data-atpq_id="{{$KeyFindingsItemValue->atpq_id}}" type="button" class="btn btn-primary gcspaddactiontoaudit">{{__('Add new')}}</button></div>
										</div>
									</form>
								
							</div>
								<?php
									foreach ($ActionsAdded[$KeyFindingsItemValue->atpq_id] as $key => $value) {?>
										<div class="auditactitem">
									        <div class="audititemtext">
									            <p>{{$value->am_description}}</p>
									            <div class="controlaudits"><span>{{$value->cm_name}} {{__('Control')}}</span>, {{__('Assigned to')}} <span> {{GetActionResponsibility($value->am_id)}}</span>, {{__('Due by')}} <span>  {{date('d M, Y',strtotime($value->am_due_date))}} </span></div>
									        </div> 
									        <div class="auditactopt">
									        		<a href="javascript:void(0);" data-am_id="{{$value->am_id}}" class="ml-1 auditactionsedit"><i class="fa fa-edit"></i></a>
							  						<a href="javascript:void(0);" data-am_id="{{$value->am_id}}" class="ml-1 auditactionsdelete"><i class="fa fa-trash"></i></a>
									        </div>           										    
										</div>
									<?php }
								?>
							<?php }else{ ?>
								<div class="getactioneapperloop">
								<div class="getactioneapperloop">
								
									<form enctype="multipart/form-data" method="post" id="mainqustionfrm{{$KeyFindingsItemValue->atpq_divid}}" action="javascript:void(0);" class="ansewertoaudit  gcspgetkeyfindings">
										<div class="row">
									    <input type="hidden" name="atpq_id" value="{{$KeyFindingsItemValue->atpq_id}}">
									    <input type="hidden" name="atpq_divid" value="{{$KeyFindingsItemValue->atpq_divid}}">
									    <input type="hidden" name="atpq_atp_id" value="{{$KeyFindingsItemValue->atpq_atp_id}}">
									    <input type="hidden" name="atpq_atm_id" value="{{$KeyFindingsItemValue->atpq_atm_id}}">
									    <input type="hidden" name="adm_id" value="{{$Audits->adm_id}}">
									    <input type="hidden" name="atpq_type" value="{{$KeyFindingsItemValue->atpq_type}}">
										<div class="col-sm-8"><h5><b>{{__('Corrective Actions')}} (0)</b></h5></div>
										<div class="col-sm-4 text-right"><button data-atpq_id="{{$KeyFindingsItemValue->atpq_id}}" type="button" class="btn btn-primary gcspaddactiontoaudit">{{__('Add new')}}</button></div>
										</div>
									</form>
								
							</div>
							</div>
							<?php } ?>	

							<div class="mt-2">
								<?php $atpq_type=$KeyFindingsItemValue->atpq_type;
								$AuditQuestionsValue=$KeyFindingsItemValue;
							 ?>
							{!! view('audits.auditkeyfindibngquestionoption',compact('AuditQuestionsValue','atpq_type','Auditor','AuditAnswerMaster','CheckBoxQuestionOption','GridViewOption')) !!}
							</div>

							<p class="mt-2"><b>{{__('Description of Key Finding')}}: </b>{{$KeyFindingsItemValue->ak_keyfinding}}</p>

						</div>
						
				<?php if(isset($AuditAnswerMaster[$KeyFindingsItemValue->atpq_id]) && $KeyFindingsItemValue->atpq_type==2 && $KeyFindingsItemValue->atpq_is_rules==1 && $KeyFindingsItemValue->atpq_is_multiple_choice!=1){?>
							<div class="gcspsubquestionwpr pl-3 pt-3 gcspsubquestionwpr{{$KeyFindingsItemValue->atpq_id}}">
								<?php foreach ($AuditAnswerMaster[$KeyFindingsItemValue->atpq_id] as $anskey => $ans_value) {
										if($ans_value->aam_answer){                
											 $answerdata=$ans_value->aam_answer;    
										}
								}        
								if(isset($AuditSubQuestionsArr[$answerdata])){
								$AuditSubQuestions=$AuditSubQuestionsArr[$answerdata];
										echo view('audits.auditssubqueform',compact('GridViewOption','AuditSubQuestions','CheckBoxQuestionOption','Audits','Auditor','AuditAnswerMaster','ActionsAdded'));
								}?>
							</div>
						<?php   }  
			 ?> 
			
					</div>    
				</div>  
				
			</div> 
			 @endforeach   
		</div>
		@endforeach
		@endif
			
		


		

	</div>

	</div> 
</div>  
<div class="modal fade" id="AuditActionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"></div>
@endsection 