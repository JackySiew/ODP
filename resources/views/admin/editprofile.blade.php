@extends('layouts.panel2')

@section('title')
 Edit Profile
@endsection

@section('content')
<div class="text-center">
    <div class="panel col-md-6 col-md-offset-3">
    <div class="panel-header">
        <h4 class="panel-title">Edit Profile</h4>
    </div>
    <div class="panel-body">
        <form action="{{url('aprofile-update/'.$user->id)}}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
        <img class="img-thumbnail img-circle" src="/storage/image/{{$user->profile}}"  width="200">
        <div class="text-left">
        <div class="form-group">    
            <label for="name">Name</label>
            <input class="form-control" name="name" type="text" value="{{$user->name}}">
        </div>                
        <div class="form-group">
            <label for="email">Email</label>
            <input class="form-control" name="email" type="text" value="{{$user->email}}">
        </div>
        <div class="form-group">
            <label for="mobile">Mobile No.:</label>
            <input class="form-control" name="mobile" type="text" value="{{$user->mobile}}">
        </div>
            <label for="profile">Profile (If want to replace)</label>    
            <input type="file" name="profile" class="form-control">  
        <div class="panel-footer">
        <div class="form-group">    
            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{url('profile')}}" class="btn btn-secondary">Cancel</a>
        </div>    
        </div>            
    </form>
    </div>
    </div>
    </div>  
</div>

@endsection

@section('scripts')
    
@endsection