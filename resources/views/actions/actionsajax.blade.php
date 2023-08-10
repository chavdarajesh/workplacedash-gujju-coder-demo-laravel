
          <div class="row">
            @if($ActionsOpen)
            @foreach($ActionsOpen as $ActionsOpen_item)
            <?php $mt=$ActionsOpen_item->am_module_type;
              $description=$srno=$category_name=$site_name=$GetActionResponsibility=$Whendatetime=$GetRiskLevel=$shifts=$colorborder='';              
              if($mt==1){
                  $description=$ActionsOpen_item->ob_description;
                  $srno=$ActionsOpen_item->ob_srno;
                  $category_name=$ActionsOpen_item->category_name;
                  $category_namePopup='<p><b>'.__('Near Miss Type').':</b> '.$ActionsOpen_item->category_name.'</p>';
                  $site_name=$ActionsOpen_item->site_name;
                  $GetActionResponsibility=GetActionResponsibility($ActionsOpen_item->am_id);  
                  $Whendatetime=$ActionsOpen_item->obdatetime;
                  $GetRiskLevel=$ActionsOpen_item->riskpotentiallevel;
                  $popuptitle=__('Near Miss Details').":";
                  $colorborder='riskpotentiallevel'.$ActionsOpen_item->riskpotentiallevel;
              }
              if($mt==2){
                  $description=$ActionsOpen_item->im_description;
                  $srno=$ActionsOpen_item->im_srno;                  
                  $category_name=$ActionsOpen_item->im_category_name;
                  $category_namePopup='<p><b>'.__('Incident Type').':</b> '.$ActionsOpen_item->im_category_name.'</p>';
                  $site_name=$ActionsOpen_item->im_site_name;
                  $GetActionResponsibility=GetActionResponsibility($ActionsOpen_item->am_id);  
                  $Whendatetime=$ActionsOpen_item->im_datetime;
                  $shifts=$ActionsOpen_item->sm_name;
                  $popuptitle=__('Incident Details').":";
                  $GetRiskLevel=$ActionsOpen_item->rating_text;
                  $colorborder='colorborder'.$ActionsOpen_item->rating_type;
              }

              if($mt==4){
                  $description=$ActionsOpen_item->im_description;
                  $srno=$ActionsOpen_item->adm_srno;                  
                  $category_name=$ActionsOpen_item->audit_category_name;
                  $category_namePopup='<p><b>'.__('Audit Type').':</b> '.$ActionsOpen_item->audit_category_name.'</p>';
                  $site_name=$ActionsOpen_item->auditsitename;    
                  $GetActionResponsibility=GetActionResponsibility($ActionsOpen_item->am_id);                
                  $Whendatetime=$ActionsOpen_item->adm_start_from;                  
                  $popuptitle=__('Audit Details').":";                  
                  $colorborder='colorborder'.$ActionsOpen_item->adm_status;
              }

            ?>
            <div class="col-md-6 mb-4 gcobseritem gcactionitem{{$ActionsOpen_item->am_id}}">
            <div class="gcspaction">
                <a href="{{ route('actionsedit',['id'=>$ActionsOpen_item->am_id]) }}" class="ml-1 actionsedit"><i class="fa fa-edit"></i></a>
                <a href="{{ route('actionsdelete',['id'=>$ActionsOpen_item->am_id]) }}" class="ml-1 actionsdelete"><i class="fa fa-trash"></i></a>
                <a href="javascript:void(0);" data-toggle="modal" data-target="#myModal{{$ActionsOpen_item->am_id}}" class="ml-1"><i class="fa fa-eye"></i></a>
              </div>

              <div id="myModal{{$ActionsOpen_item->am_id}}" class="modal fade" role="dialog">
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
                        @if($ActionsOpen_item->rating)
                        <p><b>{{__('Rating')}}:</b> {{$ActionsOpen_item->rating}}</p>
                        @endif
                        @if($ActionsOpen_item->severity)
                        <p><b>{{__('Severity')}}:</b> {{$ActionsOpen_item->severity}}</p>
                        @endif
                        @if($ActionsOpen_item->likelihood)
                        <p><b>{{__('Likelihood')}}:</b> {{$ActionsOpen_item->likelihood}}</p>
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
                <div class="card-body gcspactiondetails" data-href="{{ route('actiondetails',['id'=>$ActionsOpen_item->am_id]) }}" >
                  <span class="d-flex gc-observsntitle">{{$category_name}} - {{$srno}}</span>
                  <div class="gc-observsntitle-nametag float-none">
                    <span class="d-flex">{{$site_name}}</span>
                  </div>
                  <span class="d-flex">{{substr($ActionsOpen_item->am_description,0,57)}}...</span>
                  <div class="gc-observsntitle-nametag float-none">
                      <span class="d-flex">{{__('By')}}:{{$ActionsOpen_item->name}}</span>
                      <span class="d-flex">{{__('Responsibility')}}:{{$GetActionResponsibility}}</span>
                  </div> 
                  

                  <div class="gc-observsntitle-userdtl clearfix">    
                    <div class="gc-observsntitle-subtag float-left colorgray">
                      <label for="tag">{{__('Due Date')}}: {{date('d M, Y',strtotime($ActionsOpen_item->am_due_date))}}</label>
                    </div> 
                    <div class="gc-observsntitle-subtag">
                      <label for="tag">{{GetActionStatus($ActionsOpen_item->am_status)}}</label>
                    </div> 
                  </div>      
                </div>
              </div>
            </div>
            @endforeach
            @endif

          </div>
   