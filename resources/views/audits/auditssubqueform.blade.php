@if(count($AuditSubQuestions))    
@php $subqno=1; @endphp   
@foreach($AuditSubQuestions as $AuditQuestionsValue)
<div class="col-sm-12 gcspquetionwpr gcspquetionwpr{{$AuditQuestionsValue->atpq_divid}}">
  <form enctype="multipart/form-data" method="post" id="mainqustionfrm{{$AuditQuestionsValue->atpq_divid}}" action="{{route('ansewertoaudit')}}" class="ansewertoaudit  gcspgetkeyfindings">
	<input type="hidden" name="atpq_id" value="{{$AuditQuestionsValue->atpq_id}}">
	<input type="hidden" name="atpq_divid" value="{{$AuditQuestionsValue->atpq_divid}}">
	<input type="hidden" name="atpq_atp_id" value="{{$AuditQuestionsValue->atpq_atp_id}}">
	<input type="hidden" name="atpq_atm_id" value="{{$AuditQuestionsValue->atpq_atm_id}}">
	<input type="hidden" name="adm_id" value="{{$Audits->adm_id}}">
	<input type="hidden" name="atpq_type" value="{{$AuditQuestionsValue->atpq_type}}">
	
	<div class="gcspquetioninner pt-0">
	  <div class="row">
		<div class="col-sm-10">
		  <p> @if($AuditQuestionsValue->atpq_is_mandatory==1) <span class="required p-0">*</span> @endif
			{{$AuditQuestionsValue->atpq_question}}</p>          
		  @if($AuditQuestionsValue->atpq_is_description==1 && $AuditQuestionsValue->atpq_description_text!='')
		  <p class="gcspquestiondesc"><b>{{__('Description')}}:</b> {{$AuditQuestionsValue->atpq_description_text}}</p>          
		  @endif
		</div>
		@if (!Request::is('audits/*/keyfindings') && !Request::is('audits/*/actionitems'))
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
		@endif    
	  </div>
	  @if (Request::is('audits/*/actionitems'))
	  
	  <?php if(isset($ActionsAdded[$AuditQuestionsValue->atpq_id])){?>
			  <div class="getactioneapperloop">
				<div class="row">
					<div class="col-sm-8"><h5><b>{{__('Corrective Actions')}} ({{count($ActionsAdded[$AuditQuestionsValue->atpq_id])}})</b></h5></div>
					<div class="col-sm-4 text-right"><button data-atpq_id="{{$AuditQuestionsValue->atpq_id}}" type="button" class="btn btn-primary gcspaddactiontoaudit">{{__('Add new')}}</button></div>
				</div>
			  </div>
				<?php
				  foreach ($ActionsAdded[$AuditQuestionsValue->atpq_id] as $key => $value) {?>
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
				<div class="row">
					<div class="col-sm-8"><h5><b>{{__('Corrective Actions')}} (0)</b></h5></div>
					<div class="col-sm-4 text-right"><button data-atpq_id="{{$AuditQuestionsValue->atpq_id}}" type="button" class="btn btn-primary gcspaddactiontoaudit">{{__('Add new')}}</button></div>
				</div>
			  </div>
			  <?php } ?>

	  @endif
	  <?php $atpq_type=$AuditQuestionsValue->atpq_type; ?>
	  @if (Request::is('audits/*/keyfindings') || Request::is('audits/*/actionitems')) 
	  {!! view('audits.auditkeyfindibngquestionoption',compact('AuditQuestionsValue','atpq_type','Auditor','AuditAnswerMaster','CheckBoxQuestionOption','GridViewOption','ActionsAdded')) !!}
	  @else
	  {!! view('audits.auditquestionoption',compact('AuditQuestionsValue','atpq_type','Auditor','AuditAnswerMaster','CheckBoxQuestionOption','GridViewOption')) !!}
	  @endif


	  @if (Request::is('audits/*/keyfindings') || Request::is('audits/*/actionitems')) 
		  <div class="gcspkeyfindinnotify keyfindings d-block">
			  <div class="gckeyfinfingwpr mt-1 gckeyfinfingwpr{{$AuditQuestionsValue->atpq_id}}" style="<?php echo (isset($KeyFinding[$AuditQuestionsValue->atpq_id]))?'display: block;':'' ?>">
				<div class="row">
					<div class="col-sm-12"><b>{{__('Description of Key Finding')}}: </b><?php if(isset($KeyFinding[$AuditQuestionsValue->atpq_id])){  echo $KeyFinding[$AuditQuestionsValue->atpq_id][0]->ak_keyfinding; } ?></div>                    
				</div>  
			  </div>  
		  </div>   
	  @else

	  <div class="gcspkeyfindinnotify 132">
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
		  @endif 

	</div>        
  </form>  
</div>
@endforeach    
@endif
