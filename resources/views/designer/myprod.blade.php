@extends('layouts.panel')

@section('title')
   My Product
@endsection

@section('content')

<div class="card col-md-12">
  <div class="card-body">
    @if (session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
    @endif

    <div class="table-responsive">
    @if (count($products)>0)
    <div class="text-center">
    <a href="{{url('products/create')}}" class="btn btn-warning">Add</a>
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
      <td>{{$no++}}</td>
      <td>
        <p><img src="storage/image/{{$product->prodImage}}" width="150"></p> 
        <p>Created at: {{$product->created_at}}</p> 
      </td>
      <td>
      <p><b>{{$product->prodName}}</b></p>
      <p class="text-primary">{{$product->category_name}}</p>
      <p>Detail: {!!$product->description!!}</p>
      @if ($product->prodPrice == 0)
        <p class="text-success"><b>For demo only</b></p>
      @else
      <p>Price: Rm{{$product->prodPrice}}</p>
      @endif
      <p>Last updated: {{$product->updated_at}}</p>
      </td>
        <td>
          {{-- <a href="/products/{{$product->id}}" class="btn btn-info">View</a> --}}
          <a href="{{url('products/'.$product->id.'/edit')}}" class="btn btn-info">Edit</a>
          <br>
          <br>
          {!! Form::open(['action' => ['ProductController@destroy', $product->id], 'method' => 'POST']) !!}
           {{ Form::hidden('_method', 'DELETE') }}
           {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
   
          {!! Form::close() !!}
        </td>
      </tr>
      @endforeach
    </tbody>
    </table>
    </div>

    @else
    <h1 class="text-center">No product for now! =="</h1>
    @endif
  </div>
</div>

<nav class="fixed-bottom text-center">
  <a href="{{url('products/create')}}" class="btn btn-warning">Add</a>
</nav>
  
  
@endsection

@section('scripts')
    <script>
      $(document).ready( function () {
    $('#dataTable').DataTable();
} );
    </script>
@endsection