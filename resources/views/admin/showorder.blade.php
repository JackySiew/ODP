@extends('layouts.panel')

@section('title')
   View Order Details
@endsection

@section('content')

<div class="panel col-md-8">
  <div class="panel-heading">
    <h3 class="panel-title">Order Details</h3>
    <a class="btn btn-info pull-right" href="{{url('products')}}">Go Back</a>

  <small>Ordered Date: {{$orders->created_at}}</small>
</div>
  <div class="panel-body">
    <ul class="list-unstyled">
      <li><label for="Order Number">ID: </label> <p>{{$orders->order_number}}</p></li><hr>
      <li><label for="Status">Status: </label> <p>{{$orders->status}}</p></li><hr>
      <li><label for="Grand Total">Grand Total: </label> <p>RM {{$orders->grand_total}}</p></li><hr>
      <li><label for="IsPaid">Is Paid: </label> 
        <p>         
          @if ($orders->is_paid == 0)
          <span class="badge bg-danger"> Not paid
          @else
          <span class="badge bg-success">  Paid
          @endif
        </span>
      </p>
      </li><hr>
      <li><label for="Payment Method">Payment Method: </label> <p>{{$orders->payment_method}}</p></li><hr>
      <li><label for="Name">Name: </label> <p>{{$orders->fullname}}</p></li><hr>
      <li><label for="Address">Address: </label><p> {{$orders->address}}, {{$orders->postcode}} {{$orders->city}}, {{$orders->state}}</p></li><hr>
      <li><label for="Mobile">Mobile No.: </label> <p>{{$orders->mobile}}</p></li><hr>
      <li><label for="Remark">Remark*: </label> <p>
      @if ($orders->notes == "")
          None
      @else
      {{$orders->notes}}
      @endif
    </p>
      </li><hr>

    </ul>     
  </div>
</div>

<div class="panel col-md-4">
  <div class="panel-heading">
    <h3 class="panel-title">Order Items</h3>
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
        <th>Amount</th>
      </tr>
      @foreach ($orderItems as $item)
      <tr>
        <td>{{$item->prodName}}</td>
        <td>{{$item->quantity}}</td>
        <td>RM {{$item->price * $item->quantity}}</td>      
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