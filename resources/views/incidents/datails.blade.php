<div class="gc-form-title">
 <h5>{{__('Incident Investigation Details')}}</h5>
</div>
<div class="row">
    <div class="col-sm-8">
        <div class="gcobseritem">          
            <div class="card colorborder{{$Incident->rating_type}}" >
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="spstatus ">
                                <p>{{$Incident->rating}} <span class="colorrating{{$Incident->rating_type}}">{{__($Incident->rating_text)}}</span></p>
                            </div>
                        </div>    
                        <div class="col-sm-10">
                         <span class="d-flex gc-observsntitle">{{$Incident->im_srno}} ON 31 Oct, 2020 Sat 11:47am</span>                    
                         <div class="gc-incident-carddtl1">                                                                    
                          <p class="card-text">{{substr($Incident->im_description,0,100)}}...</p>
                      </div>

                      <div class="gc-observsntitle-userdtl clearfix mt-0">    
                        <div class="gc-observsntitle-nametag">
                            <span class="d-flex">{{__('Area / Sub-Area')}}:&nbsp; <b> {{$Incident->site_name}}</b></span>
                            <span class="d-flex">{{__('Reported by')}}:&nbsp;<b> {{$Incident->name}}&nbsp;</b> {{__('On')}} {{date('d M, Y D h:ia',strtotime($Incident->created_at))}}</span>
                            <span class="d-flex">{{__('Severity')}}:&nbsp; <b> {{$Incident->severity}}</b></span>
                            <span class="d-flex">{{__('Likelihood')}}:&nbsp; <b> {{$Incident->likelihood}}</b></span>

                        </div> 

                    </div>   
                </div> 
            </div>       
        </div>
    </div>
</div>
</div>
<div class="col-sm-4"><h5>{{__('Investigation Team')}} ({{count($InvestigationTeam)}} {{__('member')}})</h5>
    @if($InvestigationTeam)
    <table class="table table-borderless">
        <?php foreach ($InvestigationTeam as $key => $InvestigationTeamvalue) {?>                    
        <tr>
            <td width="10"><i style="font-size: 25px;" class="fa fa-user-circle gc-userlogin" aria-hidden="true"></i></td>
            <td>{{$InvestigationTeamvalue->name}}</td>
        </tr>
        <?php } ?>
    </table>
    @endif
</div>
</div>


<!-- Step start here -->


<div class="ismdetail-list">
    <div class="row">
   
    <ul class="progress-tracker progress-tracker--text progress-tracker--right">
          <li onclick="location.href='<?php echo  route('incidentsdetails',array('id'=>$Incident->im_id,'step'=>1)); ?>';" class="progress-step  {{($step>1)?' is-complete ':''}}  {{($step==1)?' not-complete active':''}}">
            <div class="progress-marker"></div>
            <div class="progress-text">
                {{__('Incident Report')}}
            </div>
          </li>

          <li onclick="location.href='<?php echo  route('incidentsdetails',array('id'=>$Incident->im_id,'step'=>2)); ?>';" class="progress-step  progressbox {{($step>2)?' is-complete ':''}} {{($step==2)?' not-complete active':''}}">
            <div class="progress-marker"></div>
            <div class="progress-text">
                {{__('Investigation Team')}}
            </div>
          </li>

          <li onclick="location.href='<?php echo  route('incidentsdetails',array('id'=>$Incident->im_id,'step'=>3)); ?>';" class="progress-step progressbox {{($step>3)?' is-complete ':''}} {{($step==3)?' not-complete active':''}}">
            <div class="progress-marker"></div>
            <div class="progress-text">
                {{__('Root Cause Analysis')}}
            </div>
          </li>

          <li onclick="location.href='<?php echo  route('incidentsdetails',array('id'=>$Incident->im_id,'step'=>4)); ?>';" class="progress-step progressbox {{($step>4)?' is-complete ':''}} {{($step==4 && $Incident->im_lastsubmitedstep!=4)?' not-complete active':''}} {{($step==4 && $Incident->im_lastsubmitedstep==4)?' is-complete ':''}}">
            <div class="progress-marker"></div>
            <div class="progress-text">
                {{__('Recommended Actions')}}
            </div>
          </li>

           <li onclick="location.href='<?php echo  route('incidentsdetails',array('id'=>$Incident->im_id,'step'=>4)); ?>';" class="progress-step   progressbox {{($step>=4 && $Incident->im_lastsubmitedstep==4 && $Incident->im_actionapproved!='')?' is-complete ':'ismlock'}} {{($step==4 && $Incident->im_actionapproved=='' && $Incident->im_lastsubmitedstep==4)?' not-complete active':''}}  {{($step==5 && $Incident->im_actionapproved==1 && $Incident->im_lastsubmitedstep==5)?' is-complete active':''}}">
            <div class="progress-marker"></div>
               <div class="progress-text">
             &nbsp;
            </div>
          </li>

          <li onclick="location.href='<?php echo  route('incidentsdetails',array('id'=>$Incident->im_id,'step'=>5)); ?>';" class="progress-step progressbox {{($step>5)?' is-complete ':''}} {{($step==5)?' not-complete active':''}}">
            <div class="progress-marker"></div>
            <div class="progress-text">
                {{__('Review and Closure')}}
            </div>
          </li>
        </ul>
    </div>    
</div>