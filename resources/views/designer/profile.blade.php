@extends('layouts.panel')

@section('title')
 My Profile
@endsection

@section('content')
<div class="text-center">
  <div class="card col-md-6">
    @if (session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
    @endif

    <div class="card-header">
      <h4 class="card-title">My Profile</h4>
      <img src="{{url('/storage/image/'.$user->profileImage)}}" width="100">
    </div>
    <div class="card-body text-left">
      <h3>Name: {{$user->name}}</h3>
      <h3>Email: {{$user->email}}</h3>
      <h3>Phone: {{$user->phone}}</h3>
      <h3>Role: As {{$user->usertype}}</h3>
    </div>
    <div class="card-footer">
      <hr>
      <a href="{{url('profile-edit/'.$user->id)}}" class="btn btn-info">Edit</a>
    </div>
    <small>Last updated:{{$user->updated_at}}</small>
  </div>
</div>

@endsection

@section('scripts')
    
@endsection