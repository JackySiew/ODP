@extends('layouts.panel')

@section('title')
   View Customize Request Details
@endsection

@section('content')

<div class="panel col-md-6">
  <div class="panel-heading">
    <h3 class="panel-title">Customize Task Details</h3>
    <a class="btn btn-info pull-right" href="{{url('atasks')}}">Go Back</a>

  <small>{{$task->created_at}}</small>
</div>
  <div class="panel-body">
    <ul class="list-unstyled">
      <li><label for="Order Number">Task ID: </label> <p>{{$task->custom_number}}</p></li><hr>
      <li><label for="Status">Status: </label><p>
        @if ($task->status == 'completed')
        <span class="badge bg-success">{{$task->status}}</span>            
        @elseif ($task->status == 'declined')
        <span class="badge bg-danger">{{$task->status}}</span>            
        @else
        <span class="badge bg-warning">{{$task->status}}</span>            
        @endif
        </p>
      </li>
      <hr>
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
      <li><label for="Address">Address: </label><p> {{$task->address1}}, {{$task->address2}}, {{$task->postcode}} {{$task->city}}, {{$task->state}}</p></li><hr>
      <li><label for="Mobile">Mobile No.: </label> <p>{{$task->mobile}}</p></li><hr>


    </ul>     
  </div>
</div>

<div class="panel col-md-6">
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
        <th>Image</th>
        <th>Description</th>
        <th>Request</th>
      </tr>
      @foreach ($taskItems as $item)
      <tr>
        <td><img src="/storage/image/{{$item->prodImage}}" alt="Product Image" width="100"></td>
        <td>
          Product Name: {{$item->prodName}}<br>
          Qty: {{$item->quantity}}<br>
          Price per Unit: RM {{$item->prodPrice}}
        </td>
        <td>{!!$item->request!!}</td>
      </tr>
      @endforeach

    </table>
  </div>
</div>

@endsection
