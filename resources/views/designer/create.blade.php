@extends('layouts.panel')

@section('title')
    Add Product
@endsection

@section('content')
<div class="text-center">
<div class="card col-md-8">
  <div class="card-header">
    <h4 class="card-title">Product Detail</h4>
  </div>
  <div class="card-body text-left">
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
    <label for="prodImage">Image</label>    
    <input type="file" name="prodImage" class="form-control-file">  

  <div class="form-group">
    <button type="submit" class="btn btn-primary">Submit</button>
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