@extends('layouts.app')
@section('title')
    All Products
@endsection
@section('class')
container
@endsection
@section('content')

@if (session('status'))
<div class="alert alert-success">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
  {{ session('status') }}
</div>
@elseif (session('alert'))
<div class="alert alert-danger">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
  {{ session('alert') }}
</div>
@endif
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/designers') }}">Designers</a></li>
        @foreach ($designer as $user)
        <li class="breadcrumb-item active" aria-current="page">{{$user->name}}</li>
        @endforeach
      </ol>
</nav>
<div class="row">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-body">
            @foreach ($designer as $user)
                <img src="/storage/image/{{$user->profile}}" class="img-thumbnail img-circle" alt="Avatar">
                <br>
                <h3 class="name mb-3">{{$user->name}}</h3>
                <p><b>Email:</b> {{$user->email}}</p>
                <p><b>Mobile:</b> {{$user->mobile}}</p>
                <div class="profile-info mt-5">
                  <h4 class="heading">About</h4>
                  <p>Interactively fashion excellent information after distinctive outsourcing.</p>
                </div>
                <br>
                <h3>Social</h3>
                    <a href="#" class="facebook-bg"><i class="fa fa-facebook"></i> {{$user->name}}</a><br>
                    <a href="#" class="twitter-bg"><i class="fa fa-twitter"></i> {{$user->name}}</a><br>
                    <a href="#" class="google-plus-bg"><i class="fa fa-google-plus"></i>{{$user->name}}</a><br>
                    <a href="#" class="github-bg"><i class="fa fa-github"></i>{{$user->name}}</a><br>
            @endforeach

            </div>
        </div>
    </div>
    <div class="col-md-8 offset-md-1">
        <div class="panel panel-default text-center">
            <div class="panel-body">
                <div class="row col-md-12">
                    @foreach ($products as $product)
                    <div class="card border-warning col-md-4 mb-3">
                        
                        <a href="{{url('product/'.$product->id)}}" class="text-decoration-none">
                        <h5><b>{{$product->prodName}}</b></h5>
                        <img src="{{url('/storage/image/'.$product->prodImage)}}" class="w-100" height="170">
                        </a>
                        <br>
                        <div class="card-body">
                        @if ($product->prodPrice == 0)
                        <p class="text-success"><b>For demo only</b></p>
                        @else
                        <p>Price: RM{{$product->prodPrice}}</p>
                        @endif 
                        @if ($product->reviews()->count())
                        <p>Rate: <i class="fa fa-star" style="color:#deb217;"></i>{{ number_format($product->reviews()->avg('rating'), 2) }} / 5.00</p>
                        <p>{{$product->reviews()->count()}} comment(s)</p>  
                        @else
                        <p>No one ratings</p>
                        @endif                       
                         @if ($product->prodPrice != 0)
                        <a href="{{url('add-cart/'.$product->id)}}" class="btn btn-lg btn-success">Add to cart</a>
                        @endif            
                        </div>
                    </div>  
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection