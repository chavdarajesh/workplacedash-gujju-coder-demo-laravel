<?php if(isset($Actions[$AuditQuestionsItem->atpq_id])){?>
<div class="auditactionlist">
  <h4>{{__('Actions')}}:</h4>
  <table cellpadding="0" cellspacing="0" border="0" class="auditactiontable">
    <thead>
      <tr>
        <th width="30%">{{__('Attachments & Descriptions')}}</th>
        <th width="15%">{{__('Control')}} & {{__('Details')}}</th>
        <th width="15%">{{__('Responsibility')}}</th>
        <th width="15%">{{__('Due Date')}}</th>
        <th width="25%">{{__('Status')}} & {{__('Status')}}</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($Actions[$AuditQuestionsItem->atpq_id] as $key => $AuditActionsItem) {
        $actions_attachement_rel=GetActionAttachement($AuditActionsItem->am_id);
      ?>        
      <tr>
        <td><p class="auditacttext">{{$AuditActionsItem->am_description}}</p>
          @if($actions_attachement_rel)
          <div class="auditactimages">
            <?php 
            foreach ($actions_attachement_rel as $key => $value) {                    
                $attachamentsrc=url('storage/'.$value->attachament);
                $path_info = pathinfo($attachamentsrc);                    
                if($path_info['extension']=='pdf'){$attachamentsrc=asset('images/pdf.png');}
                if($path_info['extension']=='docx'){$attachamentsrc=asset('images/doc.png');}
                if($path_info['extension']=='xlsx'){$attachamentsrc=asset('images/excel.png');}
                if($path_info['extension']=='bin'){$attachamentsrc=asset('images/ppt.png');}
                if($path_info['extension']=='pptx'){$attachamentsrc=asset('images/ppt.png');}
            ?>
            <div class="attachactimg">                                  
                  <div class="tooltip-target b3 locat_table">
                    <div class="attach_preview doc_preview"><a title="{{$value->attachement_name}}" href="{{url('storage/'.$value->attachament)}}" target="_blank"><img src="{{$attachamentsrc}}" alt="Attachments" class="img-fluid"></a></div>
                  </div>                                                                      
            </div>
          <?php } ?>
            

          </div>
        @endif  
        </td>
        <td>{{$AuditActionsItem->cm_name}} </td>
        <td>{{GetActionResponsibility($AuditActionsItem->am_id)}}</td>
        <td>{{date('d M, Y',strtotime($AuditActionsItem->am_due_date))}}</td>
        <td><b>{{GetActionStatus($AuditActionsItem->am_status)}}</b>
          <p class="auditacttext">{{$AuditActionsItem->am_remark}}</p>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<?php } ?>