@extends('layouts.panel')

@section('title')
  Ordering Data
@endsection

@section('content')

<div class="panel col-md-12">
  <div class="panel-heading">
    <h3 class="panel-title">Ordering data</h3>
  </div>
  <div class="panel-body">
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
      <th>Order Description</th>
      <th>Shipping Address</th>
      <th>Order Date</th>
      <th>Status</th>
      <th>Action</th>
    </thead>
    
      @php $no = 1; @endphp
      @foreach ($orders as $order)
      <tbody>
      <td>{{$no++}}</td>
      <td>
        {{$order->order_number}}
      </td>
      <td>
        {{$order->address1}},<br> {{$order->address2}},<br> {{$order->postcode}} {{$order->city}}, {{$order->state}}
      </td>
      <td>
        {{$order->created_at}}
      </td>
      <td>
        @if ($order->status == 'completed')
        <span class="badge bg-success">{{$order->status}}</span>            
        @elseif ($order->status == 'declined')
        <span class="badge bg-danger">{{$order->status}}</span>            
        @else
        <span class="badge bg-warning">{{$order->status}}</span>            
        @endif
      </td>
      <td>
        <div class="btn-group">
        <a href="{{url('aorder/'.$order->id)}}" class="btn btn-primary">View</a><br>
        </div>
      </td>
    </tbody>
      @endforeach
    </table>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Order Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
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
      });
    </script>
@endsection