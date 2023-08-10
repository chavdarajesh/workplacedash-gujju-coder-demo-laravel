@extends('admin.layouts.admin')

@section('content')
<h2>Users</h2>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Email</th>      
      <th scope="col">Company name</th>      
    </tr>
  </thead>
  <tbody>
   @foreach($users as $users_value)
    <tr>
      <th scope="row">{{$users_value->id}}</th>
      <td>{{$users_value->name}}</td>
      <td>{{$users_value->email}}</td>
      <td>{{$users_value->companyname}}</td>
    </tr>        
   @endforeach 
  </tbody>
</table>   
@endsection
