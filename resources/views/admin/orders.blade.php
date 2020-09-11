@extends('layouts.panel2')

@section('title')
   Order list
@endsection

@section('content')

<div class="card col-md-12">
  <div class="card-body">
    <div class="table-responsive">
    @if (count($orders)>0)
    <table id="dataTable" class="table">
    <thead>
      <th>Id</th>
      <th>Customer Details</th>
      <th>Orders</th>
      <th>Order Date</th>
      <th>Status</th>
    </thead>
    
      @php $no = 1; @endphp
      @foreach ($orders as $order)
      <tbody>
      <td>{{$no++}}</td>
      <td>
        <p>{{$order->user_name}}</p>
        {{$order->address}}
      </td>
      <td>
        @foreach ($order->cart->items as $item)
        <li>{{$item['item']['prodName']}} | {{$item['qty']}} unit(s)</li>
        @endforeach
      </td>
      <td>
        {{$order->created_at->format('d-M-y')}}
      </td>
      <td>
        @if ($order->status == 0)
        <div class="alert alert-danger">
          Order is under process
        </div>
        @elseif($order->status == 1)
        <div class="alert alert-info">
          Now shipping
        </div>
        @else
        <div class="alert alert-success">
          Order is complete
        </div>
        @endif
      </td>
    </tbody>
      @endforeach
    
    </table>
    </div>

    @else
    <div class="text-center">
      <h1>There is no orders for now! =="</h1>
      </div>  
    @endif
  </div>
</div>

@endsection

@section('scripts')
    <script>
      $(document).ready( function () {
    $('#dataTable').DataTable();
} );
    </script>
@endsection