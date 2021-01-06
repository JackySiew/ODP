@extends('layouts.panel')

@section('title')
   Report Results
@endsection

@section('content')

<a href="{{url('report')}}" class="btn btn-primary">Go back</a>

<div class="panel col-md-12">
    <div class="panel-heading">
        <h3> Results found in 
        @php
            if (isset($date)){
                echo $date;
            }
            else if(isset($month) && isset($year))
            {
                echo $month.', '.$year;
            }
            else{
               echo $year; 
            }
        @endphp
         = {{count($orders)}}
        </h3>
    </div>
  <div class="panel-body">
    <div class="table-responsive">
    @if (count($orders)>0)
    <table id="dataTable" class="table">
    <thead>
      <th>Id</th>
      <th>Order ID</th>
      <th>Shipping Address</th>
      <th>Order Date</th>
      <th>Amount</th>
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
        {{$order->grand_total}}
      </td>
      <td>
        <div class="alert alert-info">
          {{$order->status}}
        </div>
      </td>
      <td>
        <div class="btn-group">
        <a href="{{url('order/'.$order->id)}}" class="btn btn-primary">View</a><br>
        </div>
      </td>
    </tbody>
      @endforeach
    </table>
    <h3>Total Amount = RM {{$sum}}</h3>
    </div>

    @else
    <div class="text-center">
      <h1>No result found.</h1>
      </div>  
    @endif
  </div>
</div>

@endsection

@section('scripts')
    <script>
      $(document).ready( function () {
      $('#dataTable').DataTable();
      });
    </script>
@endsection