@extends('layouts.panel')

@section('title')
    Edit Product
@endsection

@section('content')
<div class="text-center">
<div class="panel col-md-8 col-md-offset-2">
  <div class="panel-header">
    <h4 class="panel-title">Product Detail</h4>
  </div>
@foreach ($products as $product)
    
  <img src="{{url('/storage/image/'.$product->prodImage)}}" width="150">

<div class="panel-body text-left">
<form action="{{route('products.update',[$product->id])}}" method="POST" enctype="multipart/form-data">
  {{ csrf_field() }}
  {{ method_field('PUT') }}
<div class="form-group">
    <label for="prodName">Product Name</label>    
    <input type="text" name="prodName" class="form-control" placeholder="Product Name....." value="{{$product->prodName}}" >
  </div>
  <div class="form-group">
    <label for="category">Category</label>    
    <select name="category" class="form-control">
    <option value="{{$product->category}}">{{$product->category_name}}</option>
    @foreach ($category as $cat)
    <option value="{{$cat->id}}">{{$cat->category_name}}</option>    
    @endforeach
    </select>
  </div>
  <div class="form-group">
    <label for="description">Description</label>    
  <textarea class="ckeditor form-control" name="description">{{$product->description}}</textarea>
  </div>
  <div class="form-group">
    <label for="prodPrice">Price</label>    
  <input type="number" class="form-control" name="prodPrice" value="{{$product->prodPrice}}" step="1.00" max="10000" min="0.00" required>
  </div>
    @endforeach
    <label for="prodImage">Image(If want to replace)</label>    
    <input type="file" name="prodImage" class="form-control-file">  
<div class="form-group">
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{url('products')}}" class="btn btn-secondary">Cancel</a>
  </div>

</form>  
</div>
</div>
</div>
@endsection

@section('scripts')
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
      $('.ckeditor').ckeditor();
  });
</script>
@endsection