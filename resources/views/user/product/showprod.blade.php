@extends('layouts.app')
    
@section('title')
@foreach ($products as $product)
    {{$product->prodName}}
@endsection

@section('class')
container
@endsection

@section('extra-css')
<link rel="stylesheet" href="{{asset('css/star.css')}}">
@endsection

@section('content')
@if (session('status'))
<div class="alert alert-success">
  {{ session('status') }}
</div>
@endif
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
  <li class="breadcrumb-item" aria-current="page"><a href="{{url('all-products')}}">Products</a></li>
  <li class="breadcrumb-item active" aria-current="page">{{$product->prodName}}</li>
  </ol>
</nav>
@endforeach

@foreach ($products as $product)
<div class="card mb-5">
    <div class="row">
      <div class="col-md-4 text-center">
        <img src="{{url('storage/image/'.$product->prodImage)}}" class="img-fluid mb-3">
        @if ($product->reviews()->count())
        <p>Rate: <i class="fa fa-star" style="color: #deb217"></i>{{ number_format($product->reviews()->avg('rating'), 2) }} / 5.00</p>
        <p>{{$product->reviews()->count()}} comment(s)</p>  
        @else
        <p>No one ratings</p>
        @endif                       
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">
          Write Comment
        </button>
      </div>
      <div class="col-md-6 offset-md-1">
        <div class="card-body">
          <h1 class="card-title">{{$product->prodName}}</h1>
          <p class="card-text"><label for="category">Category:</label>    
            @foreach ($cates as $cate)
              <a href="{{url('all-products/category/'.$cate->category)}}" class="btn btn-rounded btn-warning">
              {{$cate->category_name}}
            </a>

            @endforeach
          </p>
          <p class="card-text">
            {!!$product->description!!}
          </p>
          @if ($product->prodPrice == 0)
          <p class="card-text text-danger"><b>For demo only</b></p>
          @else
          <h3>RM{{$product->prodPrice}}</h3>
          <br>
          @endif   
          <a href="{{url('customize/'.$product->id)}}" class="btn btn-lg btn-primary">Customize Request</a>
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Rating</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{url('review/comment')}}" method="POST" role="form">
          {{csrf_field()}}
              <div class="form-group row">
                <div class="rate col-md-8">
                  <input type="radio" id="rating10" name="rating" value="5" /><label for="rating10" title="5 stars"></label>
                  <input type="radio" id="rating8" name="rating" value="4" /><label for="rating8" title="4 stars"></label>
                  <input type="radio" id="rating6" name="rating" value="3" /><label for="rating6" title="3 stars"></label>
                  <input type="radio" id="rating4" name="rating" value="2" /><label for="rating4" title="2 stars"></label>
                  <input type="radio" id="rating2" name="rating" value="1" /><label for="rating2" title="1 star"></label>
                  <input type="radio" id="rating0" name="rating" value="0" /><label for="rating0" title="No star"></label>
                </div>
              </div>

          <div class="form-group row">
              <label for="comment">Comment(Optional)</label>
              <textarea name="comment" id="comment" class="form-control" rows="3"></textarea>
          </div>
          <input type="hidden" name="product_id" value="{{$product->id}}">
          <hr>
          <button type="submit" class="btn btn-primary pull-right">Send Comment</button>
          <button type="button" class="btn btn-secondary pull-right" data-dismiss="modal">Close</button>
      </div>
    </form>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header text-center"><h4>Comments</h4></div>
  <div class="card-body">
    @if (count($reviews)>0)
      @foreach ($reviews as $review)
      @guest
      <div class="container">
        <div class="card mb-3">
          <div class="card-header">
            {{$review->name}}
            <br>
            @for ($i = 0; $i < $review->rating; $i++)
              <i class="fa fa-star" style="color:  #deb217;"></i>
            @endfor
            {{$dt->createFromTimeStamp(strtotime($review->created_at))->diffForHumans()}}
          </div>    
          <div class="card-body">
            {{$review->comment}}
          </div>
        </div>
      </div>
      @else
      <div class="container">
          <div class="card mb-3">
            <div class="card-header">
              <div class="pull-left">
                {{$review->name}}
                <br>
                @for ($i = 0; $i < $review->rating; $i++)
                  <i class="fa fa-star" style="color:  #deb217;"></i>
                @endfor
                <br>
                {{$dt->createFromTimeStamp(strtotime($review->created_at))->diffForHumans()}}
              </div>
              @if (Auth::user()->id == $review->user_id)
            <form action="{{url('review/delete/'.$review->id)}}" method="POST">
              @csrf
              @method('DELETE')
            <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-trash"></i></button>
            </form>
            @endif    
            </div>    
            <div class="card-body">
              {{$review->comment}}
            </div>
          </div>
      </div>
      @endguest
      @endforeach
        
    @else
      <h3>No one comment yet.</h3>
    @endif
  </div>
</div>
@endsection