@extends('layouts.app')
@section('title')
   Home Page
@endsection
@section('top')
    fixed-top
@endsection
@section('content')
 <div id="carouselExampleInterval" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active" data-interval="3000">
      <img src="storage/image/commercial1.jpg" class="d-block w-100" >
      <div class="carousel-caption d-none d-md-block bg-dark mb-5">
        <h1>Welcome to Online Designer Platform</h1>
      </div>
    </div>
    <div class="carousel-item" data-interval="3000">
      <img src="storage/image/commercial2.jpg" class="d-block w-100" >
      <div class="carousel-caption d-none d-md-block bg-dark mb-5">
        <h1>New package for Office Area</h1>
      </div>
    </div>
    <div class="carousel-item" data-interval="3000">
      <img src="storage/image/commercial3.jpg" class="d-block w-100" >
      <div class="carousel-caption d-none d-md-block bg-dark mb-5">
        <h1>Special promotion for Bedroom Design</h1>
      </div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleInterval" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleInterval" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<br>
<div class="container-fluid">
  <div class="card">
    <div class="row no-gutters">
      <div class="col-md-6">
        <img src="storage/image/commercial1.jpg" class="w-100">
      </div>
      <div class="col-md-6">
        <div class="card-body text-center w-50 h-25 mx-auto mt-5">
          <div class="card-title"><h1>Furniture</h1></div>
          <p class="card-text">Provide difference style of furniture.</p>
          <p class="card-text"><a href="#" class="btn btn-warning">Get More</a></p>
        </div>
      </div>
    </div>
  </div>
  <br>
<div class="panel panel-default">
  <div class="panel-header text-center">
    <h1>New arrival products</h1>
  </div>
<div class="card-deck">
  @foreach ($products as $product)
  <div class="card border-light col-md-3">
    <div class="card-body text-center">
      <img src="storage/image/{{$product->prodImage}}" class="w-100" height="200">
      @if ($product->prodPrice == 0)
      <p class="text-success"><b>For demo only</b></p>
      @else
      <p>Price: Rm{{$product->prodPrice}}</p>
      @endif    
    </div>
  </div>
  @endforeach
</div>      
</div>
  <br>
<div class="card">
  <div class="row no-gutters">
    <div class="col-md-6">
      <div class="card-body w-50 mx-auto text-center mt-5">
        <div class="card-title"><h1>Office Area</h1></div>
        <p class="card-text">The best employers bonding experience starts with having the best living space.</p>
        <p class="card-text"><a href="#" class="btn btn-warning">Get More</a></p>      
      </div>
    </div>
    <div class="col-md-6">
      <img src="storage/image/commercial2.jpg" class="w-100">
    </div>
  </div>
</div>
</div>

@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@endsection