@extends('layouts.dashboard')

@section('content')
<div class="gcspfullpagewapper">
  <form action="{{route('categorystore')}}" method="post" enctype="multipart/form-data">
    @csrf    
    <input type="hidden" name="parent_id" value="{{$parent_id}}">
    <div class="row">
        <?php if($parent_id==''){ ?>
        <div class="col-md-12">
            <div class="form-group">
                <label class="d-block" for="exampleInputEmail1">{{__('Category Type')}}</label>
                <?php foreach ($CategoryType as $key => $CT) {?>                   
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="type_id" id="exampleRadios{{$CT->ct_id}}" value="{{$CT->ct_id}}" />
                        <label class="form-check-label" for="exampleRadios{{$CT->ct_id}}">
                            {{__($CT->ct_name)}}
                        </label>
                    </div>
                <?php } ?>        
            </div>
        </div> 
        <?php }else{?>
        <input type="hidden" name="type_id" value="{{$type_id}}">    
        <?php } ?> 
        <div class="col-md-6">  
            <div class="form-group">
                <label for="exampleInputEmail1">{{__('Category name')}}</label>
                <input required name="category_name" value="{{ old('category_name') }}" type="text" class="form-control" >        
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
            </div>
            @error('cat_icon')
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
