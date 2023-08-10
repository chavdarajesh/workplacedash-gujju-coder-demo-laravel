<div class="gc-form-title">
    <h5>{{__('Edit an Near Miss')}} <a class="float-right observationscreate" href="{{route('observationscreate')}}"><i class="fa fa-times"></i></a></h5>
</div>
<form action="{{route('observationupdate')}}" id="observationupdate" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="ob_id" value="{{$Observation->ob_id}}">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Near Miss Serial Number')}} : {{$Observation->ob_srno}}</label>
            </div>    
        </div>    
    </div>    
    <div class="row">
        <div class="col-md-12">
            <div class="form-group gcsptreeviewwapepe ">
                <label for="exampleInputEmail1">{{__('Select Near Miss Type')}}<span class="required">*</span></label>
                <select  name="oc_id" class="oc_id2 classoc_id"  >
                {!! GetCatDropDown(1,$Observation->oc_id) !!}                                           
                </select>
                <span class="invalid-feedback classoc_idmsg" role="alert"><strong>{{__('The Near Miss Type field is required.')}}</strong></span>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Describe your near miss')}}<span class="required">*</span></label>
                <textarea name="description"  class="form-control classdescription">{{ $Observation->description }}</textarea>
                <span class="invalid-feedback" role="alert"><strong>{{__('Description field is required.')}}</strong></span>
            </div>
        </div>
  </div>  <!--first row over-->

<div class="row">
    <div class="col-md-12">
        <div class="form-group gcsptreeviewwapepe classsite_id">
            <label for="exampleInputEmail1">{{__('Where? name the location, area, site')}}...<span class="required">*</span></label>
            <select  class="site_id2 gcspobservationsitelist" name="site_id">
                {!! GetSiteDropDown(null,$Observation->site_id) !!}
                <option @if($Observation->site_id==0) selected @endif value="0">{{__('Unsure / do not know')}}</option>
            </select>            
        </div>
        <span class="invalid-feedback  mt-n2 mb-1" role="alert"><strong>{{__('Select Area field is required.')}}</strong></span>
        <div class="form-check mb-3">
                <input class="form-check-input gcspobservationsitelist" {{($Observation->ob_describethelocation)?'checked':''}} type="checkbox" name="ob_describethelocation_check" id="exampleRadios11" value="1"  />
                <label class="form-check-label" for="exampleRadios1">
                {{__('Unsure / do not know')}}
                </label>
            </div>
        <div class="form-group {{($Observation->ob_describethelocation)?'':'gcsphidediv'}} gcspobservationsite">
                <input type="text" value="{{ $Observation->ob_describethelocation }}" name="ob_describethelocation" placeholder="Describe the location"  class="form-control"  />
        </div>
    </div>
     <div class="col-md-12">    
        <div class="form-group">
            <label for="exampleInputEmail1">{{__('When? select date and time')}}<span class="required">*</span></label>
            <input type="text" value="{{ date('m/d/Y, h:i a',strtotime($Observation->obdatetime)) }}" name="obdatetime" placeholder=""  class="dateclass  form-control classobdatetime gcspdatetimepicker"  />
            <span class="invalid-feedback" role="alert"><strong>{{__('Date and Time field is required.')}}</strong></span>
        </div>        
    </div>    
</div>

