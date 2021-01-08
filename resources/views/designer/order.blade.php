@extends('layouts.panel')

@section('title')
   My Orders
@endsection

@section('content')

<div class="panel col-md-12">
  <div class="panel-heading">
    <h3 class="panel-title">Ordering data</h3>
  </div>
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
      <th>Order ID</th>
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
        {{$order->address1}}, {{$order->address2}}, {{$order->postcode}} {{$order->city}}, {{$order->state}}
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
        <a href="{{url('order/'.$order->id)}}" class="btn btn-primary">View</a><br>
          @if ($order->status == 'pending')
          <br>
          <button class="btn btn-success deliver" id="{{$order->id}}">Ready to deliver</button>                     
          @endif
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
  $('.deliver').on('click', function (event) {
        event.preventDefault();
        id = $(this).attr('id');
        swal({
              title: 'Are you sure?',
              text: 'The status will be inform the customer and unable to change!',
              icon: 'warning',
              buttons: ["Cancel", "Yes!"],
          }).then(function(value) {
              if (value) {
                swal({
                icon: 'success',
                buttons: true,
                }).then(function(value){
                  window.location = 'order-deliver/'+id;
                });
              }
          });
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