@extends('layouts.dashboard')
@section('content')
<div class="gcspfullpagewapper">
@include('incidents.datails')
<div class="gc-form-title mt-5 mb-4">
   <h5>Step 5: {{__('Review and Closure')}}</h5> 
</div>
<form action="{{route('step5')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="im_id" value="{{$Incident->im_id}}">    
    <input type="hidden" name="step" value="{{$step}}"> 
    
    @foreach($Actions as $key=> $ActionsItem)
    <div class="gcspaddedaction">

        <input type="hidden" name="insrno[]" value="{{$key}}">
    <input type="hidden" name="am_id[]" value="{{$ActionsItem->am_id}}">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Description of the actions')}}</label>
                <textarea class="form-control" disabled required  name="action_description[]" >{{$ActionsItem->am_description}}</textarea>                
            </div>
        </div>
        <div class="col-md-3">    
            <div class="form-group disalbeselect">
                <label for="exampleInputEmail1">{{__('Type Control')}}</label>
                <select  class="form-control multipleSelect" disabled required name="control[]" >
                    <option value="">{{__('Select')}}</option>
                    <?php foreach ($Control as $Control_value) {?>
                        <option <?php if($Control_value->cm_id==$ActionsItem->am_control){echo 'selected';} ?> value="{{$Control_value->cm_id}}">{{$Control_value->cm_name}}</option>
                    <?php } ?>                      
                </select>   
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group disalbeselect">
                <label for="exampleInputEmail11">{{__('Responsibility')}}</label>
                <?php $actions_responsible=GetActionResponsibilityUserID($ActionsItem->am_id); ?>
                <select  class="form-control multipleSelect" disabled required name="user_id[{{$key}}][]" multiple >                    
                    <?php foreach ($Users as $Users_value) {?>
                        <option <?php if(in_array($Users_value->id, $actions_responsible)){echo 'selected';} ?> value="{{$Users_value->id}}">{{$Users_value->name}} - {{$Users_value->r_name}}</option>                        
                    <?php } ?>                      
                </select>                
            </div>
        </div>
        <div class="col-md-3">    
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Target date')}}</label>
                <input  type="datetime-local" disabled value="{{ date('Y-m-d',strtotime($ActionsItem->am_due_date)) }}T{{ date('H:i:s',strtotime($ActionsItem->am_due_date)) }}" required  name="due_date[]" placeholder="" onClick="$(this).removeClass('placeholderclass')" class="dateclass form-control"  />

            </div>
        </div>
    </div>

    </div>    
    @endforeach
    
    <div class="row">
        <div class="col-md-3">
            <div class="form-group ">
                <label for="exampleInputEmail1">{{__('Status')}}<span class="required">*</span></label>
                <select  class="form-control" required name="im_status" >
                    <option <?php echo ($Incident->im_status==1)?'selected':''; ?> value="1">{{__('Open')}}</option>
                    <option <?php echo ($Incident->im_status==0)?'selected':''; ?> value="0">{{__('Close')}}</option>                        
                </select>   
            </div>
        </div>
    </div>        


    <div class="clear"></div>
    <?php if($cuser->hasRole('Super Admin') || $cuser->id==$Incident->im_created_by){?>
        <button type="submit" class="btn btn-primary  mt-5">{{__('Save')}}</button>
    <?php } ?> 
    <div class="mb-5"></div>
</form>
</div>
@endsection