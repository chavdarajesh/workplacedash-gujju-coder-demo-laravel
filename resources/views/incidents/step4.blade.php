@extends('layouts.dashboard')
@section('content')
<script type="text/javascript">
     @if($Actions)  var  insrno=<?php echo count($Actions);?>; @else var  insrno=1; @endif
</script>
<div class="gcspfullpagewapper">
@include('incidents.datails')
<div class="gc-form-title mt-5 mb-4">
   <h5>{{__('Paso')}} 4 : {{__('Recommended Actions')}} (CAPA)</h5> 
</div>
<form action="{{route('step4')}}" method="post" enctype="multipart/form-data">
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
                <select  class="form-control selectControl multipleSelect"  required name="control[]" >
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
                <select  class="form-control selectResponsibility multipleSelect"  required name="user_id[{{$key}}][]" multiple >                    
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
                <label for="exampleInputEmail1">{{__('Description of the actions')}}<span class="required">*</span></label>
                <textarea class="form-control" required  name="action_description[]" ></textarea>                
            </div>
        </div>
        <div class="col-md-3">    
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Type Control')}}<span class="required">*</span></label>
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
                <label for="exampleInputEmail11">{{__('Responsibility')}}<span class="required">*</span></label>
                <select  class="form-control selectResponsibility multipleSelect"  required name="user_id[0][]" multiple >                    
                    <?php foreach ($Users as $key => $Users_value) {?>
                        <option value="{{$Users_value->id}}">{{$Users_value->name}} - {{$Users_value->r_name}}</option>
                    <?php } ?>                      
                </select>                
            </div>
        </div>
        <div class="col-md-3">    
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Target date')}}<span class="required">*</span></label>
                <input  type="datetime-local" value="" required  name="due_date[]" placeholder="" onClick="$(this).removeClass('placeholderclass')" class="dateclass placeholderclass form-control"  />

            </div>
        </div>
    </div>
    @endif

    <div class="actionhtmlbefore"></div>
    @if($Incident->im_actionapproved!=1)
    <button type="button" class="btn btn-primary mt-3 gcspincidentaddaction">{{__('Add Row')}}</button> 
    @endif
    <div class="clear"></div>
    <?php if($cuser->hasRole('Super Admin') || $cuser->id==$Incident->im_created_by){?>
    <button type="submit" class="btn btn-primary mb-5 mt-5 actionsfieldsrequred">{{__('Submit')}}</button> 
    <?php } ?>
</form>
@if(count($Actions))
<hr>
<form action="{{route('approvedstep4')}}" method="post" enctype="multipart/form-data">
    @csrf
<input type="hidden" name="im_id" value="{{$Incident->im_id}}">    
<input type="hidden" name="step" value="{{$step}}">
<input type="hidden" name="im_approved_by" value="{{$UsersApproval->id}}">     
<div class="gc-form-title">
   <h5>{{__('Approver')}}</h5> 
</div> 
    <h6>{{$UsersApproval->name}}</h6>
    <h6>{{$UsersApproval->r_name}}</h6>
    <?php if($cuser->hasRole('Super Admin')){?>  
        @if($Incident->im_actionapproved!=1)
        <button type="submit" name="approve" value="1" class="btn btn-success mt-5">{{__('Approve')}}</button>        
        <button type="submit" name="approve" value="0" class="btn btn-danger  mt-5">{{__('Reject')}}</button>         
        @endif
    <?php } ?>
    <div class="mb-5">&nbsp;</div>
</form>
@endif
</div>
@endsection