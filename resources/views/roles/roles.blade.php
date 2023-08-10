@extends('layouts.dashboard')

@section('content')
<div class="gcspfullpagewapper">
<table class="table gcspmaintable" style="max-width: 60%;">
  <thead>
    <tr>      
      <th scope="col" class="border-top-0">{{__('Name')}}</th>
      <th scope="col" class="border-top-0">{{__('Users')}}</th>      
    </tr>
  </thead>
  <tbody>
    <?php foreach ($Roles as $key => $value) {?>
      <tr>      
      <td>{{$value->r_name}}
        @if($cuser->can('Roles Edit'))
          <a href="{{ route('rolesedit',['id'=>$value->id]) }}" class="ml-3"><i class="fa fa-edit"></i></a>
        @endif
        @if($cuser->can('Roles Delete'))
          <a href="{{ route('rolesdelete',['id'=>$value->id]) }}" class="ml-3"><i class="fa fa-trash"></i></a>
        @endif
      </td>
      <td>{{$value->users_count}}</td>      
    </tr>      
    <?php } ?>    
  </tbody>
</table>
@if($cuser->can('Roles Add'))
<button type="button" onclick="window.location.href='{{ route('rolescreate') }}'"  class="btn btn-primary">+ {{__('New Role')}}</button>
@endif

</div>
@endsection
