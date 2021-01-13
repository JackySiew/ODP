@extends('layouts.app')
@section('title')
    {{$cateName}}
]@endsection
@section('class')
container
@endsection
@section('content')

@if (session('status'))
<div class="alert alert-success">
  {{ session('status') }}
</div>
@elseif (session('alert'))
<div class="alert alert-danger">
  {{ session('alert') }}
</div>
@endif

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{url('all-products')}}">Products</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$cateName}}</li>     
      </ol>
</nav>
<div class="row">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="list-group">
                @foreach ($categories as $category)
            <a href="{{url('all-products/category/'.$category->id)}}" class="list-group-item list-group-item-action">
                  {{$category->category_name}}
                </a>
                @endforeach
              </div>            
        </div>
        <div class="col-12 d-flex justify-content-center pt-5">
            {{$products->links()}}
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default text-center">
            <div class="panel-body">
                <div class="row col-md-12">
                    @foreach ($products as $product)
                    <div class="card border-warning col-md-4 mb-4">
                        <a href="{{url('product/'.$product->id)}}" class="text-decoration-none">
                        <h5><b>{{$product->prodName}}</b></h5>
                        <img src="{{url('/storage/image/'.$product->prodImage)}}" class="w-100" height="200">
                        </a>
                        <br>
                        <div class="card-body">
                        @if ($product->prodPrice == 0)
                        <p class="text-success"><b>For demo only</b></p>
                        @else
                        <p>Price: RM{{$product->prodPrice}}</p>
                        @endif 
                        @if ($product->reviews()->count())
                        <p>Rate: <i class="fa fa-star" style="color: #deb217"></i>{{ number_format($product->reviews()->avg('rating'), 2) }} / {{ number_format($product->reviews()->sum('rating'), 2) }}</p>
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