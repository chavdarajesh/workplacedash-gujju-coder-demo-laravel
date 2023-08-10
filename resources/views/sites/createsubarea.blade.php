@extends('layouts.dashboard')

@section('content')
<div class="gcspfullpagewapper">
<form action="{{ route('postsubarea')}}" method="post">
    @csrf
    <input type="hidden" name="site_parent" value="{{$site_id}}">
    <input type="hidden" name="sub_parent" value="{{$sub_parent}}">
    <input type="hidden" name="site_type" value="{{$site_type}}">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">{{__($Field_name)}}</label>
                <input type="text" value="{{old('site_name')}}" name="site_name" required class="form-control" >        
            </div>
        </div>

        
        <div class="col-md-6">    
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Select head')}}</label>
                <select name="site_headofsafety[]" multiple required class="form-control multipleSelect" >
                    <option value="">{{__('Select')}}</option>
                    <?php 
                    foreach ($Users as $key => $value) {?>
                     <option value="{{$value->id}}">{{$value->name}}</option>
                 <?php } ?>
             </select>                
         </div>
     </div>    
     <div class="col-md-6">    
        <div class="form-group">
            <label for="exampleInputEmail1">{{__('Select supervisor')}}</label>
            <select name="site_supervisor" required class="form-control" >
                <option value="">{{__('Select')}}</option>
                <?php 
                foreach ($Users as $key => $value) {?>
                 <option value="{{$value->id}}">{{$value->name}}</option>
             <?php } ?>
         </select>                
     </div>
 </div> 
 <div class="col-md-6">    
    <div class="form-group"> 
    <label for="exampleInputEmail111">{{__('Status')}}</label> <br/>      
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="1"  checked />
            <label class="form-check-label" for="exampleRadios1">
                 {{__('Active')}}
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="0"  />
            <label class="form-check-label" for="exampleRadios2">
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