<div class="row">
    @if($cuser->hasRole('Super Admin') || $cuser->can('Observations Risk potential'))
    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1">{{__('Select risk potential level')}}<span class="required">*</span></label><br />
            <div class="btn-group btn-group-toggle classriskpotentiallevel" data-toggle="buttons">
                <label class="btn btn-secondary minorbg gc-formbtn <?php echo ($Observation->riskpotentiallevel==1)?'active':''; ?>"> <input type="radio" value="1" <?php echo ($Observation->riskpotentiallevel==1)?'checked':''; ?> name="riskpotentiallevel" id="option1"   /> {{__('Minor')}} </label>
                <label class="btn btn-secondary seriousbg gc-formbtn <?php echo ($Observation->riskpotentiallevel==2)?'active':''; ?>"> <input <?php echo ($Observation->riskpotentiallevel==2)?'checked':''; ?> value="2" type="radio" name="riskpotentiallevel" id="option2"  /> {{__('Serious')}} </label>
                <label class="btn btn-secondary fatalbg gc-formbtn <?php echo ($Observation->riskpotentiallevel==3)?'active':''; ?>"> <input <?php echo ($Observation->riskpotentiallevel==3)?'checked':''; ?> value="3" type="radio" name="riskpotentiallevel" id="option3"  /> {{__('Fatal')}} </label>
            </div>
            <span class="invalid-feedback" role="alert"><strong>{{__('Risk potential level field is required.')}}</strong></span>            
        </div>
    </div>
    @else
        <input type="hidden" name="riskpotentiallevel" value="{{$Observation->riskpotentiallevel}}">
    @endif


    @if($cuser->hasRole('Super Admin') || $cuser->can('Actions Add'))
    <div class="col-md-12">
        <div class="form-group">            
            <label for="exampleInputEmail1">{{__('Action required')}}<span class="required">*</span></label>
            <div class="rightcheckbox classaction_required">
                <div class="form-check">
                    <input class="form-check-input action_required" type="radio" name="action_required" id="exampleRadios1" value="1" <?php echo ($Observation->action_required==1)?'checked':''; ?> />
                    <label class="form-check-label" for="exampleRadios1">
                        {{__('Yes')}}
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input action_required" type="radio" name="action_required" id="exampleRadios12" value="0"  <?php echo ($Observation->action_required==0)?'checked':''; ?> />
                    <label class="form-check-label" for="exampleRadios12">
                        {{__('No')}}
                    </label>
                </div>
            </div>
            <span class="invalid-feedback" role="alert"><strong>{{__('Actions field is required')}}</strong></span>
        </div>
        <div class="form-group gcsphideactionsmain <?php echo ($Observation->action_required==1)?'':'gcsphideactions'; ?> p-3">
           
        <div class="actionslists actionslists border-0 pt-0 mt-0">
            <div class="actionsec">
                <div class="acttitle"><h4 class="formtitle"> {{__('Actions')}} <span>({{count($Actions)}})</span></h4></div>
                <div class="actpopup"><a class="gcspaddaction" ><span>+</span> {{__('Add Action')}}</a></div>
            </div>

            <div class="actlisting">
              <ul>
                @foreach($Actions as $ActionsOpen_item)
                <li>
                    <h5>{{substr($ActionsOpen_item->am_description,0,70)}}</h5>
                    <p>Control: {{$ActionsOpen_item->cm_name}}<br><span> Responsibility: {{GetActionResponsibility($ActionsOpen_item->am_id)}} </span><br><span> Due by: {{date('d M, Y',strtotime($ActionsOpen_item->am_due_date))}} | <span class="actlabel overdue"> {{GetActionStatus($ActionsOpen_item->am_status)}}</span></span></p>

                    <div class="reportaction">
                      <div class="repodtactimg">
                      <img src="{{asset('images/PPE.png')}}" alt="">
                      </div>
                      <div class="repodtactext"><span>{{$ActionsOpen_item->name}}</span><span>{{date('d M, Y D h:ia',strtotime($ActionsOpen_item->created_at))}}</span></div>
                   </div> 

                   <div class="gcspaction">
                    @if($cuser->hasRole('Super Admin') || $cuser->can('Actions Edit'))
                      <a href="{{ route('actionsedit',['id'=>$ActionsOpen_item->am_id]) }}" class="ml-1 actionsedit"><i class="fa fa-edit"></i></a>
                    @endif
                    @if($cuser->hasRole('Super Admin') || $cuser->can('Actions Delete'))  
                      <a  href="{{ route('actionsdelete',['id'=>$ActionsOpen_item->am_id]) }}" data-type="edit" data-parentid="{{$ActionsOpen_item->am_parent_id}}"  class="ml-1 actionsdelete"><i class="fa fa-trash"></i></a>
                    @endif  
                   </div>  
                </li>
                @endforeach
              </ul>
              <div class="actionhtmlbefore"></div>
            </div>
         </div>
        </div>        
    </div> 
    @else
    <input type="hidden" name="action_required" value="{{$Observation->action_required}}">
    @endif

</div>

