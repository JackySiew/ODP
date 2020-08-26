@extends('layouts.panel2')

@section('title')
 Users
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Users Table</h4>
          @if (session('status'))
            <div class="alert alert-success">
              {{ session('status') }}
            </div>
          @endif
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
              <thead class=" text-primary">
                <th>Name</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Action</th>
              </thead>
              <tbody>
                <tr>
                  @foreach ($users as $user)
                  <td>{{$user->name}}</td>
                  <td>{{$user->phone}}</td>
                  <td>{{$user->usertype}}</td>
                  <td>{{$user->created_at}}</td>
                <td><a class="btn btn-info text-white pull-left" href="{{url('users-edit/'.$user->id)}}">Edit</a>
                  <form action="{{url('user-delete/'.$user->id)}}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
      
                  <input type="hidden" value="{{$user->id}}">
                    <button class="btn btn-danger text-white pull-left">Delete</button>
                  </form>
                  </td>
                </tr> 
                  @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('scripts')
    
@endsection