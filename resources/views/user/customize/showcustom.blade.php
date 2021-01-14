@extends('layouts.app')

@section('title')
   View Customize Request Details
@endsection
@section('class')
    container
@endsection
@section('content')
<div class="row">
<div class="card col-md-12">
  <div class="card-header text-center">
    <h3 class="card-title">Customize Request Details</h3>  <p><small>Order at: {{$custom->created_at}}</small></p>
    <div class="pull-left">
      <a href="{{url('my-customize')}}" class="btn btn-primary"><< Go back</a>  
    </div>
  </div>
  <div class="card-body">
    <ul class="list-unstyled">
      <li><label for="Order Number"><b>Customize ID:</b> </label> {{$custom->custom_number}}</li><hr>
      <li><label for="Status"><b>Status:</b></label> {{$custom->status}}</li><hr>
      <li><label for="Item Count"><b>Items:</b> </label> 
        <table class="table table-responsive-sm">
          <tr>
              <th>Product Image</th>
              <th>Product Details</th>
              <th>Requirement</th>
          </tr>
          @foreach ($customItems as $item)
          <tr>
              <td><img src="/storage/image/{{$item->prodImage}}" alt="Product Image" width="100"></td>
              <td>
                  Product Id: {{$item->id}}<br>
                  Product Name: {{$item->prodName}}<br>
                  Qty: {{$item->quantity}} Unit(s)<br>
              </td>
              <td>{!! $item->request !!}</td>
          </tr>   
          @endforeach
      </table>            
      </li>
      <li>
        @if ($custom->grand_total != NULL)
        <li><label for="price"><b>Total Price:</b></label> RM {{$custom->grand_total}}</li>
        <li><label for="deposit"><b></b></label> RM {{$custom->deposit}}</li>
        @endif
        <li><label for="FullyPaid"><b>Fully Payment:</b></label> 
        @if ($custom->fully_paid == false)
            <span class="badge badge-danger">Not Paid</span>
        @else
        <span class="badge badge-success">Is Paid</span>
        @endif
        </li>
        <li><label for="DepositPaid"><b>Deposit:</b></label>
          @if ($custom->deposit_paid == false)
          <span class="badge badge-danger">Not Paid</span>
          @else
          <span class="badge badge-success">Is Paid</span>
          @endif
        </li>
      </li>
      <hr>
      <b><u>Customer Details</u></b>
      <br>
      <br> 
      <li><label for="Name"><b>Name:</b> </label> {{$custom->fullname}}</li>
      <li><label for="Address"><b>Address:</b> </label> {{$custom->address1}}, {{$custom->address2}}, {{$custom->postcode}} {{$custom->city}}, {{$custom->state}}</li>
      <li><label for="Mobile"><b>Mobile No:</b> </label> {{$custom->mobile}}</li>
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