@extends('layouts.dashboard') 
@section('content')
<div class="gcspfullpagewapper auditsreportview" >
<div class="permitsreport" >
	<div class="auditreportwpr">
		<div class="auditheader">
			<div class="org_logo">&nbsp;</div>
			<div class="org_logo_text">
				<h3>{{$Audits->atm_audit_name}}</h3>
				<h6>{{$Audits->site_name}}</h6>
				<p> {{__('Frequency')}}: {{$Audits->af_name}} </p>
			</div>            
		</div>
		<div class="auditno"><span class="auditid auditspan">{{__('Audit ID')}}: <span>{{$Audits->adm_srno}}</span></span><span class="auditstatussummary auditspan">{{__('Status')}}: <span>{{($Audits->adm_status==4)?__('Completed'):__('Approved')}}</span></span>
		</div>
		<div class="auditreportstable">
			<table cellpadding="0" cellspacing="0" border="0" class="auditreporttabledatails">
				<tbody>
					<tr>
						<td>
							<div class="audittopdata"><span>{{__('Audit Type')}}:</span>{{$Audits->category_name}}</div>
						</td>
						<td>
							<div class="audittopdata"><span>{{__('Auditor')}}:</span>{{$Audits->auditor}}</div>
						</td>
						<td>
							<div class="audittopdata"><span>{{__('Auditee')}}:</span> {{$Audits->auditee}} </div>
						</td>
						<td>
							<div class="audittopdata"><span>{{__('Search')}}: </span>{{date('d M, Y, D,h:i: a',strtotime($GetTimeline[0]->timeline))}}</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="audittopdata"><span>{{__('Scorecard')}}:</span>{!! GetInspectionScore($Audits->adm_id,$Audits->adm_atm_id) !!}</div>
						</td>
						<td>
							<div class="audittopdata"><span>{{__('No. of Key Findings')}}:</span>{{$Audits->Findings}} </div>
						</td>
						<td>
							<div class="audittopdata"><span>{{__('No. of Actions')}}:</span>{{$Audits->actions}} </div>
						</td>
						<td><?php $lastrevired= count($GetTimeline)-1;  ?>
							<div class="audittopdata"><span>{{__('Reviewed Date')}}:</span>{{date('d M, Y, D,h:i: a',strtotime($GetTimeline[$lastrevired]->timeline))}}</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="audtidatasecodtable audittwotable">
			@foreach($AuditSection as $AuditSectionItem)
			<?php  $atp_id=$AuditSectionItem->atp_id; ?>
			<div class="auditdesctbl dynamicformtable">
				<div class="thheaddiv">{{$AuditSectionItem->atp_name}}</div>
				@foreach($AuditQuestions[$atp_id] as $qno=> $AuditQuestionsItem)
				<div class="tdbodydiv">
					<div class="question_sno"> {{$qno+1}}. </div>
					<div class="question_right">
						<?php $atpq_type=$AuditQuestionsItem->atpq_type; ?>                        
						<div class="read_only">
							<div class="fidspanclass">{{$AuditQuestionsItem->atpq_question}}</div> 
							{!! view('audits.audit_repots_que_option',compact('AuditQuestionsItem','atpq_type','AuditAnswerMaster','CheckBoxQuestionOption','GridViewOption')) !!}
						</div>
						<?php if(isset($KeyFinding[$AuditQuestionsItem->atpq_id])){?>
						<div class="keyfinddiv"><span>{{__('Key Finding(s)')}}: </span>{{$KeyFinding[$AuditQuestionsItem->atpq_id][0]->ak_keyfinding}} </div>
						<?php } ?>
						{{view('audits.reportsrctions',compact('AuditQuestionsItem','Actions'))}}
					

					<?php if(isset($AuditAnswerMaster[$AuditQuestionsItem->atpq_id]) && $AuditQuestionsItem->atpq_type==2 && $AuditQuestionsItem->atpq_is_rules==1 && $AuditQuestionsItem->atpq_is_multiple_choice!=1){

							  foreach ($AuditAnswerMaster[$AuditQuestionsItem->atpq_id] as $anskey => $ans_value) {
									if($ans_value->aam_answer){                
									 $answerdata=$ans_value->aam_answer;    
									}
								}        
								if(isset($AuditSubQuestionsArr[$answerdata])){
								$AuditSubQuestions=$AuditSubQuestionsArr[$answerdata];?>



								@if(count($AuditSubQuestions))    
								@foreach($AuditSubQuestions as $qno=> $AuditQuestionsItem)
								<div class="tdbodydiv tdbodydivsub">
									<div class="question_sno"> {{$qno+1}}. </div>
									<div class="question_right">
										<?php $atpq_type=$AuditQuestionsItem->atpq_type; ?>                        
										<div class="read_only">
											<div class="fidspanclass">{{$AuditQuestionsItem->atpq_question}}</div> 
											{!! view('audits.audit_repots_que_option',compact('AuditQuestionsItem','atpq_type','AuditAnswerMaster','CheckBoxQuestionOption','GridViewOption')) !!}
										</div>
										<?php if(isset($KeyFinding[$AuditQuestionsItem->atpq_id])){?>
										<div class="keyfinddiv"><span>{{__('Key Finding(s)')}}: </span>{{$KeyFinding[$AuditQuestionsItem->atpq_id][0]->ak_keyfinding}} </div>
										<?php } ?>
										{{view('audits.reportsrctions',compact('AuditQuestionsItem','Actions'))}}
									</div>
								</div>
								@endforeach
								@endif




								  
								<?php }
							  }
					?>
					</div>
				</div>
				@endforeach
			</div>
			@endforeach

			<table cellpadding="0" cellspacing="0" border="0" class="normaltable isseauthtable">
				<thead>
					<tr>
						<th>{{__('ISSUING AUTHORIZERS')}}</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<ul class="issueauthul">
								<li>
									<div>
										<div class="audittopdata"><span class="reviewer-wrapper">{{$Audits->auditor}}</span>
											<span>{{$Audits->r_name}}</span></div>
									</div>
									<div class="audittopdata">
										<div class="wornameinner"></div>                                        
									</div>
								</li>
							</ul>
						</td>
					</tr>
				</tbody>
			</table>
			@if($Audits->adm_status!=5 && ($cuser->can('Permit Close') || $cuser->can('Permit Reject')))            
				<div class="auditsumicons auditcomrejbut">
					@if($cuser->can('Permit Reject'))            
					<a href="javascript:void(0);" data-toggle="modal" data-target="#RejectConfirmModal" class="btn btn-danger"> {{__('Reject')}} </a> 
					@endif
					@if($cuser->can('Permit Close'))            
					<a href="javascript:void(0);" data-toggle="modal" data-target="#ApproveConfirmModal" class="btn btn-success"> {{__('Approve')}} </a>
					@endif
				</div>
			@endif                
			<div class="audicompletetimeline">
				<h4>{{__('Timeline')}}:</h4>
				<ul>
					@foreach($GetTimeline as $GetTimelineValue)
					<li>
						<span>
						@if($GetTimelineValue->atl_type==1){{__('Started')}} @endif
						@if($GetTimelineValue->atl_type==2){{__('Resumed')}} @endif
						@if($GetTimelineValue->atl_type==3){{__('Rejected')}} @endif
						@if($GetTimelineValue->atl_type==4){{__('Completed')}} @endif
						@if($GetTimelineValue->atl_type==5){{__('Approved')}} @endif
						by
						</span> {{$GetTimelineValue->name}}
						<br> {{date('d M, Y, D, h:i a',strtotime($GetTimelineValue->timeline))}}
						@if($GetTimelineValue->atl_reason)  
						<p><b>Reason:</b> {{$GetTimelineValue->atl_reason}}</p>
						@endif  
					</li>
					@endforeach                    
				</ul>
			</div>
		</div>
	</div>    
