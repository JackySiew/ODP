@extends('layouts.panel')

@section('title')
    Category Edit
@endsection

@section('content')
<div class="panel col-md-8 col-md-offset-2">
  <div class="panel-heading">
    <h3 class="panel-title text-center"><b>Category Creation</b></h3>
  </div>
  <div class="panel-body text-left">
    @foreach ($category as $cat)
    <form action="{{route('categories.update',[$cat->id])}}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('PUT')}}
    <div class="form-group">
        <label for="prodName">Category Name</label>    
        <input type="text" name="category_name" class="form-control" required value="{{$cat->category_name}}">
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{url('categories')}}" class="btn btn-secondary">Cancel</a>
    </div>
    </form>  
  @endforeach
</div>
@endsection