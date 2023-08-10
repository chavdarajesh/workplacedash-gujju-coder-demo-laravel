@extends('layouts.dashboard')

@section('content')
<div class="gcspfullpagewapper">
  <form action="{{route('rootcauseupdatesub')}}" method="post" enctype="multipart/form-data">
    @csrf    
    <input type="hidden" name="rci_id" value="{{ $RootCauseItem->rci_id }}">
    <input type="hidden" name="rci_rc_id" value="{{ $RootCauseItem->rci_rc_id }}">
    <div class="row">        
        <div class="col-md-6">  
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Name')}}</label>
                <input required name="rci_name" value="{{ $RootCauseItem->rci_name }}" type="text" class="form-control" >        
            </div>
            @error('rci_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div> 
    </div>    
    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button> 
</form>
</div>
@endsection
