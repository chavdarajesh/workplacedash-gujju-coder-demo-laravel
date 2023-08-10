@extends('layouts.dashboard')
@section('content')
<script type="text/javascript">
     @if(count($Actions))  var  insrno=<?php echo count($Actions);?>; @else var  insrno=1; @endif
</script>
<div class="gcspfullpagewapper">
<div class="gc-form-title">
 <h5>{{__('Incident Reporting Form')}}</h5>
</div>
<form action="{{route('stepnoninvistigation')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="im_id" value="{{$Incident->im_id}}">    
    <input type="hidden" name="step" value="{{$step}}">    
    <div class="row">
        <div class="col-md-4">
            <div class="form-group gcsptreeviewwapepe">
                <label for="exampleInputEmail1">1. {{__('Select incident type')}}<span class="required">*</span></label>
                <select  name="im_ic_id" class="oc_id"  >  
                    {!! GetCatDropDown(2,$Incident->im_ic_id) !!}                                          
                </select>                
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group gcsptreeviewwapepe">
                <label for="exampleInputEmail1">2. {{__('Where? name the location, area, site')}}<span class="required">*</span></label>
                <select  class="site_id" name="im_site_id">
                {!! GetSiteDropDown(null,$Incident->im_site_id) !!}
                </select>              
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">3. {{__('When? select date and time')}}<span class="required">*</span></label>
                <input required type="datetime-local" value="{{ date('Y-m-d',strtotime($Incident->im_datetime)) }}T{{ date('H:i:s',strtotime($Incident->im_datetime)) }}" name="im_datetime" placeholder="" onClick="$(this).removeClass('placeholderclass')" class="dateclass  form-control"  />
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">4. {{__('Select Shift')}}<span class="required">*</span></label>
                <select name="im_shift" required class="form-control" >
                    <option>{{__('Select')}}</option>
                    <?php if(count($Shifts)){
                        foreach ($Shifts as $key => $ShiftsValue) {?>
                         <option <?php echo ($Incident->im_shift==$ShiftsValue->sm_id)?'selected':''; ?> value="{{$ShiftsValue->sm_id}}">{{$ShiftsValue->sm_name}}</option>
                     <?php   }
                 } ?> 

             </select>                
         </div>
     </div>

     <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">5. {{__('Machine no / Extra location')}}</label>
            <input  type="text" value="{{ $Incident->im_machineno_extralocation }}" name="im_machineno_extralocation"  class="form-control"  />
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label for="exampleInputEmail1">6. {{__('Describe your incident in few words')}}...<span class="required">*</span></label>
            <textarea class="form-control" name="im_description" >{{ $Incident->im_description }}</textarea>                
        </div>
    </div>            
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">7. {{__('Extent of damage')}}</label>
            <input  type="text" value="{{ $Incident->im_extendofdamange }}" name="im_extendofdamange"  class="form-control"  />
        </div>        
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">8. {{__('Immediate action taken')}}<span class="required">*</span></label>
            <input  type="text" required="required" value="{{ $Incident->im_immediateactiontaken }}" name="im_immediateactiontaken"  class="form-control"  />
        </div>                
    </div>
</div>        

