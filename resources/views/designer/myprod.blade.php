@extends('layouts.panel')

@section('title')
   My Product
@endsection

@section('content')

<div class="card col-md-12">
  <div class="card-body">

    <div class="table-responsive">
    @if (count($products)>0)
    <div class="text-center">
    <a href="{{route('products.create')}}" class="btn btn-warning">Add</a>
    </div>
    <table id="dataTable" class="table">
    <thead>
      <th>Id</th>
      <th>Product Image</th>
      <th>Product Detail</th>
      <th>Action</th>
    </thead>
    <tbody>
      @php $no = 1; @endphp
      @foreach ($products as $product)
      <tr>
      <input type="hidden" class="serdelete_val" value="{{$product->id}}">
      <td>{{$no++}}</td>
      <td>
        <img src="storage/image/{{$product->prodImage}}" width="250" height="150">
        <p>Last updated: {{$product->updated_at}}</p>
      </td>
      <td>
      <p><h4>{{$product->prodName}}</h4></p>
      @if ($product->reviews()->count())
      <p>Rate: <i class="fa fa-star" style="color: #deb217"></i>{{ number_format($product->reviews()->avg('rating'), 2) }} / 5.00</p>
      <p>{{$product->reviews()->count()}} comment(s)</p>  
      @else
      <p>No one ratings</p>
      @endif
      </td>
        <td>
          <a href="{{url('products/'.$product->id)}}" class="btn btn-info">View</a>
          <a href="{{url('products/'.$product->id.'/edit')}}" class="btn btn-info">Edit</a>
          <br>
          <br>
          <a href="{{url('products/delete/'.$product->id)}}" class="btn btn-danger delete-confirm"><i class="fa fa-trash">Delete</i></a>        
        </td>
      </tr>
      @endforeach
    </tbody>
    </table>
    </div>

    @else
    <div class="text-center">
      <h1>No product for now! =="</h1>
      <h3>Go and upload your own product now!</h3>  
      <a href="{{route('products.create')}}" class="btn btn-warning">Add</a>
      </div>  
    @endif
  </div>
</div>

@endsection

@section('scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
  $(document).ready( function () {
  $('#dataTable').DataTable();
  });

  $('.delete-confirm').on('click', function (event) {
    event.preventDefault();
    const url = $(this).attr('href');
    swal({
        title: 'Are you sure?',
        text: 'This record and it`s details will be permanantly deleted!',
        icon: 'warning',
        buttons: ["Cancel", "Yes!"],
    }).then(function(value) {
        if (value) {
            window.location.href = url;
        }
    });
});
</script>
@endsection