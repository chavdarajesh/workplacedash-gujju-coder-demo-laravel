@extends('layouts.dashboard')

@section('content')
<div class="gcspfullpagewapper">
  <form action="{{route('rootcauseupdate')}}" method="post" enctype="multipart/form-data">
    @csrf    
    <input type="hidden" name="rc_id" value="{{ $RootCause->rc_id }}">
    <div class="row">
        
        <div class="col-md-6">  
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Name')}}</label>
                <input required name="rc_name" value="{{ $RootCause->rc_name }}" type="text" class="form-control" >        
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
                <textarea required name="rc_desctiption"  class="form-control">{{ $RootCause->rc_desctiption }}</textarea>
            </div>        
        </div>   
    </div> 
    <div class="row">        
        <div class="col-md-6">
            <div class="form-group">        
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="rc_status" id="exampleRadios11" value="1" {{ ($RootCause->rc_status==1)?'checked':'' }}  />
            <label class="form-check-label" for="exampleRadios11">
                {{__('Active')}}
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="rc_status" id="exampleRadios1" value="0" {{ ($RootCause->rc_status==0)?'checked':'' }}  />
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
