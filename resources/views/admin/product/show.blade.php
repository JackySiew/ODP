@extends('layouts.panel')

@section('title')
 View Product
@endsection
@section('content')
  @foreach ($products as $product)
<div class="col-md-12">
  <div class="panel panel-headline">
    <div class="panel-heading">
      <h3 class="panel-title">{{$product->prodName}}</h3>
      <p class="panel-subtitle">Created at: {{date("d-M-Y", strtotime($product->created_at))}}</p>
    </div>
    <div class="panel-body">
      <div class="col-md-5">
        <img src="{{url('storage/image/'.$product->prodImage)}}" class="w-100" height="250">
      </div>
      <div class="col-md-6">
        <p class="panel-text"><label for="category">Category:</label><b class="text-warning"> {{$product->category_name}}</b></p>
        <p class="panel-text">
          {!!$product->description!!}
        </p>
        @if ($product->prodPrice == 0)
        <p class="panel-text text-danger"><b>For demo only</b></p>
        @else
        <label for="prodPrice">Price: </label> RM{{$product->prodPrice}}
        <br>
        @endif            
      </div>
      <a class="btn btn-info" href="{{url('prodlist')}}">Go Back</a>
    </div>
  </div>
</div>
  @endforeach
  <div class="col-md-12">
    <div class="panel panel-headline">
      <div class="panel-heading text-center">
        <h3 class="panel-title">Comments</h3>
      </div>
      <div class="panel-body">
        @if (count($reviews)>0)
        @foreach ($reviews as $review)
        <div class="panel mb-3">
          <div class="panel-header bg-primary">
            {{$review->name}}
            <div class="pull-right">
            @for ($i = 0; $i < $review->rating; $i++)
              <i class="fa fa-star" style="color:  #deb217;"></i>
            @endfor
            {{date("d-M-Y", strtotime($review->created_at))}}
            </div>
          </div>    
          <div class="panel-body">
            {{$review->comment}}
          </div>
        </div>
        @endforeach
        @else
        <h2>No one comment yet!</h2>
        @endif
      </div>
    </div>
  </div>
  
@endsection
