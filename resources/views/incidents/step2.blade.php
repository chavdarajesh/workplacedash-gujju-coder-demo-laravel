@extends('layouts.dashboard')
@section('content')
<div class="gcspfullpagewapper">
@include('incidents.datails')

<div class="gc-form-title mt-5">
 <h5>{{__('Paso')}} 2 : {{__('Investigation Team Formation')}}</h5>
</div>
<form action="{{route('step2')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="im_id" value="{{$Incident->im_id}}">    
    <input type="hidden" name="step" value="{{$step}}">    
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Investigation team lead')}}<span class="required">*</span></label>
                <select name="im_investigateteamlead" class="form-control multipleSelect" >
                    <option value="">Select</option>
                    <?php foreach ($Users as $key => $Users_value) {?>
                        <option <?php echo ($Users_value->id==$Incident->im_investigateteamlead)?'selected':''; ?> value="{{$Users_value->id}}">{{$Users_value->name}} - {{$Users_value->r_name}}</option>
                    <?php } ?>
                </select>                
            </div>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Investigation team members')}}<span class="required">*</span></label>
                <select name="iit_user_id[]" class="form-control multipleSelect" multiple>
                    <?php foreach ($Users as $key => $Users_value) {?>
                        <option <?php echo (in_array($Users_value->id, $incidents_investigation_team))?'selected':''; ?> value="{{$Users_value->id}}">{{$Users_value->name}} - {{$Users_value->r_name}}</option>
                    <?php } ?>
                </select>                
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Target date to complete')}}<span class="required">*</span></label>
                <input  type="text" <?php if($Incident->im_dateofcomplete){ ?> value="{{date('d-m-Y',strtotime($Incident->im_dateofcomplete))}}" <?php } ?>  name="im_dateofcomplete"  class="gcspdatepicker form-control"  />
            </div>
        </div>
        
</div>
<?php if($cuser->hasRole('Super Admin') || $cuser->id==$Incident->im_created_by){?>
<button type="submit" class="btn btn-primary mb-5">{{__('Submit')}}</button> 
<?php } ?>
</form>
</div>
@endsection
