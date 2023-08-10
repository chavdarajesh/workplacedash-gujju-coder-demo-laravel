@extends('layouts.dashboard')

@section('content')
<div class="gcspfullpagewapper">
  <form action="{{route('categoryupdate')}}" method="post" enctype="multipart/form-data">
    @csrf    
   
    <input type="hidden" name="id" value="{{ $Category->id }}">
    <div class="row">
        <div class="col-md-6">  
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Category name')}}</label>
                <input required name="category_name" value="{{ $Category->category_name }}" type="text" class="form-control" >        
            </div>
            @error('category_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div> 
        <div class="col-md-12">  
            <div class="form-group">
                <label class="gcspfileinputlable" for="fileinput">{{__('Select Icon')}}</label>
                <input  name="cat_icon" id="fileinput" value="{{ old('cat_icon') }}" type="file" class="form-control" > 
                <?php if($Category->cat_icon){                   
                 ?>       
                    <img width="75" src="{{url('storage/'.$Category->cat_icon)}}">
                <?php } ?>    
            </div>
            @error('cat_icon')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>        
    
    

    <div class="form-group"></div>    
    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button> 
</form>
</div>
@endsection
