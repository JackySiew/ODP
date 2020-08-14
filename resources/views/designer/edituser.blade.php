@extends('layouts.panel')

@section('title')
 Dashboard
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"></h4>
        </div>
        <div class="card-body">
          <form action="/user-update/{{$users->id}}" method="POST">
              {{ csrf_field() }}
              {{ method_field('PUT') }}
            <div class="form-group">    
                <label for="name">Name</label>
                <input class="form-control" name="name" type="text" value="{{$users->name}}">
            </div>                
            <div class="form-group">
                <label for="role">Role</label>
                <select name="usertype" class="form-control">
                <option value="designer">Designer</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
                </select>
            </div>
            <div class="form-group">    
                <button type="submit" class="btn btn-success">Update</button>
                <a href="/users" class="btn btn-secondary">Cancel</a>
            </div>                

          </form>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('scripts')
    
@endsection