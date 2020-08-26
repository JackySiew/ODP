@extends('layouts.app')
    
@section('title')
@foreach ($products as $product)
     | {{$product->prodName}}
@endforeach
@section('class2')
    <div class="container">
@endsection

@endsection
@section('content')
@if (session('status'))
<div class="alert alert-success">
  {{ session('status') }}
</div>
@endif
<div class="panel panel-default text-center">
    <div class="panel-body">
        @foreach ($products as $product)
        <div class="col-md-4">
        <img src="{{url('storage/image/'.$product->prodImage)}}" class="w-100" height="250">
        </div>
        <div class="col-md-7 pull-right">
        <h1>{{$product->prodName}}</h1>
        <br>
        <div class="text-left">
            <p><label for="category">Category:</label><i class="text-warning"> {{$product->category_name}}</i></p>
            <br>
            <label for="description">Product Detail:</label>
            <p>{{$product->description}}</p>
            <br>
            @if ($product->prodPrice == 0)
            <p class="text-danger"><b>For demo only</b></p>
            @else
            <h1>Rm{{$product->prodPrice}}</h1>
            <br>
            @endif   
            
        </div> 
        <br>
        <div class="text-center">
            <a href="#"><button class="btn btn-lg btn-primary">Customize Request</button></a>
            @if ($product->prodPrice == 0)
            <a class="btn btn-lg btn-secondary" disabled>Add to cart</a>
            @else
            <a href="/add-cart/{{$product->id}}" class="btn btn-lg btn-success">Add to cart</a>
            @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection