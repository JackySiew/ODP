@extends('layouts.panel')

@section('title')
   My Orders
@endsection

@section('content')

<div class="panel col-md-12">
  <div class="panel-body">
    @if (session('status'))
    <div class="alert alert-success">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
      {{ session('status') }}
    </div>
    @endif

    <div class="table-responsive">
    @if (count($orders)>0)
    <table id="dataTable" class="table">
    <thead>
      <th>Id</th>
      <th>Order Number</th>
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
        <p>{{$order->order_number}}</p>
      </td>
      <td>
        {{$order->address}}, {{$order->postcode}} {{$order->city}}, {{$order->state}}
      </td>
      <td>
        {{$order->created_at}}
      </td>
      <td>
        @if ($order->status == 'declined')
        <div class="alert alert-danger">
        @elseif($order->status == 'processing')
        <div class="alert alert-warning">
        @elseif($order->status == 'completed')
        <div class="alert alert-success">
        @else
        <div class="alert ">
        @endif
          {{$order->status}}
        </div>
      </td>
      <td>
        <div class="btn-group">
        <a href="{{url('order/'.$order->id)}}" class="btn btn-primary">View</a><br>
          {{-- <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Change status
          </button>
          <div class="dropdown-menu">
            <li><a class="dropdown-item" href="{{url('update-order/'.$order->id)}}">Ready for shipment</a></li>
            <li><a class="dropdown-item" href="{{url('update-order/'.$order->id)}}">Order complete</a></li>
          </div> --}}
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
          swal({
          icon: 'success',
          title: 'The product has deleted!',
          buttons: true,
          }).then(function(value){
              window.location.href = url;
          });
        }
    });
});
</script>
@endsection