</div>
</div>
@if($Audits->adm_status!=5)            
<div id="RejectConfirmModal" class="modal fade"  aria-modal="true">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">            
			<div class="modal-body text-center pb-0">                
				<p><b>{{__('Do you really want to reject this audit?')}}</b></p>
			</div>
			<div class="modal-footer border-0 m-auto">
				<button type="button" data-dismiss="modal" class="btn btn-primary">{{__('No')}}</button>                
				<button type="button" data-toggle="modal" data-dismiss="modal" data-target="#RejectResoneModal" class="btn btn-primary">{{__('Yes')}}</button>
			</div>
		</div>
	</div>
</div>
<div id="RejectResoneModal" class="modal fade"  aria-modal="true">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
		<form action="{{route('auditchangetoreject')}}" method="post">
			@csrf
			<input type="hidden" name="adm_id" value="{{$Audits->adm_id}}">
			<div class="modal-body pb-0">                
				<p><b>{{__('Please enter the reason')}}</b></p>
				<div class="form">
					<textarea name="atl_reason" class="form-control"></textarea>
				</div>    
			</div>
			<div class="modal-footer border-0 m-auto">
				<button type="button" data-dismiss="modal" class="btn btn-primary">{{__('Cancel')}}</button>                
				<button type="submit" class="btn btn-primary">{{__('Yes')}}</button>
			</div>
		</form>    
		</div>
	</div>
</div>
<div id="ApproveConfirmModal" class="modal fade"  aria-modal="true">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">            
			<div class="modal-body text-center pb-0">                
				<p><b>{{__('Do you really want to approve this audit?')}}</b></p>
			</div>
			<div class="modal-footer border-0 m-auto">
				<button type="button" data-dismiss="modal" class="btn btn-primary">{{__('No')}}</button>                
				<button type="button" data-toggle="modal" data-dismiss="modal" data-target="#ApproveResoneModal" class="btn btn-primary">{{__('Yes')}}</button>
			</div>
		</div>
	</div>
</div>
<div id="ApproveResoneModal" class="modal fade"  aria-modal="true">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
		<form action="{{route('auditchangetoapproved')}}" method="post">
			@csrf
			<input type="hidden" name="adm_id" value="{{$Audits->adm_id}}">
			<div class="modal-body pb-0">                
				<p><b>{{__('Por favor ingrese los comentarios')}}</b></p>
				<div class="form">
					<textarea name="atl_reason" class="form-control"></textarea>
				</div>    
			</div>
			<div class="modal-footer border-0 m-auto">
				<button type="button" data-dismiss="modal" class="btn btn-primary">{{__('Cancel')}}</button>                
				<button type="submit" class="btn btn-primary">{{__('Yes')}}</button>
			</div>
		</form>    
		</div>
	</div>
</div>
@endif
@endsection 