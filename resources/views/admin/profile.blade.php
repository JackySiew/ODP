@extends('layouts.panel2')

@section('title')
 My Profile
@endsection

@section('content')
<div class="text-center">
  <div class="card col-md-6">
    <div class="card-header">
      <h4 class="card-title">My Profile</h4>
      <img src="{{url('storage/image/'.$user->profile)}}" width="200">
    </div>
    <div class="card-body text-left">
      <h3>Name: {{$user->name}}</h3>
      <h3>Email: {{$user->email}}</h3>
      <h3>Role: As {{$user->usertype}}</h3>
    </div>
    <div class="card-footer">
      <hr>
      <a href="{{url('aprofile-edit/'.$user->id)}}" class="btn btn-info">Edit</a>
    </div>
    <small>Last updated:{{$user->updated_at}}</small>
  </div>
</div>

@endsection

@section('scripts')
    
@endsection