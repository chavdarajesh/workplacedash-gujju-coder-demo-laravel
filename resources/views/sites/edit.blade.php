@extends('layouts.dashboard')

@section('content')
<div class="gcspfullpagewapper">
   <form action="{{ route('sitesupdate')}}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{$Sites->id}}">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Site Name')}}<span class="required">*</span></label>
                <input type="text" value="{{$Sites->site_name}}" name="site_name" required class="form-control" >        
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Site ID')}}<span class="required">*</span></label>
                <input type="text" value="{{$Sites->site_id}}" name="site_id" required class="form-control" >        
            </div>
        </div>    
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Time Zone')}}<span class="required">*</span></label>
                <select name="site_timezone" required class="form-control" >
                    <option>{{__('Select')}}</option>                    
                    <option <?php echo ($Sites->site_timezone=='UTC−5')?'selected':''; ?> value="UTC−5">UTC−5: Eastern Standard Time (EST)</option>
                    <option <?php echo ($Sites->site_timezone=='UTC−6')?'selected':''; ?> value="UTC−6">UTC−6: Central Standard Time (CST)</option>
                    <option <?php echo ($Sites->site_timezone=='UTC−7')?'selected':''; ?> value="UTC−7">UTC−7: Mountain Standard Time (MST)</option>
                    <option <?php echo ($Sites->site_timezone=='UTC−8')?'selected':''; ?> value="UTC−8">UTC−8: Pacific Standard Time (PST)</option>
                </select>                
            </div>
        </div>
        <div class="col-md-6">    
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Receiver list')}}<span class="required">*</span></label>
                <select name="site_headofsafety[]" multiple required class="form-control multipleSelect" >
                    <option>{{__('Select')}}</option>
                    <?php 
                    foreach ($Users as $key => $value) {?>
                       <option <?php echo (in_array($value->id,$site_headofsafety))?'selected':''; ?> value="{{$value->id}}">{{$value->name}}</option>
                    <?php } ?>
                </select>                
            </div>
        </div>    
     </div>
    
    <div class="row">
        <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">{{__('Emergency mobile number')}}</label>
                    <input type="text" value="{{$Sites->sos_mobile}}"  name="sos_mobile" class="form-control" />
                </div>
        </div>
        <div class="col-md-6">        
                <div class="form-group">
                    <label for="exampleInputEmail1">{{__('Emergency email ID')}}</label>
                    <input type="email" value="{{$Sites->sos_email}}"  name="sos_email" class="form-control" />
                </div>
        </div>        
    </div>

    <div class="form-group">        
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="1" <?php echo ($Sites->status==1)?'checked':''; ?>  />
            <label class="form-check-label" for="exampleRadios1">
                {{__('Active')}}
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="0" <?php echo ($Sites->status==0)?'checked':''; ?>  />
            <label class="form-check-label" for="exampleRadios2">
                {{__('Inactive')}}
            </label>
        </div>
    </div>
    
    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button> 
</form>
</div>
@endsection
