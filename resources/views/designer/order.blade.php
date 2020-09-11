@extends('layouts.panel')

@section('title')
   My Orders
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
    @if (count($orders)>0)
    <table id="dataTable" class="table">
    <thead>
      <th>Id</th>
      <th>Customer Details</th>
      <th>Orders</th>
      <th>Order Date</th>
      <th>Status</th>
      <th>Action</th>
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
          You haven't prepare for it
        </div>
        @elseif($order->status == 1)
        <div class="alert alert-info">
          Now shipping
        </div>
        @else
        <div class="alert alert-success">
          Shipped
        </div>
        @endif
      </td>
      <td>
        <div class="btn-group">
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Change status
          </button>
          <div class="dropdown-menu">
            <a class="dropdown-item bg-info text-white" href="#">Ready for shipment</a>
            <a class="dropdown-item bg-success text-white" href="#">Order complete</a>
          </div>
        </div>
      </td>
    </tbody>
      @endforeach
    
    </table>
    </div>

    @else
    <div class="text-center">
      <h1>You don't have any order for now! =="</h1>
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