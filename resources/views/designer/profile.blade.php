@extends('layouts.panel')

@section('title')
 My Profile
@endsection

@section('content')
<div class="text-center">
  <div class="card col-md-6">
    <div class="card-header">
      <h3 class="card-title">My Profile</h3>
      <img src="{{url('storage/image/'.$user->profile)}}" width="200">
    </div>
    <div class="card-body text-left">
      <h4>Name: {{$user->name}}</h4>
      <h4>Email: {{$user->email}}</h4>
      <h4>Role: As {{$user->usertype}}</h4>
    </div>
    <div class="card-footer">
      <hr>
      <a href="{{url('profile-edit/'.$user->id)}}" class="btn btn-info">Edit</a>
    </div>
    <small>Last updated:{{$user->updated_at}}</small>
  </div>
</div>

@endsection
