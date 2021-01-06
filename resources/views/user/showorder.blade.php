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
      <li><label for="Order Number"><b>Order ID:</b> </label> {{$orders->order_number}}</li><hr>
      <li><label for="Status"><b>Status:</b> </label> {{$orders->status}}</li><hr>
      <li><label for="Grand Total"><b>Grand Total:</b> </label> RM {{$orders->grand_total}}</li><hr>
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
      <li>
        <label for="Payment"><b>Payment status:</b> </label> 
        @if ($orders->is_paid == false)
          <span class="badge bg-danger text-white"> Unpaid</span>

          @else
          <span class="badge bg-success text-white"> Is Paid</span><br>
          @endif
          <label for="Payment Method"><b>Pay by:</b> </label> <span class="badge badge-primary"><i class="fa fa-{{$orders->payment_method}}"></i>{{$orders->payment_method}}</span>
      </li><hr>
      <li>
        <label for="Customer Details"><b><u>Customer Details</u></b></label>
        <br>
        <br>
        <li><label for="Name"><b>Name:</b> </label> {{$orders->fullname}}</li>
        <li><label for="Address"><b>Address:</b> </label> {{$orders->address1}},{{$orders->address2}}, {{$orders->postcode}} {{$orders->city}}, {{$orders->state}}</li>
        <li><label for="Mobile"><b>Mobile No:</b> </label> {{$orders->mobile}}</li>
        
        
        
      </li>
      <hr>
      <li><label for="Remark"><b>Remark*:</b> </label>
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