@extends('layouts.dashboard')

@section('content')
<div class="gcspfullpagewapper">
  <form action="{{route('rootcausestore')}}" method="post" enctype="multipart/form-data">
    @csrf    
    
    <div class="row">
        
        <div class="col-md-6">  
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Name')}}</label>
                <input required name="rc_name" value="{{ old('rc_name') }}" type="text" class="form-control" >        
            </div>
            @error('rc_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div> 
    </div>
    <div class="row">
        <div class="col-md-6">
            
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Description')}}</label>
                <textarea required name="rc_desctiption"  class="form-control">{{ old('rc_desctiption') }}</textarea>
            </div>
        
        </div>   
    </div> 

    <div class="row">
        
        <div class="col-md-6">
            <div class="form-group">        
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="rc_status" id="exampleRadios11" value="1" checked  />
            <label class="form-check-label" for="exampleRadios11">
                {{__('Active')}}
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="rc_status" id="exampleRadios1" value="0"  />
            <label class="form-check-label" for="exampleRadios1">
                {{__('Inactive')}}
            </label>
        </div>
    </div>
        </div> 
        
    </div>        
           
    
    

    
    
    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button> 
</form>
</div>
@endsection
