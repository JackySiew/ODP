@extends('layouts.panel')

@section('title')
 Users
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="panel">
        <div class="panel-heading">
          <h4 class="panel-title">Users Table</h4>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table" id="dataTable">
              <thead class=" text-primary">
                <th>Name</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Status</th>
                <th>Action</th>
              </thead>
              <tbody>
                <tr>
                  @foreach ($users as $user)
                  <td>{{$user->name}}</td>
                  <td>{{$user->usertype}}</td>
                  <td>{{$user->created_at}}</td>

                  @if ($user->active == 1)
                      <td><div class="btn btn-success">Active</div></td>
                  @else 
                      <td><div class="btn btn-danger">Locked</div></td> 
                  @endif
                <td><a class="btn btn-info pull-left" href="{{url('users-edit/'.$user->id)}}"><i class="fa fa-pencil"></i></a>
                  <form action="{{url('user-delete/'.$user->id)}}" method="POST">
                    {{ csrf_field() }}  
                    {{ method_field('DELETE') }}
      
                  <input type="hidden" value="{{$user->id}}">
                    <a href="{{url('user-delete/'.$user->id)}}" class="btn btn-danger delete-confirm"><i class="fa fa-trash"></i></a>
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <script>
  $(document).ready( function () {
    $('#dataTable').DataTable();
  });

  $('.delete-confirm').on('click', function (event) {
    event.preventDefault();
    const url = $(this).attr('href');
    swal({
        title: 'Are you sure?',
        text: 'This record and it`s details will be permanantly deleted!',
        icon: 'warning',
        buttons: ["Cancel", "Yes!"],
    }).then(function(value) {
        if (value) {
            window.location.href = url;
        }
    });
});

  </script>
@endsection