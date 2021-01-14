@extends('layouts.panel')

@section('title')
  Product List
@endsection

@section('content')
<div class="panel col-md-12">
  <div class="panel-body">
    <div class="table-responsive">
    @if (count($products)>0)
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
        <p><h4>{!!$product->description!!}</h4></p>
      
      @if ($product->reviews()->count())
      <p>Rate: <i class="fa fa-star" style="color: #deb217"></i>{{ number_format($product->reviews()->avg('rating'), 2) }} / 5.00</p>
      <p>{{$product->reviews()->count()}} comment(s)</p>  
      @else
      <p>No one ratings</p>
      @endif
      </td>
        <td>
          <a href="{{url('prodlist/'.$product->id)}}" class="btn btn-info">View</a> 
        </td>
      </tr>
      @endforeach
    </tbody>
    </table>
    </div>

    @else
    <div class="text-center">
      <h1>There is no product upload</h1>
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
</script>
@endsection