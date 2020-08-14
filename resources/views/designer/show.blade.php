@extends('layouts.panel')

@section('title')
 View Product
@endsection

@section('content')
<div class="text-center">
<div class="card col-md-6">
  <div class="card-header">
    <h4 class="card-title">Product Detail</h4>
    <img src="storage/image/{{$product->prodImage}}" width="100">
  <small>Created at: {{$product->created_at}}</small>
  </div>
  <div class="card-body text-left">
    <h3>Name: {{$product->prodName}}</h3>
    <h3>Description: {{$product->description}}</h3>
    <h3>Price: RM{{$product->prodPrice}}</h3>
  </div>
  <div class="card-footer">
    <hr>
    <a href="/products/{{$product->id}}/edit" class="btn btn-info">Edit</a>
    <a href="/products" class="btn btn-secondary">Go Back</a>
  </div>
  <small>Last updated:{{$product->updated_at}}</small>

</div>
</div>

@endsection

@section('scripts')
    
@endsection