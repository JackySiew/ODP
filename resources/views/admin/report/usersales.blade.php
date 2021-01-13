@extends('layouts.panel')

@section('title')
   Designer Sales Report
@endsection

@section('content')
<div class="panel col-md-12">
    <div class="panel-heading">
      @foreach ($designer as $user)    
        <h3> {{$user->name}}'s sales data</h3>
        <a href="{{url('user-sales-pdf/'.$user->id)}}" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Download PDF</a>  
        <a href="{{url('report')}}" class="btn btn-primary">Go back</a>
      @endforeach
    </div>
  <div class="panel-body">
    <table class="table table-bordered">
      <thead>
        <th>Total Orders</th>
        <th>Total Tasks</th>
        <th>Total Sales</th>
        <th>Total Income</th>
        <th>Payment Pending</th>
      </thead>
      <tbody>
        <tr>
          <td>
            @if (count($orders) > 0)
              {{$ordercompleted}} / {{count($orders) - $orderdeclined}} completed <br>
              ({{$orderdeclined}} declined)
            @else
              No order received
            @endif       
            </td>   
          <td>
            @if (count($tasks) > 0)
              {{$taskcompleted}} / {{count($tasks) - $taskdeclined}} completed <br>
              ({{$taskdeclined}} declined)
            @else
              No customize task received
            @endif       
          </td>   
          <td>RM {{number_format($totalSales,2)}}</td>
          <td>RM {{number_format($totalIncome,2)}}</td>
          <td>RM {{number_format($paymentPending,2)}}</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<div class="panel col-md-12">
  <div class="panel-heading">
    <h3>Order Description:</h3>
  </div>
  <div class="panel-body">
    <table id="dataTable" class="table table-responsive">
      <thead>
        <th>ID:</th>
        <th>Description:</th>
        <th>Status</th>
        <th>Action</th>
      </thead>
      @php $no = 1; @endphp

      <tbody>
        @foreach ($orders as $order)
            <tr>
              <td>{{$no++}}</td>
              <td>
                Order ID: {{$order->order_number}} <br>
                Item(s): {{$order->item_count}} <br>
                Pay by: {{$order->payment_method}}, 
                @if ($order->is_paid == true)
                <span class="badge bg-success">Is Paid</span>    
                @else
                <span class="badge bg-danger">Not Paid</span>    
                @endif <br>
                Ordered at: {{date('d-M-Y', strtotime($order->created_at))}}
              </td>
              <td>
                @if ($order->status == 'completed')
                <span class="badge bg-success">{{$order->status}}</span>            
                @elseif ($order->status == 'declined')
                <span class="badge bg-danger">{{$order->status}}</span>            
                @else
                <span class="badge bg-warning">{{$order->status}}</span>            
                @endif
              </td>
              <td><a href="{{url('aorder/'.$order->id)}}" class="btn btn-primary">View</a></td>
            </tr>
        @endforeach
      </tbody>
    </table>
    <br><br><br>
      <h3>Customize Task Description:</h3>
      <table id="dataTable2" class="table table-responsive">
      <thead>
        <th>ID:</th>
        <th>Description:</th>
        <th>Status</th>
        <th>Amount</th>
        <th>Action</th>
      </thead>
      @php $no = 1; @endphp

      @foreach ($tasks as $task)
      <tbody>
        <td>{{$no++}}</td>
        <td>
          Task ID: {{$task->custom_number}} <br>
          @if ($task->grand_total !=null)
            Fully Payment: 
            @if ($task->fully_paid == true)
            <span class="badge bg-success">Is Paid</span>    
            @else
            <span class="badge bg-danger">Not Paid</span>    
            @endif
            <br>
            Deposit: 
            @if ($task->deposit_paid == true)
            <span class="badge bg-success">Is Paid</span>    
            @else
            <span class="badge bg-danger">Not Paid</span>    
            @endif
            <br>
          @endif
          Deadline: {{$task->deadline}}
        </td>
        <td>
          @if ($task->status == 'completed')
          <span class="badge bg-success">{{$task->status}}</span>            
          @elseif ($task->status == 'declined')
          <span class="badge bg-danger">{{$task->status}}</span>            
          @else
          <span class="badge bg-warning">{{$task->status}}</span>            
          @endif
        </td>
        <td>
          @if ($task->grand_total == null)
          The price has not been set 
          @else
          RM {{number_format($task->grand_total,2)}}
          (Deposit: RM {{number_format($task->deposit,2)}})
          @endif
        </td>
        <td>
          <div class="btn-group">
            <p><a href="{{url('atask/'.$task->id)}}" class="btn btn-primary">View</a></p>
          </div>
        </td>
      </tbody>
      @endforeach

    </table>
  </div>
</div>
@endsection

@section('scripts')
    <script>
      $(document).ready( function () {
        $('#dataTable').DataTable();
        $('#dataTable2').DataTable();
      });
    </script>
@endsection