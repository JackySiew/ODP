@extends('layouts.panel')

@section('title')
    Create Category
@endsection

@section('content')
<div class="panel col-md-8 col-md-offset-2">
  <div class="panel-heading">
    <h3 class="panel-title text-center"><b>Category Creation</b></h3>
  </div>
  <div class="panel-body text-left">
  <form action="{{route('categories.store')}}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group">
        <label for="prodName">Category Name</label>    
        <input type="text" name="category_name" class="form-control" placeholder="Category Name....." required>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{url('categories')}}" class="btn btn-secondary">Cancel</a>
    </div>
  </form>  
</div>
@endsection