<div class="row">        
    <div class="col-md-4">
        

        <div class="form-group ">
            <label for="exampleInputEmail1">9. {{__('Upload images or attach files')}}</label>
                <div id="newfiletypeadded"></div>
                <div class="gcspuploadedwpr">
                   <label for="file-upload" class="custom-file-upload d-block">
                       <img src="{{ asset('images/attached-file.png') }}" alt="">
                    </label>
                    <input id="file-upload" class="file-upload" name="attachedmain[]" type="file" multiple accept=".xlsx,.xls,image/*,.doc,.docx,.ppt,.pptx,.pdf" />
                </div>    
                <div id="fileinstedt"></div>
                <div id="fileinstedtimg"></div>
            <?php 
            if($incidents_attachement_rel){
                echo '<hr/>';
                foreach ($incidents_attachement_rel as $key => $value) {                    
                    $attachamentsrc=url('storage/'.$value->attachament);
                    $path_info = pathinfo($attachamentsrc);                    
                    if($path_info['extension']=='pdf'){$attachamentsrc=asset('images/pdf.png');}
                    if($path_info['extension']=='docx'){$attachamentsrc=asset('images/doc.png');}
                    if($path_info['extension']=='xlsx'){$attachamentsrc=asset('images/excel.png');}
                    if($path_info['extension']=='bin'){$attachamentsrc=asset('images/ppt.png');}
                    if($path_info['extension']=='pptx'){$attachamentsrc=asset('images/ppt.png');}                    
                    ?>
                    <span class="pip"><a title="{{$value->attachement_name}}" href="{{url('storage/'.$value->attachament)}}" target="_blank"><img alt="{{$value->attachement_name}}" class="imageThumb" src="{{$attachamentsrc}}" ></a><br><span class="removeimg"><a  href="{{ route('incidentsdeletefile',['id'=>$value->ia_id])}}" onclick="return confirm('Are you sure you want to delete this file, this file will not recoverd once deleted.?')"><i class="fa fa-times-circle"></i></a></span></span>
            <?php }
                
            }
            ?>
        </div> 
    
        
    
    </div>    
</div>
<hr class="border">
<div class="row">
    <div class="col-md-4">
        <div class="form-group gcspvictombtn">
            <label for="exampleInputEmail1">10. {{__('Were there any victim(s)')}}<span class="required">*</span></label>  
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-primary mr-2 im_anyvictim {{($Incident->im_anyvictim==1)?'active':''}}" data-value="1">
                    <input type="radio" name="im_anyvictim" id="im_anyvictim1" value="1" class="im_anyvictim" {{($Incident->im_anyvictim==1)?'checked':''}}> {{__('Yes')}}
                </label>
                <label class="btn btn-primary {{($Incident->im_anyvictim!=1)?'active':''}}  mr-2 im_anyvictim"  data-value="0">
                    <input type="radio" name="im_anyvictim" id="im_anyvictim0" value="0" class="im_anyvictim"  {{($Incident->im_anyvictim!=1)?'checked':''}}> {{__('No')}}
                </label>
            </div>
        </div>            
    </div>
    <div class="col-md-12">
    <div class="form-group gcsphidevictimmain {{($Incident->im_anyvictim==1)?'':'gcsphidevictim'}}  p-3">
            <div class="gc-form-title col-sm-4" >
                <div class="row">
                    <div class="col-md-6">
                        <h5>{{__('Victim')}}</h5>
                    </div>
                    <div class="col-md-6 text-right">
                        @if($Incident->im_actionapproved!=1)
                        <a href="javascript:void(0);" class="btn btn-primary gcspaddvictim"><i class="fa fa-plus"></i> {{__('Add victim')}}</a>
                        @endif
                    </div>
                </div>    
            </div>

            @if(count($AddedVictims))
            <div class="row mt-3 mb-5">
                @foreach($AddedVictims as $AddedVictimsItem)
                <div class="col-sm-4">
                    <div class="p-3 bg-white">
                    <table >
                        <td valign="top" width="25"><i class="fa fa-user " aria-hidden="true"></i></td>
                        <td>
                            <p><b>{{$AddedVictimsItem->iv_name}}</b></p>
                            <p>{{GetGender($AddedVictimsItem->iv_gender)}}({{$AddedVictimsItem->iv_age_range}} {{__('Yrs')}}) | {{$AddedVictimsItem->vtm_name}}</p>
                            <p><b>{{__('Body part(s) injured')}}: {{$AddedVictimsItem->bodypart_count}}</b></p>
                        </td>
                    </table>
                    </div>
                </div>    
                @endforeach
            </div>    
            @endif
            <div class="victomhtmlbefore"></div>
        </div> 
    </div>    

</div> 

 
<div class="gc-form-title mt-5 mb-4">
   <h5>11. {{__('Recommended Actions')}} (CAPA)</h5> 
