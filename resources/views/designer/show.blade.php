@extends('layouts.panel')

@section('title')
 View Product
@endsection

@section('content')
<div class="container">
  @foreach ($products as $product)
  <div class="card mb-3">
    <div class="row no-gutters">
      <div class="col-md-4 text-center">
        <img src="{{url('storage/image/'.$product->prodImage)}}" class="w-100" height="250">
      </div>
      <div class="col-md-6 offset-md-1">
        <div class="card-body">
          <h1 class="card-title">{{$product->prodName}}</h1>
          <p class="card-text"><label for="category">Category:</label><b class="text-warning"> {{$product->category_name}}</b></p>
          <p class="card-text">
            {!!$product->description!!}
          </p>
          @if ($product->prodPrice == 0)
          <p class="card-text text-danger"><b>For demo only</b></p>
          @else
          <h3>RM{{$product->prodPrice}}</h3>
          <br>
          @endif   
        </div>
       </div>
    </div>
  <a class="btn btn-secondary" href="{{url('products')}}">Go Back</a>
    @endforeach
  </div>
  <div class="card">
    <div class="card-header text-center"><h1>Comment</h1></div>
  
    <div class="card-body">
      <div class="container">
      @if (count($reviews)>0)
      @foreach ($reviews as $review)
      <div class="card mb-3">
        <div class="card-header" style="background-color: rgba(0,0,0,.09);">
          <h5>{{$review->name}}</h5>
        <small>{{date('d-m-Y', strtotime($review->created_at))}}</small>
        @if (Auth::user()->id == $review->user_id)
        <form action="{{url('review/delete/'.$review->id)}}" method="POST">
          @csrf
          @method('DELETE')
        <button type="submit" class="btn btn-danger pull-left"><i class="fa fa-trash"></i> Delete Comment</button>
        </form>
        @endif
          <div class="pull-right">
            @for ($i = 0; $i < $review->rating; $i++)
            <i class="fa fa-star" style="color: #deb217;"></i>
            @endfor
          </div>
        </div>
          <div class="card-body">
          <p>{{$review->comment}}</p>
        </div>
      </div>
    @endforeach
    
      @else
        <h3 class="text-center">No one rating yet.</h3>
      @endif
    </div>
  </div>
  </div> 
  
</div>

@endsection
