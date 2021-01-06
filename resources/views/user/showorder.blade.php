@extends('layouts.app')

@section('title')
   View Order Details
@endsection
@section('class')
    container
@endsection
@section('content')
<div class="row">
<div class="card col-md-12">
  <div class="card-header text-center">
    <h3 class="card-title">Order Details</h3>  <p><small>Ordered Date: {{$orders->created_at}}</small></p>
    <div class="pull-left">
      <a href="{{url('my-orders')}}" class="btn btn-primary"><< Go back</a>  
    </div>
    <div class="pull-right">
      <a href="{{url('invoice-pdf/'.$orders->id)}}" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Download PDF</a>  
    </div>
  </div>
  <div class="card-body">
    <ul class="list-unstyled">
      <li><label for="Order Number">Order ID: </label> <p>{{$orders->order_number}}</p></li><hr>
      <li><label for="Status">Status: </label> <p>{{$orders->status}}</p></li><hr>
      <li><label for="Grand Total">Grand Total: </label> <p>RM {{$orders->grand_total}}</p></li><hr>
      <li><label for="Item Count">Items: </label> 
        <table class="table table-responsive-sm">
          <tr>
              <th>Product Image</th>
              <th>Product Details</th>
              <th>Total Sum</th>
              <th>Status</th>
          </tr>
          @foreach ($orderItems as $item)
          <tr>
              <td><img src="/storage/image/{{$item->prodImage}}" alt="Product Image" width="100"></td>
              <td>
                  Product Id: {{$item->id}}<br>
                  Product Name: {{$item->prodName}}<br>
                  Qty: {{$item->quantity}} Unit(s)<br>
                  Price per Unit: RM {{$item->prodPrice}}
              </td>
              <td>
                  RM {{$item->quantity * $item->prodPrice}}
              </td>
              <td>{{$item->status}}</td>
          </tr>   
          @endforeach
      </table>            
      </li>
      <hr>
      <li><label for="IsPaid">Is Paid: </label> 
        <p class="text-white">         
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
      <li><label for="Address">Address: </label><p> {{$orders->address1}},{{$orders->address2}}, {{$orders->postcode}} {{$orders->city}}, {{$orders->state}}</p></li><hr>
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