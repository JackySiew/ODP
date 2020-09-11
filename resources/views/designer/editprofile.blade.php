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
        <form action="{{url('profile-update/'.$user->id)}}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
        <img class="rounded mx-auto d-block" src="{{url('/storage/image/'.$user->profile)}}"  width="200">
        <div class="form-group">    
            <label for="name">Name</label>
            <input class="form-control" name="name" type="text" value="{{$user->name}}">
        </div>                
        <div class="form-group">
            <label for="email">Email</label>
            <input class="form-control" name="email" type="text" value="{{$user->email}}">
        </div>
            <label for="profile">Profile (If want to replace)</label>    
            <input type="file" name="profile" class="form-control-file">  
        <div class="card-footer">
        <div class="form-group">    
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{url('profile')}}" class="btn btn-secondary">Cancel</a>
        </div>                
    </form>
    </div>
    </div>
    </div>  
</div>

@endsection

@section('scripts')
    
@endsection