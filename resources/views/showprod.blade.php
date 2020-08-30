@extends('layouts.app')
    
@section('title')
@foreach ($products as $product)
    {{$product->prodName}}
@endforeach
@section('class')
container
@endsection

@endsection
@section('content')
@if (session('status'))
<div class="alert alert-success">
  {{ session('status') }}
</div>
@endif
@foreach ($products as $product)
<div class="card mb-3">
    <div class="row no-gutters">
      <div class="col-md-4 text-center">
        <star-rating :border-width="3"></star-rating>
        <img src="{{url('storage/image/'.$product->prodImage)}}" class="w-100" height="250">
        <h2>Comments</h2>
        <form action="{{route('review.store')}}" method="POST" role="form">
            {{csrf_field()}}
            <div class="form-group">
                <label for="rate">Rate It</label>
                <select name="rating" id="rating">
                  <option value="">Please Rate</option>
                  @for ($i = 0; $i <= 5; $i++)
                <option value="{{$i}}">{{$i}}</option>
                  @endfor
                </select>
            </div>
            <div class="form-group">
                <label for="comment">Comment</label>
                <input type="text" class="form-control" name="comment" id="comment">
            </div>
            <input type="hidden" name="product_id" value="{{$product->id}}">
            <input type="submit" class="btn btn-primary" value="Comment">
        </form>
      </div>
      <div class="col-md-6 offset-md-1">
        <div class="card-body">
          <h1 class="card-title">{{$product->prodName}}</h1>
          <p class="card-text"><label for="category">Category:</label>    <a href="{{url('all-products/category/'.$product->category)}}" class="btn btn-rounded btn-warning">{{$product->category_name}}</a></p>
          <p class="card-text">
            {!!$product->description!!}
          </p>
          @if ($product->prodPrice == 0)
          <p class="card-text text-danger"><b>For demo only</b></p>
          @else
          <h3>RM{{$product->prodPrice}}</h3>
          <br>
          @endif   
          <a href="#"><button class="btn btn-lg btn-primary">Customize Request</button></a>
          @if ($product->prodPrice == 0)
          <a class="btn btn-lg btn-secondary" disabled>Add to cart</a>
          @else
          <a href="{{url('add-cart/'.$product->id)}}" class="btn btn-lg btn-success">Add to cart</a>
          @endif
        </div>
       </div>
    </div>
</div>
@endforeach

<div class="panel panel-default text-center">
    <div class="panel-header"><h1>Comment</h1></div>
    <div class="panel-body">
        <ul>
            @foreach ($reviews as $review)
                <li>{{$review->rating}} {{$review->comment}}</li>
            @endforeach        
        </ul>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/vue-star-rating/dist/star-rating.min.js"></script>
@endsection