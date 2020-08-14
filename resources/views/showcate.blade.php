@extends('layouts.app2')
@section('title')
@foreach ($products as $product)
| {{$product->category_name}}
@endsection

@section('content')
@if (session('status'))
<div class="alert alert-success">
  {{ session('status') }}
</div>
@endif

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="/all-products">Products</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$product->category_name}}</li>     
        @endforeach
      </ol>
</nav>
<div class="row">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="list-group">
                @foreach ($categories as $category)
                <a href="/all-products/category/{{$category->id}}" class="list-group-item list-group-item-action">
                  {{$category->category_name}}
                </a>
                @endforeach
              </div>            
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default text-center">
            <div class="panel-body">
                <div class="card-deck">
                    @foreach ($products as $product)
                    <div class="card col-md-4 border-warning">
                        <a href="/product/{{$product->id}}" class="text-decoration-none">
                        <h3><b>{{$product->prodName}}</b></h3>
                        <img src="/storage/image/{{$product->prodImage}}" class="w-100" height="200">
                        </a>
                        <br>
                        <div class="card-body">
                        @if ($product->prodPrice == 0)
                        <p class="text-danger"><b>For demo only</b></p>
                        @else
                        <p>Price: Rm{{$product->prodPrice}}</p>
                        @if ($product->quantity== 0)
                        <p class="text-danger"><b>Out of Stock!</b></p>
                        @else
                        <p>Quantity: {{$product->quantity}}</p>
                        @endif
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