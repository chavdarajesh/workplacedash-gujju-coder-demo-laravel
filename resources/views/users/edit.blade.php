@extends('layouts.dashboard')

@section('content')
<div class="gcspfullpagewapper">
  <form action="{{route('userupdate')}}" method="post">
    @csrf    
   
    <input type="hidden" name="id" value="{{ $Users->id }}">
    <input type="hidden" name="old_role" value="{{ $Users->is_admin }}">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Full Name')}}</label>
                <input name="name" type="text" value="{{ $Users->name }}" required class="form-control" >        
            </div>
        </div>  
        <div class="col-md-6">  
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Email')}}</label>
                <input required name="email" value="{{ $Users->email }}" type="text" class="form-control" >        
            </div>
             @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
        </div>    
    </div>        
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Select user role')}}</label>

                <select required name="is_admin" required class="form-control" >
                    <option value="">{{__('Select')}}</option>
                    <?php foreach ($Roles as $key => $value) { ?>
                        <option <?php echo ($value->id==$Users->is_admin)?'selected':''; ?> value="{{$value->id}}">{{$value->r_name}}</option>    
                    <?php } ?>                    
                </select>                
            </div>
        </div>
        <div class="col-md-6">    
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Select sites')}}</label>
                <select class="form-control multipleSelect"   multiple name="sites[]">                                        
                    <?php if(count($sites)){
                        foreach ($sites as $key => $value) {?>
                        <option <?php echo (in_array($value->id, $user_site))?'selected':''; ?> value="{{$value->id}}">{{$value->site_name}}</option>    
                    <?php } } ?> 
                </select>                
            </div>
        </div>    
    </div>
    <div class="row">
    <div class="col-md-6">  
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Employee ID')}}</label>
                <input required name="empid" value="{{ $Users->empid }}" type="text" class="form-control" >        
            </div>
            @error('empid')
            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
            </span>
            @enderror
    </div> 
    <div class="col-md-6">

    <div class="form-group"> 
        <label for="exampleInputEmail1">{{__('Status')}}</label><br>              
        <div class="form-check form-check-inline">
            <input <?php echo ($Users->status==1)?'checked':''; ?> class="form-check-input" type="radio" name="status" id="exampleRadios1" value="1"  />
            <label class="form-check-label" for="exampleRadios1">
                {{__('Active')}}
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input <?php echo ($Users->status==0)?'checked':''; ?> class="form-check-input" type="radio" name="status" id="exampleRadios12" value="0"  />
            <label class="form-check-label" for="exampleRadios12">
                {{__('Inactive')}}
            </label>
        </div>
    </div>  
    </div>  
    <input type="hidden" name="planguage" value="en">
    <?php /*<div class="col-md-6">  
            <div class="form-group">
                <label for="exampleInputEmail1">{{ __('Preferred Language') }}</label>
                <select class="form-control @error('planguage') is-invalid @enderror" required name="planguage">
                    <option value="">{{__('Select Language')}}</option>
                    <option <?php if($Users->planguage=='es'){echo 'selected';}?> value="es">Spanish</option>
                    <option <?php if($Users->planguage=='en'){echo 'selected';}?> value="en">English</option> 
                </select>                                 
            </div>            
    </div> */?>
    <div class="col-md-12">  
        <button type="submit" class="btn btn-primary">{{__('Submit')}}</button> 
    </div>
</form>
</div>
@endsection