<div class="row">
    <?php /*
    <div class="col-md-12">
        <div class="form-group gc-uploadbtn">
                <div id="newfiletypeadded"></div>
                <div class="gcspuploadedwpr">
                   <label for="file-upload" class="custom-file-upload">
                       <img src="{{ asset('images/attached-file.png') }}" alt="">
                    </label>
                    <input id="file-upload" class="file-upload" name="attachedmain[]" type="file" multiple accept=".xlsx,.xls,image/*,.doc,.docx,.ppt,.pptx,.pdf" />
                </div>    
                <div id="fileinstedt"></div>
                <div id="fileinstedtimg"></div>
            <?php 
            if($observations_attachement_rel){
                echo '<hr/>';
                foreach ($observations_attachement_rel as $key => $value) {                    
                    $attachamentsrc=url('storage/'.$value->attachament);
                    $path_info = pathinfo($attachamentsrc);                    
                    if($path_info['extension']=='pdf'){$attachamentsrc=asset('images/pdf.png');}
                    if($path_info['extension']=='docx'){$attachamentsrc=asset('images/doc.png');}
                    if($path_info['extension']=='xlsx'){$attachamentsrc=asset('images/excel.png');}
                    if($path_info['extension']=='bin'){$attachamentsrc=asset('images/ppt.png');}
                    if($path_info['extension']=='pptx'){$attachamentsrc=asset('images/ppt.png');}
                    

                    ?>
                    <span class="pip pip{{$value->oar_id}}"><a title="{{$value->attachement_name}}" href="{{url('storage/'.$value->attachament)}}" target="_blank"><img alt="{{$value->attachement_name}}" class="imageThumb" src="{{$attachamentsrc}}" ></a><br><span class="removeimg"><a class="removeimgobserve"  href="{{ route('deletefile',['id'=>$value->oar_id])}}" ><i class="fa fa-times-circle"></i></a></span></span>
            <?php }
                
            }
            ?>
        </div> 
    </div>*/?>

         <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Make a suggestion/recommendation')}}<span class="required">*</span></label>
                <textarea  name="Comments" class="form-control classComments">{{  $Observation->Comments  }}</textarea>
                <span class="invalid-feedback" role="alert"><strong>{{__('Make a suggestion field is required.')}}</strong></span>
            </div>
         </div>

         @if($cuser->hasRole('Super Admin') || $cuser->can('Observations Close'))


        <div class="col-md-12">
            <div class="form-group">                        
            <div class="rightcheckbox classlisting_type">
                <div class="form-check">
                    <input class="form-check-input" {{($Observation->ob_more_information_required==1)?'checked':''}} type="checkbox" name="ob_more_information_required" id="ob_more_information_required" value="1"  />
                    <label class="form-check-label" for="ob_more_information_required">
                        {{__('More information required')}}
                    </label>
                </div>                
            </div>            
            </div> 
        </div>

        <div class="col-md-12 ob_information_required" style="{{($Observation->ob_more_information_required!=1)?'display: none;':''}}">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Please give details of information required')}}<span class="required">*</span></label>
                <textarea  name="ob_information_required" {{($Observation->ob_more_information_required==1)?'required':''}} class="form-control classComments">{{  $Observation->ob_information_required  }}</textarea>                
            </div>
         </div>
          @if($Observation->ob_more_information_required==1)

         <div class="col-md-12 ob_reply_information_requested ob_information_required">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Reply to more information requested')}}<span class="required">*</span></label>
                <textarea  name="ob_reply_information_requested" required class="form-control classComments">{{  $Observation->ob_reply_information_requested  }}</textarea>                
            </div>
         </div>
         <div class="col-md-12 ob_information_required">
        <div class="form-group gc-uploadbtn">
            <label for="exampleInputEmail1">{{__('Reply to more information attachement')}}<span class="required">*</span></label>
                <div id="newfiletypeaddedora"></div>
                <div class="gcspuploadedwpr">
                   <label for="file-upload-ora" class="custom-file-upload">
                       <img src="{{ asset('images/attached-file.png') }}" alt="">
                    </label>
                    <input id="file-upload-ora" class="file-upload-ora" name="attachedmain_ora[]" type="file" multiple accept=".xlsx,.xls,image/*,.doc,.docx,.ppt,.pptx,.pdf" />
                </div>    
                <div id="fileinstedtora"></div>
                <div id="fileinstedtimgora"></div>
            <?php 
            if($observations_reply_attachement){
                
                foreach ($observations_reply_attachement as $key => $value) {                    
                    $attachamentsrc=url('storage/'.$value->ora_attachament);
                    $path_info = pathinfo($attachamentsrc);                    
                    if($path_info['extension']=='pdf'){$attachamentsrc=asset('images/pdf.png');}
                    if($path_info['extension']=='docx'){$attachamentsrc=asset('images/doc.png');}
                    if($path_info['extension']=='xlsx'){$attachamentsrc=asset('images/excel.png');}
                    if($path_info['extension']=='bin'){$attachamentsrc=asset('images/ppt.png');}
                    if($path_info['extension']=='pptx'){$attachamentsrc=asset('images/ppt.png');}
                    

                    ?>
                    <span class="pip pipora{{$value->ora_id}}"><a title="{{$value->ora_attachement_name}}" href="{{url('storage/'.$value->ora_attachament)}}" target="_blank"><img alt="{{$value->ora_attachement_name}}" class="imageThumb" src="{{$attachamentsrc}}" ></a><br><span class="removeimg"><a class="removeimgobserveora"  href="{{ route('deletefileora',['ora_id'=>$value->ora_id])}}" ><i class="fa fa-times-circle"></i></a></span></span>
            <?php }
            }
            ?>
        </div> 
    </div>


         @endif 




         <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Status')}}<span class="required">*</span></label>
                <select name="status" required class="form-control gcspchangeobsevationstatus">
                     <option value="" >{{__('Select')}} {{__('Status')}}</option>   
                     <option value="1" {{  ($Observation->status==1)?'selected="selected"':''  }}>{{__('Open')}}</option>   
                     <option value="0" {{  ($Observation->status==0)?'selected="selected"':''  }}>{{__('Close')}}</option>   
                </select>
            </div>
         </div> 

         <div class="col-md-12 ob_closing_comments" style="{{($Observation->status!=0)?'display: none;':''}}">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Closing Comments')}}<span class="required">*</span></label>
                <textarea  name="ob_closing_comments" {{($Observation->status!=1 && $Observation->status!=2)?'required':''}} class="form-control classComments">{{  $Observation->ob_closing_comments  }}</textarea>
                <span class="invalid-feedback" role="alert"><strong>{{__('Closing Comments is required.')}}</strong></span>
            </div>
         </div>
         @else
         <input type="hidden" name="status" value="{{$Observation->status}}">
         <input type="hidden" name="ob_more_information_required" value="{{$Observation->ob_more_information_required}}">
         @if($Observation->ob_more_information_required==1)

         <div class="col-md-12 ob_reply_information_requested">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Please give details of information required.')}}<span class="required">*</span></label>
                <textarea disabled  class="form-control classComments">{{  $Observation->ob_information_required  }}</textarea>                
            </div>
         </div>

         <div class="col-md-12 ob_reply_information_requested">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Reply to more information requested')}}<span class="required">*</span></label>
                <textarea  name="ob_reply_information_requested" required class="form-control classComments">{{  $Observation->ob_reply_information_requested  }}</textarea>                
            </div>
         </div>

    <div class="col-md-12">
        <div class="form-group gc-uploadbtn">
            <label for="exampleInputEmail1">{{__('Reply to more information attachement')}}<span class="required">*</span></label>
                <div id="newfiletypeaddedora"></div>
                <div class="gcspuploadedwpr">
                   <label for="file-upload-ora" class="custom-file-upload">
                       <img src="{{ asset('images/attached-file.png') }}" alt="">
                    </label>
                    <input id="file-upload-ora" class="file-upload-ora" name="attachedmain_ora[]" type="file" multiple accept=".xlsx,.xls,image/*,.doc,.docx,.ppt,.pptx,.pdf" />
                </div>    
                <div id="fileinstedtora"></div>
                <div id="fileinstedtimgora"></div>
            <?php 
            if($observations_reply_attachement){
                echo '<hr/>';
                foreach ($observations_reply_attachement as $key => $value) {                    
                    $attachamentsrc=url('storage/'.$value->ora_attachament);
                    $path_info = pathinfo($attachamentsrc);                    
                    if($path_info['extension']=='pdf'){$attachamentsrc=asset('images/pdf.png');}
                    if($path_info['extension']=='docx'){$attachamentsrc=asset('images/doc.png');}
                    if($path_info['extension']=='xlsx'){$attachamentsrc=asset('images/excel.png');}
                    if($path_info['extension']=='bin'){$attachamentsrc=asset('images/ppt.png');}
                    if($path_info['extension']=='pptx'){$attachamentsrc=asset('images/ppt.png');}
                    

                    ?>
                    <span class="pip pipora{{$value->ora_id}}"><a title="{{$value->ora_attachement_name}}" href="{{url('storage/'.$value->ora_attachament)}}" target="_blank"><img alt="{{$value->ora_attachement_name}}" class="imageThumb" src="{{$attachamentsrc}}" ></a><br><span class="removeimg"><a class="removeimgobserveora"  href="{{ route('deletefileora',['ora_id'=>$value->ora_id])}}" ><i class="fa fa-times-circle"></i></a></span></span>
            <?php }
            }
            ?>
        </div> 
    </div>
         @endif  


         @endif 

                    

    </div>
    <button type="submit" class="btn btn-primary observationupdate">{{__('Submit')}}</button>
</form>
</div>

