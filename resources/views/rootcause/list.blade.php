@extends('layouts.dashboard')

@section('content')
<div class="gcspfullpagewapper">
<div class="gcspcategorywapper mb-5">
  @if($cuser->can('Root Cause Add'))
  <a class="btn btn-primary mb-3" href="{{route('rootcauselistcreate',['rc_id'=>$rc_id])}}" role="button"><i class="fa fa-plus" aria-hidden="true"></i> {{__('Add New Type')}}</a>
  @endif
  <div class="tableboxshadow">
    <div class="tablepaddacc">
  <table width="100%" cellpadding="10" class="gcspctitletable">
    <tr>
      <th >{{__('Name')}}</th>      
    </tr>
    @if(count($RootCauseItem)==0)
    <tr>
      <th  class="text-danger">{{__('No Root Cause Item Found')}}.</th>      
    </tr>
    @endif
  </table>
</div>
  <div class="accordion" id="accordionExample">
    <div class="card">
      <?php
        $parentid=0;
        $count=count($RootCauseItem);
       foreach ($RootCauseItem as $key => $RootCause_Item) { ?>
        <?php if($parentid !=$RootCause_Item->rci_parent_id && $parentid!=0){ ?>
          @if($cuser->can('Root Cause Add'))
          <li><a href="{{route('rootcauselistsubcreate',['rc_id'=>$rc_id,'parent_id'=>$parentid])}}"><i class="fa fa-plus" aria-hidden="true"></i> {{__('Add New Sub Type')}}</a></li>
          @endif
        </ul></div></div>
      <?php } ?>  
      <?php if($RootCause_Item->rci_id ==$RootCause_Item->rci_parent_id){ ?>
        <div class="card-header" id="heading{{$RootCause_Item->rci_parent_id}}" data-toggle="collapse" data-target="#collapse{{$RootCause_Item->rci_parent_id}}" aria-expanded="true" aria-controls="collapse{{$RootCause_Item->rci_parent_id}}">          
            <table width="100%" cellpadding="10" >
              <tr>
                <th width="33%" class="listarrowicon">{{$RootCause_Item->rci_name}}
                  @if($cuser->can('Root Cause Edit'))
                  <a href="{{route('rootcauseeditsub',['rci_id'=>$RootCause_Item->rci_id])}}" class="ml-3"><i class="fa fa-edit"></i></a>
                  @endif
                  @if($cuser->can('Root Cause Delete'))
                  <a onclick="return confirm('Are you sure you want to delete this?')" href="{{route('rootcausedeletesub',['rc_id'=>$RootCause_Item->rci_rc_id,'rci_id'=>$RootCause_Item->rci_id])}}" class="ml-3 "><i class="fa fa-trash"></i></a>
                  @endif
                </th>                
          </tr></table>
        </div>
      <?php } ?>

      <?php if($RootCause_Item->rci_id ==$RootCause_Item->rci_parent_id){  ?>
        <div id="collapse{{$RootCause_Item->rci_parent_id}}" class="collapse" aria-labelledby="heading{{$RootCause_Item->rci_parent_id}}" data-parent="#accordionExample">
          <div class="card-body1">
            <ul class="gcspcategortul">
            <?php }else{?>
              <li {{$RootCause_Item->rci_id}}>{{$RootCause_Item->rci_name}} 
                @if($cuser->can('Root Cause Edit'))
                <a href="{{route('rootcauseeditsub',['rci_id'=>$RootCause_Item->rci_id])}}" class="ml-3"><i class="fa fa-edit"></i></a>
                @endif
                @if($cuser->can('Root Cause Delete'))
                <a onclick="return confirm('Are you sure you want to delete this?')" href="{{route('rootcausedeletesub',['rc_id'=>$RootCause_Item->rci_rc_id,'rci_id'=>$RootCause_Item->rci_id])}}" class="ml-3 "><i class="fa fa-trash"></i></a>
                @endif
              </li>
            <?php }  ?> 

            <?php $parentid=$RootCause_Item->rci_parent_id;
            if($count==($key+1)){?>
              @if($cuser->can('Root Cause Add'))
              <li><a href="{{route('rootcauselistsubcreate',['rc_id'=>$rc_id,'parent_id'=>$parentid])}}"><i class="fa fa-plus" aria-hidden="true"></i> {{__('Add New Sub Type')}}</a></li>
              @endif
            <?php }
            ?>
          <?php  } ?>
        </div>
      </div>
    </div>
  </div>
</div>
    @endsection