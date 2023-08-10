@extends('layouts.dashboard')

@section('content')
<div class="gcspfullpagewapper">
<div class="gcspcategorywapper mb-5">
  <a class="btn btn-primary mb-3" href="{{route('categorycreate')}}" role="button"><i class="fa fa-plus" aria-hidden="true"></i> {{__('New')}}</a>
  <div class="tableboxshadow">
    <div class="tablepaddacc">
  <table width="100%" cellpadding="10" class="gcspctitletable">
    <tr>
      <th width="33%">{{__('Name')}}</th>
      <th width="33%">{{__('Type')}}</th>
      <th width="33%">{{__('Modified On')}}</th>
    </tr>
  </table>
</div>
  <div class="accordion" id="accordionExample">
    <div class="card">
      <?php
        $parentid=0;
        $count=count($Categories);
       foreach ($Categories as $key => $category) { ?>

        <?php if($parentid !=$category->parent_id && $parentid!=0){ ?>
          <li><a href="{{ route('subcategorycreate',['parent_id'=>$parentid])}}"><i class="fa fa-plus" aria-hidden="true"></i> {{__('Add Sub Category')}}</a></li>
        </ul></div></div>
      <?php } ?>  
      <?php if($category->id ==$category->parent_id){ ?>
        <div class="card-header" id="heading{{$category->parent_id}}" data-toggle="collapse" data-target="#collapse{{$category->parent_id}}" aria-expanded="true" aria-controls="collapse{{$category->parent_id}}">          
            <table width="100%" cellpadding="10" >
              <tr>
                <th width="33%" class="listarrowicon">{{$category->category_name}}
                  <a href="{{ route('categoryedit',['id'=>$category->id]) }}" class="ml-3"><i class="fa fa-edit"></i></a><a  href="{{ route('categorydelete',['id'=>$category->id]) }}" class="ml-3 gcspcategorydelete"><i class="fa fa-trash"></i></a>
                </th><th width="33%" class="gcspchangecolor">{{__($category->ct_name)}}</th>
                <th width="33%" class="gcspchangecolor">{{date('d M, Y',strtotime($category->updated_at))}}</th>
          </tr></table>
        </div>
      <?php } ?>

      <?php if($category->id ==$category->parent_id){  ?>
        <div id="collapse{{$category->parent_id}}" class="collapse" aria-labelledby="heading{{$category->parent_id}}" data-parent="#accordionExample">
          <div class="card-body1">
            <ul class="gcspcategortul">
            <?php }else{?>
              <li {{$category->id}}>{{$category->category_name}} <a href="{{ route('categoryedit',['id'=>$category->id]) }}" class="ml-3"><i class="fa fa-edit"></i></a><a href="{{ route('categorydelete',['id'=>$category->id]) }}" class="ml-3 gcspcategorydelete"><i class="fa fa-trash"></i></a></li>
            <?php }  ?> 

            <?php $parentid=$category->parent_id;
            if($count==($key+1)){?>
              <li><a href="{{ route('subcategorycreate',['parent_id'=> $parentid])}}"><i class="fa fa-plus" aria-hidden="true"></i> {{__('Add Sub Category')}}</a></li>
            <?php }

            ?>

          <?php  } ?>
        </div>
      </div>
    </div>
  </div>
</div>
    @endsection