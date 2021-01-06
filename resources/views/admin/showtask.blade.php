@extends('layouts.panel')

@section('title')
   View Customize Request Details
@endsection

@section('content')

<div class="panel col-md-8">
  <div class="panel-heading">
    <h3 class="panel-title">Customize Task Details</h3>
    <a class="btn btn-info pull-right" href="{{url('products')}}">Go Back</a>

  <small>{{$task->created_at}}</small>
</div>
  <div class="panel-body">
    <ul class="list-unstyled">
      <li><label for="Order Number">ID: </label> <p>{{$task->custom_number}}</p></li><hr>
      <li><label for="Status">Status: </label> <p>{{$task->status}}</p></li><hr>
      <li><label for="IsPaid">Fully Payment: </label> 
        <p>         
          @if ($task->fully_paid == 0)
          <span class="badge bg-danger"> Not paid
          @else
          <span class="badge bg-success">  Paid
          @endif
        </span>
      </p>
      </li><hr>
      <li><label for="IsPaid">Deposit: </label> 
        <p>         
          @if ($task->deposit_paid == 0)
          <span class="badge bg-danger"> Not paid
          @else
          <span class="badge bg-success">  Paid
          @endif
        </span>
      </p>
      </li><hr>
      <li><label for="Name">Name: </label> <p>{{$task->fullname}}</p></li><hr>
      <li><label for="Address">Address: </label><p> {{$task->address}}, {{$task->postcode}} {{$task->city}}, {{$task->state}}</p></li><hr>
      <li><label for="Mobile">Mobile No.: </label> <p>{{$task->mobile}}</p></li><hr>
      <li><label for="description">Customize details: </label> <p>{!!$task->description!!}</p></li><hr>      

    </ul>     
  </div>
</div>

<div class="panel col-md-4">
  <div class="panel-heading">
    <h3 class="panel-title">Customize Items</h3>
    <div class="right">
      <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
      <button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
    </div>
  </div>
  <div class="panel-body">
    <table class="table table-responsive">
      <tr>
        <th>Product</th>
        <th>Qty</th>
      </tr>
      @foreach ($taskItems as $item)
      <tr>
        <td>{{$item->prodName}}</td>
        <td>{{$item->quantity}}</td>
      </tr>
      @endforeach

    </table>
  </div>
</div>

@endsection

@section('scripts')
    <script>
      $(document).ready( function () {
      $('#dataTable').DataTable();

      $('.order').click(function () {
            
           receiver_id = $(this).attr('id');
           $.ajax({
            type:"get",
            url:"order/"+receiver_id,
            cache:false,
            success: function (data) {
                $('#messages').html(data);
                scrollToBottom();
            }
           });
        });

      });
    </script>
@endsection