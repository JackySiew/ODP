@extends('layouts.panel')

@section('title')
    Edit Product
@endsection

@section('content')
<div class="text-center">
<div class="card col-md-8">
  <div class="card-header">
    <h4 class="card-title">Product Detail</h4>
  </div>
@foreach ($products as $product)
    
  <img class="rounded mx-auto d-block" src="{{url('/storage/image/'.$product->prodImage)}}" width="150">

<div class="card-body text-left">
  {!! Form::open(['action' => ['ProductController@update', $product->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
  <div class="form-group">
    {{Form::label('prodName','Product Name')}}
    {{Form::text('prodName',$product->prodName, ['class' => 'form-control', 'placeholder' => 'Product Name.....'])}}
  </div>
  <div class="form-group">
    {{Form::label('category','Category:')}}
    <select name="category" class="form-control">
    <option value="{{$product->category}}">{{$product->category_name}}</option>
    @foreach ($category as $cat)
    <option value="{{$cat->id}}">{{$cat->category_name}}</option>    
    @endforeach
    </select>
    {{-- {{Form::select('category',$categories, null, ['class' => 'form-control'])}} --}}
  </div>
  <div class="form-group">
    {{Form::label('description','Description')}}
    {{Form::textarea('description',$product->description, ['id' => 'editor', 'class' => 'form-control', 'placeholder' => 'Product Details.....'])}}
  </div>
  <div class="form-group">
    {{Form::label('prodPrice','Price')}}
    {{Form::number('prodPrice',$product->prodPrice, ['class' => 'form-control', 'placeholder' => 'Product Name.....','step' => '0.10','max'=>'10000', 'min' => '0'] )}}
  </div>
    {{Form::label('prodImage','Product Image(If want Replace)')}}
    {{Form::file('prodImage')}}
    @endforeach
  <div class="card-footer">
  <div class="form-group">
    <hr>
    {{Form::hidden('_method', 'PUT')}}
    {{Form::submit('Edit Product', ['class' => 'btn btn-primary'])}}
    <a href="{{url('products')}}" class="btn btn-secondary">Cancel</a>
  </div>
  </div>
  {!! Form::close() !!}
  </div>
</div>
</div>
@endsection

@section('scripts')
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'editor' );
</script>
@endsection