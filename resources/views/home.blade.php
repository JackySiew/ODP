@extends('layouts.app')
@section('title')
   Home Page
@endsection
@section('class')
    fixed-top
@endsection
@section('content')
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Wrapper for slides -->
    <div class="carousel-inner">

      <div class="item active">
        <img src="storage/image/commercial1.jpg" class="d-block w-100" >
        <div class="carousel-caption mb-5 bg-dark">
          <h1>Welcome to the Online Designer Platform</h1>
          <p>We provide a variety of design products for your reference.</p>
        </div>
      </div>

      <div class="item">
        <img src="storage/image/commercial2.jpg" alt="Chicago" class="d-block w-100">
        <div class="carousel-caption mb-5 bg-dark">
          <h1>Office Package</h1>
          <p>More office makeover option</p>
        </div>
      </div>
    
      <div class="item">
        <img src="storage/image/commercial3.jpg" alt="Chicago" class="d-block w-100">
        <div class="carousel-caption mb-5 bg-dark">
          <h1>Bedroom Package</h1>
          <h1>New Special Offer</h1>
        </div>
      </div>
  
    </div>

    <!-- Left and right controls -->
    <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
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
          <div class="card-title display-1">Furniture</div>
          <p class="card-text">Provide difference style of furniture.</p>
          <p class="card-text"><a href="#" class="btn btn-warning">Get More</a></p>
        </div>
      </div>
    </div>
  </div>
  <br>
<div class="panel panel-default">
  <div class="panel-header text-center">
    <div class="display-1">New arrival products</div>
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
        <div class="card-title display-1">Office Area</div>
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