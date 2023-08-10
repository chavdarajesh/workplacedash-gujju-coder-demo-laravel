<div class="table-responsive">
    <table class="table  table-hover gcspaudittable" >
    <thead>
        <tr >
            <th width="20%">{{__('Audit title and description')}}</th>
            <th width="20%">{{__('Area')}}</th>
            <th width="10%">{{__('Score')}}</th>
            <th width="">{{__('Findings')}}</th>
            <th width="">{{__('Action')}}</th>
            <th width="">{{__('Frequency')}}</th>
            <th width="16%">{{__('Schedule')}}</th>
            <th width="10%">{{__('Status')}}</th>
            <th width="12%"></th>
        </tr>
    </thead>
    <tbody>
        @if(count($Audits))
        @foreach($Audits as $AuditsItem)
        <tr class="tr{{$AuditsItem->adm_id}}">
            <td><div class="gcspaudirrowtitle"><b>{{$AuditsItem->atm_audit_name}}</b><span class="d-block">{{__('Auditor')}}: {{$AuditsItem->auditor}}</span></div></td>
            <td><b>{{$AuditsItem->site_name}}</b><span class="d-block">{{__('Auditee')}}: {{$AuditsItem->auditee}}</span></td>            
            <td>
                @if($AuditsItem->adm_status!=1)    
                    {!! GetInspectionScore($AuditsItem->adm_id,$AuditsItem->adm_atm_id,1) !!}
                @else
                    -
                @endif  
            </td>
            <td>{{($AuditsItem->Findings)?$AuditsItem->Findings:'-'}}</td>
            <td>{{($AuditsItem->actions)?$AuditsItem->actions:'-'}}</td>
            <td>{{$AuditsItem->af_name}}</td>
            <td>
                <span class="d-block"><b>{{__('Start')}}: {{date('d M, Y',strtotime($AuditsItem->adm_start_from))}}</b></span>
                <span class="d-block">{{__('Ends')}}: {{date('d M, Y',strtotime($AuditsItem->adm_end_on))}}</span>
            </td>
            <td>
                @if($AuditsItem->adm_status==2)                    
                    <?php if(isset($GetTimeline[$AuditsItem->adm_id])){
                        if($GetTimeline[$AuditsItem->adm_id][0]->atl_type==2){
                             echo __('In progress');
                        }else{
                            echo '<span class="text-danger">'.__('Rejected').'</span><span class="text-secondary">';
                            echo date('d M, Y',strtotime($GetTimeline[$AuditsItem->adm_id][0]->timeline)) ;
                        }
                       
                    }?>
                @elseif($AuditsItem->adm_status==3)    
                    Overdue
                @elseif($AuditsItem->adm_status==4)    
                    <span class="text-success">{{__('Completed')}}</span><span class="text-secondary">
                    <?php if(isset($GetTimeline[$AuditsItem->adm_id])){
                       echo date('d M, Y',strtotime($GetTimeline[$AuditsItem->adm_id][0]->timeline)) ;
                    } ?>    
                     
                 </span>
                @elseif($AuditsItem->adm_status==5)    
                    <span class="text-success">{{__('Approved')}}</span><span class="text-secondary">
                    <?php if(isset($GetTimeline[$AuditsItem->adm_id])){
                       echo date('d M, Y',strtotime($GetTimeline[$AuditsItem->adm_id][0]->timeline)) ;
                    } ?>
                @else
                {{__('Pending')}}                    
                @endif    
            </td>
            <td align="right" class="atm_list">
                @if($AuditsItem->adm_status==1 && (date("Y-m-d") == $AuditsItem->adm_start_from))
                <a href="{{route('getauditsection',['adm_id'=>$AuditsItem->adm_id])}}" class="gcspauditstart">{{__('Start')}}</a>
                @endif
                @if($AuditsItem->adm_status==2)
                <a href="{{route('getauditsection',['adm_id'=>$AuditsItem->adm_id])}}" class="gcspauditstart">{{__('Continue')}}</a>
                @endif
                @if($AuditsItem->adm_status==1)
                <a href="javascript:void(0);" data-adm_id="{{$AuditsItem->adm_id}}" class="gcspauditedit pr-2"><i class="fa fa-edit"></i></a>
                <a href="javascript:void(0);" data-adm_id="{{$AuditsItem->adm_id}}" class="gcspauditdelete"><i class="fa fa-trash"></i></a></td>
                @endif

                @if($AuditsItem->adm_status==4 || $AuditsItem->adm_status==5)
                <a href="{{route('getreport',['adm_id'=>$AuditsItem->adm_id])}}" >{{__('View Summary')}}</a>                
                @endif
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="9"><center>{{__('No records found')}}</center></td>                        
        </tr>
        @endif
    </tbody>
</table>
</div>