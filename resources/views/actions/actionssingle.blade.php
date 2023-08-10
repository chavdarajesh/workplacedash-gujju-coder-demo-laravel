<?php $mt=$ActionsOpen->am_module_type;
      $description=$srno=$category_name=$site_name=$GetActionResponsibility=$Whendatetime=$GetRiskLevel=$shifts=$colorborder='';              
      if($mt==1){
          $description=$ActionsOpen->ob_description;
          $srno=$ActionsOpen->ob_srno;
          $category_name=$ActionsOpen->category_name;
          $category_namePopup='<p><b>'.__('Near Miss Type').':</b> '.$ActionsOpen->category_name.'</p>';
          $site_name=$ActionsOpen->site_name;
          $GetActionResponsibility=GetActionResponsibility($ActionsOpen->am_id);  
          $Whendatetime=$ActionsOpen->obdatetime;
          $GetRiskLevel=$ActionsOpen->riskpotentiallevel;
          $popuptitle=__('Near Miss Details').":";
          $colorborder='riskpotentiallevel'.$ActionsOpen->riskpotentiallevel;
      }
      if($mt==2){
          $description=$ActionsOpen->im_description;
          $srno=$ActionsOpen->im_srno;                  
          $category_name=$ActionsOpen->im_category_name;
          $category_namePopup='<p><b>'.__('Incident Type').':</b> '.$ActionsOpen->im_category_name.'</p>';
          $site_name=$ActionsOpen->im_site_name;
          $GetActionResponsibility=GetActionResponsibility($ActionsOpen->am_id);  
          $Whendatetime=$ActionsOpen->im_datetime;
          $shifts=$ActionsOpen->sm_name;
          $popuptitle=__('Incident Details').":";
          $GetRiskLevel=$ActionsOpen->rating_text;
          $colorborder='colorborder'.$ActionsOpen->rating_type;
      }
      if($mt==4){
          $description=$ActionsOpen->im_description;
          $srno=$ActionsOpen->adm_srno;                  
          $category_name=$ActionsOpen->audit_category_name;
          $category_namePopup='<p><b>'.__('Audit Type').':</b> '.$ActionsOpen->audit_category_name.'</p>';
          $site_name=$ActionsOpen->auditsitename;    
          $GetActionResponsibility=GetActionResponsibility($ActionsOpen->am_id);                
          $Whendatetime=$ActionsOpen->adm_start_from;                  
          $popuptitle=__('Audit Details').":";                  
          $colorborder='colorborder'.$ActionsOpen->adm_status;
      }

            ?>            
            <div class="gcspaction">
                <a href="{{ route('actionsedit',['id'=>$ActionsOpen->am_id]) }}" class="ml-1 actionsedit"><i class="fa fa-edit"></i></a>
                <a href="{{ route('actionsdelete',['id'=>$ActionsOpen->am_id]) }}" class="ml-1 actionsdelete"><i class="fa fa-trash"></i></a>
                <a href="javascript:void(0);" data-toggle="modal" data-target="#myModal{{$ActionsOpen->am_id}}" class="ml-1"><i class="fa fa-eye"></i></a>
              </div>

              <div id="myModal{{$ActionsOpen->am_id}}" class="modal fade" role="dialog">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">{{$popuptitle}} {{$srno}}</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>                      
                    </div>
                    <div class="modal-body">
                      <p><b>{{__('Description')}}:</b> {{$description}}</p>
                      {!!$category_namePopup!!}
                      <p><b>{{__('Date & Time')}}:</b> {{date('d M, Y D h:ia',strtotime($Whendatetime))}}</p>
                      @if($GetRiskLevel)
                      <p><b>{{__('Risk Potential Level')}}:</b> {{GetRiskLevel($GetRiskLevel)}}</p>
                      @endif

                      @if($mt==2)
                        @if($ActionsOpen->rating)
                        <p><b>{{__('Rating')}}:</b> {{$ActionsOpen->rating}}</p>
                        @endif
                        @if($ActionsOpen->severity)
                        <p><b>{{__('Severity')}}:</b> {{$ActionsOpen->severity}}</p>
                        @endif
                        @if($ActionsOpen->likelihood)
                        <p><b>{{__('Likelihood')}}:</b> {{$ActionsOpen->likelihood}}</p>
                        @endif
                      @endif

                      @if($shifts)
                      <p><b>{{__('Shift')}}:</b> {{$shifts}}</p>
                      @endif
                    </div>
                    
                  </div>
                </div>
              </div>

              <div class="card {{$colorborder}}">
                <div class="card-body gcspactiondetails" data-href="{{ route('actiondetails',['id'=>$ActionsOpen->am_id]) }}" >
                  <span class="d-flex gc-observsntitle">{{$category_name}} - {{$srno}}</span>
                  <div class="gc-observsntitle-nametag float-none">
                    <span class="d-flex">{{$site_name}}</span>
                  </div>
                  <span class="d-flex">{{substr($ActionsOpen->am_description,0,57)}}...</span>
                  <div class="gc-observsntitle-nametag float-none">
                      <span class="d-flex">{{__('By')}}:{{$ActionsOpen->name}}</span>
                      <span class="d-flex">{{__('Responsibility')}}:{{$GetActionResponsibility}}</span>
                  </div> 
                  

                  <div class="gc-observsntitle-userdtl clearfix">    
                    <div class="gc-observsntitle-subtag float-left colorgray">
                      <label for="tag">{{__('Due Date')}}: {{date('d M, Y',strtotime($ActionsOpen->am_due_date))}}</label>
                    </div> 
                    <div class="gc-observsntitle-subtag">
                      <label for="tag">{{GetActionStatus($ActionsOpen->am_status)}}</label>
                    </div> 
                  </div>      
                </div>
              </div>
            