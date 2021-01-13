@extends('layouts.panel')

@section('title')
   View Order Details
@endsection

@section('content')

<div class="panel col-md-5">
  <div class="panel-heading">
    <h3 class="panel-title">Order Details</h3>
    <a class="btn btn-info pull-right" href="{{url('orders')}}">Go Back</a>
  <small>Ordered Date: {{$orders->created_at}}</small>
</div>
  <div class="panel-body">
    <ul class="list-unstyled">
      <li><label for="Order Number">Order ID: </label> <p>{{$orders->order_number}}</p></li><hr>
      <li><label for="Grand Total">Grand Total: </label> <p>RM {{number_format($orders->grand_total,2)}}</p></li><hr>
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
      <li><label for="Address">Address: </label><p> {{$orders->address1}}, {{$orders->address2}}, {{$orders->postcode}} {{$orders->city}}, {{$orders->state}}</p></li><hr>
      <li><label for="Mobile">Mobile No.: </label> <p>{{$orders->mobile}}</p></li><hr>
      <li><label for="Remark">Remark*: </label> <p>
      @if ($orders->notes == "")
          None
      @else
      {{$orders->notes}}
      @endif
      </p>
      </li>
      <hr>
    </ul>     
  </div>
</div>

<div class="panel col-md-7">
  <div class="panel-heading">
    <h3 class="panel-title">Order Items</h3>
    <div class="right">
      <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
      <button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
    </div>
  </div>
  <div class="panel-body">
    <table class="table table-sm">
      <tr>
        <th>Product Image</th>
        <th>Description</th>
        <th>Amount</th>
        <th>Status</th>
      </tr>
      @foreach ($orderItems as $item)
      <tr>
        <td><img src="/storage/image/{{$item->prodImage}}" alt="Product Image" width="100"></td>
        <td>
          Product Name: {{$item->prodName}}<br>
          Qty: {{$item->quantity}}<br>
          Price per Unit: RM {{number_format($item->prodPrice,2)}} <br>
          {{-- Present By: {{$item->name}} --}}
        </td>
        <td>RM {{number_format($item->prodPrice * $item->quantity,2)}}</td>      
        <td>
          @if ($item->status == 'declined')
          <span class="badge bg-danger">{{$item->status}}</span>
          @elseif($item->status == 'completed')
          <span class="badge bg-success">{{$item->status}}</span>
          @else
          <span class="badge bg-warning">{{$item->status}}</span>    
          @endif
        </td>
      </tr>
      @endforeach

    </table>
  </div>
</div>

@endsection 