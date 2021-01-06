@extends('layouts.panel')

@section('title')
    Add Product
@endsection

@section('content')
<div class="panel col-md-8 col-md-offset-2">
  <div class="panel-heading">
    <h3 class="panel-title text-center"><b>Product Details</b></h3>
  </div>
  <div class="panel-body text-left">
  <form action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
  <div class="form-group">
    <label for="prodName">Product Name</label>    
    <input type="text" name="prodName" class="form-control" placeholder="Product Name....." required>
  </div>
  <div class="form-group">
    <label for="category">Category</label>    
    <select name="category" id="category" class="form-control"required>
    @foreach ($category as $cat)
    <option value="{{$cat->id}}">{{$cat->category_name}}</option>    
    @endforeach
  </select>
  </div>
  <div class="form-group">
    <label for="description">Description</label>    
    <textarea class="ckeditor form-control" name="description"></textarea>
  </div>
  <div class="form-group">
    <label for="prodPrice">Price</label>    
    <input type="number" class="form-control" name="prodPrice" value="0.00" step="1.00" max="10000" min="0.00" required>
  </div>
  <div class="form-group">
    <label for="prodImage">Image</label>    
    <input type="file" name="prodImage" class="form-control-file">  
  </div>
  <div class="form-group">
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="{{url('products')}}" class="btn btn-secondary">Cancel</a>
  </div>

  </form>  
</div>

@endsection

@section('scripts')
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>
  $(document).ready(function () {
      $('.ckeditor').ckeditor();
  });
</script>
@endsection