</div>

    @csrf
    <input type="hidden" name="im_id" value="{{$Incident->im_id}}">    
    <input type="hidden" name="step" value="{{$step}}"> 

    @if(count($Actions))
    @foreach($Actions as $key=> $ActionsItem)
    <div class="gcspaddedaction">

        <input type="hidden" name="insrno[]" value="{{$key}}">
    <input type="hidden" name="am_id[]" value="{{$ActionsItem->am_id}}">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Description of the actions')}}<span class="required">*</span></label>
                <textarea class="form-control" required  name="action_description[]" >{{$ActionsItem->am_description}}</textarea>                
            </div>
        </div>
        <div class="col-md-3">    
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Type Control')}}<span class="required">*</span></label>
                <select  class="form-control multipleSelect"  required name="control[]" >
                    <option value="">{{__('Select')}}</option>
                    <?php foreach ($Control as $Control_value) {?>
                        <option <?php if($Control_value->cm_id==$ActionsItem->am_control){echo 'selected';} ?> value="{{$Control_value->cm_id}}">{{$Control_value->cm_name}}</option>
                    <?php } ?>                      
                </select>   
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleInputEmail11">{{__('Responsibility')}}<span class="required">*</span></label>
                <?php $actions_responsible=GetActionResponsibilityUserID($ActionsItem->am_id); ?>
                <select  class="form-control multipleSelect"  required name="user_id[{{$key}}][]" multiple >                    
                    <?php foreach ($Users as $Users_value) {?>
                        <option <?php if(in_array($Users_value->id, $actions_responsible)){echo 'selected';} ?> value="{{$Users_value->id}}">{{$Users_value->name}} - {{$Users_value->r_name}}</option>                        
                    <?php } ?>                      
                </select>                
            </div>
        </div>
        <div class="col-md-3">    
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Target date')}}<span class="required">*</span></label>
                <input  type="datetime-local" value="{{ date('Y-m-d',strtotime($ActionsItem->am_due_date)) }}T{{ date('H:i:s',strtotime($ActionsItem->am_due_date)) }}" required  name="due_date[]" placeholder="" onClick="$(this).removeClass('placeholderclass')" class="dateclass form-control"  />

            </div>
        </div>
    </div>

    </div>    
    @endforeach
    @else    
    <input type="hidden" name="insrno[]" value="0">
    <input type="hidden" name="am_id[]" value="0">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Description of the actions')}}</label>
                <textarea class="form-control" required  name="action_description[]" ></textarea>                
            </div>
        </div>
        <div class="col-md-3">    
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Type Control')}}</label>
                <select  class="form-control selectControl multipleSelect"  required name="control[]" >
                    <option value="">{{__('Select')}}</option>
                    <?php foreach ($Control as $key => $Control_value) {?>
                        <option  value="{{$Control_value->cm_id}}">{{$Control_value->cm_name}}</option>
                    <?php } ?>                      
                </select>   
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleInputEmail11">{{__('Responsibility')}}</label>
                <select  class="form-control selectResponsibility multipleSelect"  required name="user_id[0][]" multiple >                    
                    <?php foreach ($Users as $key => $Users_value) {?>
                        <option value="{{$Users_value->id}}">{{$Users_value->name}} - {{$Users_value->r_name}}</option>
                    <?php } ?>                      
                </select>                
            </div>
        </div>
        <div class="col-md-3">    
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Target date')}}</label>
                <input  type="datetime-local" value="" required  name="due_date[]" placeholder="" onClick="$(this).removeClass('placeholderclass')" class="dateclass placeholderclass form-control"  />

            </div>
        </div>
    </div>
    @endif

    <div class="actionhtmlbefore"></div>
    @if($Incident->im_actionapproved!=1)
    <button type="button" class="btn btn-primary mt-3 mb-3 gcspincidentaddaction">{{__('Add Row')}}</button> 
    @endif
    <div class="clear"></div>
<?php if($cuser->hasRole('Super Admin') || $cuser->id==$Incident->im_created_by){?>
<button type="submit" class="btn btn-primary actionsfieldsrequred">{{__('Submit')}}</button> 
<?php } ?>
<div class="mb-5"></div>
</form>
</div>
@endsection
