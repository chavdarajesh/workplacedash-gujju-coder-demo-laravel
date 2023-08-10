@extends('layouts.dashboard')

@section('content')
<div class="gcspfullpagewapper">
@if($cuser->can('User Add'))
<a class="btn btn-primary mb-3" href="{{route('universalusers')}}" role="button"><i class="fa fa-list" aria-hidden="true"></i> {{__('Users')}}</a>
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
      <td align="left"><b>{{$value->name}}</b><span class="d-flex">{{$value->r_name}} / {{$value->email}}
        </span></td>
      <td class="text-center" >{{($value->email_verified_at!='')?__('Yes'):__('No')}}</td>
      <td class="text-center" >          
          {!! CheckPermission($value->id,$value->is_admin,9) !!}
      </td>
      <td class="text-center" >
          {!! CheckPermission($value->id,$value->is_admin,5) !!}
      </td>
      <td class="text-center">        
        @if($cuser->can('User Delete'))  
          <a href="{{ route('universalusersrestore',['id'=>$value->id]) }}" class="ml-3" onclick="return confirm('{{__('Are you sure you want to restore this user.')}}')"><i class="fa fa-trash fa-trash-restore-alt"></i></a>
        @endif  
      </td>
    </tr>
    <?php }?>
    
    
    
  </tbody>
</table>
</div>
@endsection
