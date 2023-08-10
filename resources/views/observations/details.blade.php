<div class="gc-form-title rightpentitleborder">
      <h5>{{__('Near Miss Details')}}</h5>
      <div class="obstitleright">
         @if((($cuser->hasRole('Super Admin') || $cuser->id==$Observation->created_by)))
         @if($Observation->status==1)
        @if((($cuser->can('Observations Edit'))))                   
        <a href="{{ route('observationedit',['id'=>$Observation->ob_id]) }}" class="editobs observationedit">{{__('Edit')}}</a>
        @endif
         @endif
        @endif
        <span class="backto-home">
          @if($cuser->is_admin!=6)            
          <a class="observationscreate" href="{{route('observationscreate')}}"> × </a>
          @else
          <a class="observationscreatehide" href="javascript:void(0);"> × </a>
          @endif
        </span></div>
  </div>

  <div class="obsid_rating"><div class="obsidnum">{{__('ID')}}: {{$Observation->ob_srno}}</div><div class="ratingdiv colorrating{{$Observation->riskpotentiallevel}}"><span class="ratespan "> {{GetRiskLevel($Observation->riskpotentiallevel)}} </span></div></div>


  <div class="rightforms">
    <div class="form-group">
      <label>{{__('Select Near Miss Type')}}</label>
      <div> {{$Observation->category_name}} </div>
    </div>
    <div class="form-group">
      <label>{{__('Location / Date & Time')}}</label>
      <div class="obslocation"><i class="fas fa-map-marker-alt"></i> {{($Observation->site_name)?$Observation->site_name:$Observation->ob_describethelocation}}</div>
      <div class="obstimefield"><i class="far fa-clock"></i> {{date('d M, Y D h:ia',strtotime($Observation->obdatetime))}}</div>
    </div>
    <div class="form-group">
      <label>{{__('Description on Near Miss')}}</label>
      <div>{{ $Observation->description }}</div>
    </div>
    <?php /*
    <div class="form-group">
      <?php 
            if($observations_attachement_rel){                
                foreach ($observations_attachement_rel as $key => $value) {                    
                    $attachamentsrc=url('storage/'.$value->attachament);
                    $path_info = pathinfo($attachamentsrc);                    
                    if($path_info['extension']=='pdf'){$attachamentsrc=asset('images/pdf.png');}
                    if($path_info['extension']=='docx'){$attachamentsrc=asset('images/doc.png');}
                    if($path_info['extension']=='xlsx'){$attachamentsrc=asset('images/excel.png');}
                    if($path_info['extension']=='bin'){$attachamentsrc=asset('images/ppt.png');}
                    if($path_info['extension']=='pptx'){$attachamentsrc=asset('images/ppt.png');}
                    ?>
                    <span class="pip pip{{$value->oar_id}}"><a title="{{$value->attachement_name}}" href="{{url('storage/'.$value->attachament)}}" target="_blank"><img alt="{{$value->attachement_name}}" class="imageThumb" src="{{$attachamentsrc}}" ></a></span>
            <?php }
                
            }
            ?>
    </div> 
    */?>
      
    @if($Observation->listing_type!=1)
    <div class="form-group reportbytext"><span>{{__('Reported by')}}:</span><span>{{($Observation->ob_fullname)?$Observation->ob_fullname:$Observation->name}} (ID: {{($Observation->ob_empid)?$Observation->ob_empid:$Observation->empid}}) On {{date('d M, Y D h:ia',strtotime($Observation->created_at))}}</span></div>
    @else
    <div class="form-group reportbytext"><span>{{__('Reported on')}}:</span><span>{{date('d M, Y D h:ia',strtotime($Observation->created_at))}}</span></div>
    @endif
  </div>
<?php if($Observation->action_required==1){ ?>
  <div class="actionslists">
    <div class="actionsec">
        <div class="acttitle"><h4 class="formtitle"> {{__('Actions')}} <span>({{count($Actions)}})</span></h4></div>
        <div class="actpopup"><a class="gcspaddaction" href="javascript:void(0);"><span>+</span> {{__('Add Action')}}</a></div>
    </div>

    <div class="actlisting">
      @if(count($Actions))
      <ul>
         @foreach($Actions as $ActionsOpen_item)
        <li>
            <h5>{{substr($ActionsOpen_item->am_description,0,70)}}</h5>
            <p>Control: {{$ActionsOpen_item->cm_name}}<br><span> Responsibility: {{GetActionResponsibility($ActionsOpen_item->am_id)}} </span><br><span> {{__('Due Date')}}: {{date('d M, Y',strtotime($ActionsOpen_item->am_due_date))}} | <span class="actlabel overdue"> {{GetActionStatus($ActionsOpen_item->am_status)}}</span></span></p>

            <div class="reportaction">
              <div class="repodtactimg">
              <img src="{{asset('images/PPE.png')}}" alt="">
              </div>
              <div class="repodtactext"><span>{{$ActionsOpen_item->name}}</span><span>{{date('d M, Y D h:ia',strtotime($ActionsOpen_item->created_at))}}</span></div>
           </div> 
           @if((($cuser->hasRole('Super Admin') || $cuser->id==$Observation->created_by)))
           <div class="gcspaction">
              <a href="{{ route('actionsedit',['id'=>$ActionsOpen_item->am_id]) }}" class="ml-1 actionsedit"><i class="fa fa-edit"></i></a>
              <a href="{{ route('actionsdelete',['id'=>$ActionsOpen_item->am_id]) }}"  data-type="details" data-parentid="{{$ActionsOpen_item->am_parent_id}}"  class="ml-1 actionsdelete"><i class="fa fa-trash"></i></a>
           </div>  
           @endif
        </li>
        @endforeach
      </ul>
      @endif
      <form id="observationsstoreaction" action="{{route('observationsstoreaction')}}" method="post">
        <input type="hidden" name="ob_id" value="{{$Observation->ob_id}}">
        <input type="hidden" name="site_id" value="{{$Observation->site_id}}">
      <div class="actionhtmlbefore"></div>
      <input type="submit" class="btn btn-primary observationsstoreaction" value="Save" name="Save">
      </form>
    </div>

 </div>
<?php } ?>
@if($Observation->status==0)
<div class="rightforms">
<div class="form-group">
      <label>{{__('Closing Comments')}}</label>
      <div>{{ $Observation->ob_closing_comments }}</div>
</div>
</div>
@endif