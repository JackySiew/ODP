@extends('layouts.panel')

@section('title')
 Edit Profile
@endsection

@section('content')
<div class="text-center">
    <div class="card col-md-6 ">
    <div class="card-header">
        <h4 class="card-title">Edit Profile</h4>
    </div>
    <div class="card-body text-left ">
        <form action="{{url('profile-update/'.$user->id)}}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
        <img class="rounded mx-auto d-block" src="{{url('/storage/image/'.$user->profileImage)}}" width="100">
        <div class="form-group">    
            <label for="name">Name</label>
            <input class="form-control" name="name" type="text" value="{{$user->name}}">
        </div>                
        <div class="form-group">
            <label for="email">Email</label>
            <input class="form-control" name="email" type="text" value="{{$user->email}}">
        </div>
        <div class="form-group">
            <label for="phone">Phone No</label>
            <input class="form-control" name="phone" type="text" value="{{$user->phone}}">
        </div>
    <div class="card-footer">
        <div class="form-group">    
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{url('profile')}}" class="btn btn-secondary">Cancel</a>
        </form>

        </div>                
    </div>
    </div>
    </div>  
</div>

@endsection

@section('scripts')
    
@endsection