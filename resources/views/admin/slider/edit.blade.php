@extends('layouts.panel')

@section('title')
    Create Slide
@endsection

@section('content')
<div class="panel col-md-8 col-md-offset-2">
  <div class="panel-heading">
    <h3 class="panel-title text-center"><b>Slider Edit</b></h3>
  </div>
  <div class="panel-body text-left">
  <form action="{{route('slider.update',[$slider->id])}}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="form-group">
        <label for="heading">Heading</label>    
        <input type="text" name="heading" class="form-control" value="{{$slider->heading}}" >
    </div>
    <div class="form-group">
      <label for="description">Description</label>    
      <textarea class="ckeditor form-control" name="description">{!!$slider->description!!}</textarea>
    </div>
    <div class="form-group">
      <label for="link">Link</label>    
      <input type="text" name="link" class="form-control" value="{{$slider->link}}" >
    </div>
    <div class="form-group">
      <label for="link_name">Link Name</label>    
      <input type="text" name="link_name" class="form-control" value="{{$slider->link_name}}">
    </div>
    <div class="form-group">
      <label for="CurrentImg">Current Image</label>
    </div>
    <div class="form-group">
      <img src="{{url('storage/slide/'.$slider->image)}}" width="250" height="200">
    </div>
    <br>
    <div class="form-group">
      <label for="image">Slide Image</label>    
      <input type="file" name="image" class="form-control-file" id="image" onchange="loadFile(event)">  
      <img id="output" width="250" height="200">      
    </div>
    <div class="form-group">
      <label for="status">Status</label>    
      <input type="checkbox" name="status" {{$slider->status == '1' ? 'checked':''}}> 0=visible, 1=hidden  
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{url('slider')}}" class="btn btn-secondary">Cancel</a>
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
  var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
  };
</script>
@endsection