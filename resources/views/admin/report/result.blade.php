@extends('layouts.panel')

@section('title')
   Report Results
@endsection

@section('content')


<div class="panel col-md-12">
    <div class="panel-heading">
        <h3> Order sales results found in 
        @php
            if (isset($date)){
              $link = date('Y/m/d', strtotime($date));
                echo $date;
            }
            else if(isset($month) && isset($year))
            {
                $link = $year.'/'.$month;
                echo date('F', strtotime($month)).', '.$year;
            }
            else{
              $link = $year;
               echo $year; 
            }
        @endphp
         = {{count($orders)}}
        </h3>
        <a href="{{url('sales-pdf/'.$link)}}" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Download PDF</a>  
        <a href="{{url('report')}}" class="btn btn-primary">Go back</a>

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
      <th>Order Status</th>
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
        RM {{$order->grand_total}}
      </td>
      <td>
        @if ($order->status == 'completed')
        <div class="alert" style="background-color: rgb(27, 153, 27);color: white;">
          {{$order->status}}
        </div>
        @elseif ($order->status == 'declined')
        <div class="alert" style="background-color: rgb(231, 39, 39);color: white;">
          {{$order->status}}
        </div>
        @elseif ($order->status == 'processing')
        <div class="alert" style="background-color: rgb(226, 172, 23);color: white;">
          {{$order->status}}
        </div>
        @else
        <div class="alert" style="background-color: rgb(221, 154, 29);color: white;">
          {{$order->status}}
        </div>
        @endif
      </td>
      <td>
        <div class="btn-group">
        <a href="{{url('aorder/'.$order->id)}}" class="btn btn-primary">View</a><br>
        </div>
      </td>
    </tbody>
      @endforeach
    </table>
    <h3 class="text-right">Total Amount = RM {{$sum}}</h3>
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