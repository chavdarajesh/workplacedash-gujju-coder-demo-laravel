@extends('layouts.dashboard')

@section('content')
<div class="gcspfullpagewapper">
  <form action="{{route('rootcausestoresub')}}" method="post" enctype="multipart/form-data">
    @csrf    
    
    <div class="row">
        <input type="hidden" name="rci_rc_id" value="{{$rci_rc_id}}">
        <input type="hidden" name="rci_parent_id" value="{{$parent_id}}">
        <div class="col-md-6">  
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Name')}}</label>
                <input required name="rci_name" value="{{ old('rci_name') }}" type="text" class="form-control" >        
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
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="rci_status" id="exampleRadios11" value="1" checked  />
            <label class="form-check-label" for="exampleRadios11">
                {{__('Active')}}
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="rci_status" id="exampleRadios1" value="0"  />
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
