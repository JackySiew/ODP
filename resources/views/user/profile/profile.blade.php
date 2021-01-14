@extends('layouts.app')
@section('title')
    My Profile
@endsection
@section('content')

<div class="container">
  @if (session('status'))
<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
  <p>{{session('status')}}    
</p>
</div>
@endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                  <b>My Profile</b>
                </div>

                <div class="card-body">
                  <div class="text-center">
                    <img src="{{'storage/image/'.$user->profile}}" class="img-thumbnail mb-5" alt="Avatar">
                  </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 text-md-right"><b>Name:</b></label>

                            <div class="col-md-6">
                              {{$user->name}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 text-md-right"><b>Email Address:</b></label>

                            <div class="col-md-6">
                              {{$user->email}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mobile" class="col-md-4 text-md-right"><b>Mobile No.:</b></label>

                            <div class="col-md-6">
                              {{$user->mobile}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="usertype" class="col-md-4 text-md-right"><b>Role as:</b></label>

                            <div class="col-md-6">
                              {{$user->usertype}}
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a href="{{url('my-profile-edit/'.$user->id)}}" class="btn btn-primary">Edit Profile</a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
