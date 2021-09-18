@extends('layouts.panel')

@section('title')
  Category List
@endsection

@section('content')
@if (session('status'))
<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
  <p>{{session('status')}}    
</p>
</div>
@endif

<div class="panel col-md-12">
  <div class="panel-body">
    <div class="table-responsive">
    @if (count($categories)>0)
    <table id="dataTable" class="table table-bordered">
    <thead>
      <th>Id</th>
      <th>Category Name</th>
      <th>Created At</th>     
      <th>Action</th>     
    </thead>
    <tbody>
      @php $no = 1; @endphp
      @foreach ($categories as $category)
      <tr>
      <td>{{$no++}}</td>
      <td>
        <p><b>{{$category->category_name}}</b></p>
        <p>Last updated: {{$category->updated_at}}</p>
      </td>
      <td>{{$category->created_at}}</td>
      <td>          
        <div class="row">
          <a href="{{url('categories/'.$category->id.'/edit')}}" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i></a>
          <a href="{{url('categories/delete/'.$category->id)}}" class="btn btn-sm btn-danger delete-confirm"><i class="fa fa-trash"></i></a>                      
        </div>
      </td>
      </tr>
      @endforeach
    </tbody>
    </table>
    </div>
    @else
    <div class="text-center">
      <h1>No category created</h1>
    </div>  
    @endif
  </div>
</div>

@endsection

@section('scripts')
<script>
  $(document).ready( function () {
  $('#dataTable').DataTable();
  });

    $('.delete-confirm').on('click', function (event) {
    event.preventDefault();
    const url = $(this).attr('href');
    swal({
        title: 'Are you sure?',
        text: 'This category will be permanantly deleted!',
        icon: 'warning',
        buttons: ["Cancel", "Yes!"],
    }).then(function(value) {
        if (value) {
          swal({
          icon: 'success',
          title: 'The category has deleted!',
          buttons: true,
          }).then(function(value){
              window.location.href = url;
          });
        }
    });
});

</script>
@endsection