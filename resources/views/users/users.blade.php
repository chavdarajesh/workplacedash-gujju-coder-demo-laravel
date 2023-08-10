@extends('layouts.dashboard')

@section('content')
<div class="gcspfullpagewapper">
@if($cuser->can('User Add'))
<a class="btn btn-primary mb-3" href="{{route('userscreate')}}" role="button"><i class="fa fa-plus" aria-hidden="true"></i> {{__('New')}}</a>
@endif
@if($cuser->can('User Delete'))  
<a class="btn btn-primary mb-3" href="{{route('usersdeleted')}}" role="button"><i class="fa fa-trash-restore-alt" aria-hidden="true"></i> {{__('Deleted')}}</a>
@endif
<table class="table gcspmaintable" cellpadding="5" cellspacing="0">
  <thead>
    <tr>      
      <th scope="col">{{__('User Account Details')}}</th>
      <th scope="col" class="text-center">{{__('Verified')}}</th>
      <th scope="col" class="text-center">{{__('Permits')}}</th>
      <th scope="col" class="text-center">{{__('Incidents')}}</th>
      <th scope="col" class="text-center" width="100"></th>
    </tr>
  </thead>
  <tbody>
    <tr>      
      <td colspan="2" align="right">{{__('License Summary')}}</td>      
      <td class="text-center">({{CheckPermissionCount(9)}}/5)</td>
      <td class="text-center">({{CheckPermissionCount(5)}}/5)</td>
    </tr>
    <?php foreach ($Users as $key => $value) {?>
    <tr class="trhover">      
      <td align="left"><a href="<?php echo  route('getpermission',array('id'=>$value->id)); ?>"><b>{{$value->name}}</b><span class="d-flex">{{$value->r_name}} / {{$value->email}}
        </span></a></td>
      <td class="text-center" onclick="location.href='<?php echo  route('getpermission',array('id'=>$value->id)); ?>';">{{($value->email_verified_at!='')?__('Yes'):__('No')}}
        @if($value->email_verified_at=='')
        <a class="gcspresendlink" href="<?php echo  route('resendvarification',array('id'=>$value->id)); ?>">Resend</a>
        @endif
      </td>
      <td class="text-center" onclick="location.href='<?php echo  route('getpermission',array('id'=>$value->id)); ?>';">          
          {!! CheckPermission($value->id,$value->is_admin,9) !!}
      </td>
      <td class="text-center" onclick="location.href='<?php echo  route('getpermission',array('id'=>$value->id)); ?>';">
          {!! CheckPermission($value->id,$value->is_admin,5) !!}
      </td>
      <td class="text-center">
        @if($cuser->can('User Edit'))
          <a href="{{ route('usersedit',['id'=>$value->id]) }}" class="ml-3"><i class="fa fa-edit"></i></a>
        @endif
        @if($cuser->can('User Delete'))  
          <a href="{{ route('usersdelete',['id'=>$value->id]) }}" class="ml-3" onclick="return confirm('{{__('Are you sure you want to delete this user.')}}')"><i class="fa fa-trash"></i></a>
        @endif  
      </td>
    </tr>
    <?php }?>
    
    
    
  </tbody>
</table>
</div>
@endsection
