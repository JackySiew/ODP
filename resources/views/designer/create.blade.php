@extends('layouts.panel')

@section('title')
    Add Product
@endsection

@section('content')
<div class="text-center">
<div class="card col-md-6">
  <div class="card-header">
    <h4 class="card-title">Product Detail</h4>
  </div>
  <div class="card-body text-left">
  {!! Form::open(['action' => 'ProductController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
  <div class="form-group">
    {{Form::label('prodName','Product Name')}}
    {{Form::text('prodName','', ['class' => 'form-control', 'placeholder' => 'Product Name.....'])}}
  </div>
  <div class="form-group">
    {{Form::label('category','Category')}}
    <select name="category" id="category" class="form-control">
    @foreach ($category as $cat)
    <option value="{{$cat->id}}">{{$cat->name}}</option>    
    @endforeach
  </select>
  </div>
  <div class="form-group">
    {{Form::label('description','Description')}}
    {{Form::textarea('description','', ['class' => 'form-control', 'placeholder' => 'Product Details.....'])}}
  </div>
  <div class="form-group">
    {{Form::label('prodPrice','Price')}}
    {{Form::number('prodPrice','0.00', ['class' => 'form-control', 'placeholder' => 'Product Name.....','step' => '0.10','max'=>'10000', 'min' => '0'] )}}
  </div>
    {{Form::file('prodImage')}}
  <div class="form-group">
    {{Form::submit('Create Product', ['class' => 'btn btn-primary'])}}
    <a href="/products" class="btn btn-secondary">Go Back</a>
  </div>

{!! Form::close() !!}
  </div>
</div>
</div>
@endsection