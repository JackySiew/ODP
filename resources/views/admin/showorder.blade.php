@extends('layouts.panel')

@section('title')
   View Order Details
@endsection

@section('content')

<div class="panel col-md-6">
  <div class="panel-heading">
    <h3 class="panel-title">Order Details</h3>
    <a class="btn btn-info" href="{{url('aorders')}}">Go Back</a>
  <small>Ordered Date: {{$orders->created_at}}</small>
</div>
  <div class="panel-body">
    <ul class="list-unstyled">
      <li><label for="Order Number">Order ID: </label> <p>{{$orders->order_number}}</p></li><hr>
      <li><label for="Status">Status: </label> <p>
        @if ($orders->status == 'completed')
        <span class="badge bg-success">{{$orders->status}}</span>            
        @elseif ($orders->status == 'declined')
        <span class="badge bg-danger">{{$orders->status}}</span>            
        @else
        <span class="badge bg-warning">{{$orders->status}}</span>            
        @endif
      </p></li><hr>
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

<div class="panel col-md-6 ">
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
        <th>Status</th>
      </tr>
      @foreach ($orderItems as $item)
      <tr>
        <td><img src="/storage/image/{{$item->prodImage}}" alt="Product Image" width="100"></td>
        <td>
          Product Name: {{$item->prodName}}<br>
          Qty: {{$item->quantity}}<br>
          Price per Unit: RM {{$item->prodPrice}}
        </td>
        <td>RM {{$item->prodPrice * $item->quantity}}</td>      
      </tr>
      @endforeach

    </table>
  </div>
</div>

@endsection