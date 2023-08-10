@extends('layouts.dashboard')

@section('content')
<div class="gcspfullpagewapper">
  <form action="{{route('userstore')}}" method="post">
    @csrf    
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Full Name')}}</label>
                <input name="name" type="text" value="{{ old('name') }}" required class="form-control" >        
            </div>
        </div>  
        <div class="col-md-6">  
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Email')}}</label>
                <input required name="email" value="{{ old('email') }}" type="text" class="form-control" >        
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
                    <?php foreach ($Roles as $key => $value) {?>
                        <option value="{{$value->id}}">{{$value->r_name}}</option>    
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
                        <option value="{{$value->id}}">{{$value->site_name}}</option>    
                    <?php } } ?>             
                </select>                
            </div>
        </div>    
    </div>
    <div class="row">
    <div class="col-md-6">  
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Employee ID')}}</label>
                <input required name="empid" value="{{(old('empid'))?old('empid'):randString(6)}}" type="text" class="form-control" >        
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
            <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="1" checked />
            <label class="form-check-label" for="exampleRadios1">
                {{__('Active')}}
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="0"  />
            <label class="form-check-label" for="exampleRadios12">
                {{__('Inactive')}}
            </label>
        </div>
    </div>
    </div>
    <input type="hidden" name="planguage" value="en">
    <?php /* <div class="col-md-6">  
            <div class="form-group">
                <label for="exampleInputEmail1">{{ __('Preferred Language') }}</label>
                <select class="form-control @error('planguage') is-invalid @enderror" required name="planguage">
                    <option value="">{{__('Select Language')}}</option>
                    <option <?php if(session('locale')=='es'){echo 'selected';}?> value="es">Spanish</option>
                    <option <?php if(session('locale')=='en'){echo 'selected';}?> value="en">English</option> 
                </select>                                 
            </div>            
    </div>  */?>
    <div class="col-md-12">  
        <button type="submit" class="btn btn-primary">{{__('Submit')}}</button> 
    </div>
</div>
    
    
</form>
</div>
@endsection
