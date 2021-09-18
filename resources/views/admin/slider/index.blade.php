@extends('layouts.panel')

@section('title')
Slider
@endsection

@section('content')
@if (session('status'))
<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
  <p>{{session('status')}}    
</p>
</div>
@endif
<div class="panel panel-headline">
  <div class="panel-heading">
    <h3 class="panel-title">Slider</h3>
    <a class="btn btn-primary float-right" href="{{route('slider.create')}}">Add Slide</a>

  </div>
  <div class="panel-body">
    <div class="table-responsive">
      <table id="dataTable" class="table table-bordered">
      <thead>
        <th>Id</th>
        <th>Slider Image</th>
        <th>Slider Detail</th>
        <th>Status</th>
        <th>Action</th>
      </thead>
      <tbody>
        @if (count($sliders)>0)
        @php $no = 1; @endphp
        @foreach ($sliders as $slider)
        <tr>
        <input type="hidden" class="serdelete_val" value="{{$slider->id}}">
        <td>{{$no++}}</td>
        <td>
          <img src="storage/slide/{{$slider->image}}" width="250" height="150">
          <p>Last updated: {{$slider->updated_at}}</p>
        </td>
        <td>
          <p><h4>{{$slider->heading}}</h4></p>
          <p><h4>{!!$slider->description!!}</h4></p>
          <p><a href="{{$slider->link}}" class="btn btn-info">{{$slider->link_name}}</a></p>
        </td>
        <td>
          @if ($slider->status == 1)
            <span class="badge bg-danger">Hidden</span>    
          @else
            <span class="badge bg-success">Visible</span>    
          @endif
        </td>
        <td>
          <a href="{{url('slider/'.$slider->id.'/edit')}}" class="btn btn-info"><i class="fa fa-pencil"></i></a> 
        </td>
        </tr>
        @endforeach
        @else
        <div class="text-center">
          <h1>There is no slider upload</h1>
        </div>  
        @endif
      </tbody>
      </table>
      </div>
    </div>
  </div>
</div>
@endsection
