<!DOCTYPE html>
<html lang="en  ">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>      
    <h3 class="text-center mb-5">{{$designer}}'s sales report</h3>

<img src="{{asset('assets/img/logo.png')}}" alt="Logo">
<br>
<p>
    No. 99, Jalan Contoh 12,<br>
    Taman Pasulan,<br>
    81300 Skudai, Johor
</p>
<hr>
<h3>Sales overview:</h3>
<table class="table table-bodered">
    <tr>
        <th class="bg-light">Order Description</th>
        <td>
            @if (count($orders)>0)
                <b>Total order received:</b> {{count($orders)}} <br>
                <b>Total order completed</b> {{$ordercompleted}}
            @else
                No order received
            @endif
        </td>
    </tr>    
    <tr>
        <th class="bg-light">Customize Task Description</th>
        <td>
            @if (count($tasks)>0)
                <b>Total task received:</b> {{count($tasks)}} <br>
                <b>Total task completed</b> {{$taskcompleted}}
            @else
                No customize task received
            @endif
        </td>
    </tr>
    <tr>
        <th class="bg-light">Sales Description</th>
        <td>
            <b>Total Sales:</b> RM {{number_format($totalSales,2)}} <br>
            <b>Total Income:</b> RM{{number_format($totalIncome,2)}} <br>    
            <b>Payment Pending:</b> RM {{number_format($paymentPending,2)}}
        </td> 
    </tr>     
</table>    
<div class="page-break"></div>
<h3>Order Description:</h3>
<table class="table table-bordered">
    <thead class="thead-light">
        <tr>
            <th>ID:</th>
            <th>Description:</th>
            <th>Status</th>
            <th>Amount</th>    
        </tr>
    </thead>
    @php $no = 1; @endphp
    @if(count($orders)>0)
    @foreach ($orders as $order)
    <tr>
        <td>{{$no++}}</td>
        <td>
            Order ID: {{$order->order_number}} <br>
            Item(s): {{$order->item_count}} <br>
            Pay by: {{$order->payment_method}}, 
            @if ($order->is_paid == true)
            <span class="badge badge-success">Is Paid</span>    
            @else
            <span class="badge badge-danger">Not Paid</span>    
            @endif <br>
            Ordered at: {{date('d-M-Y', strtotime($order->created_at))}}
        </td>
        <td>
            @if ($order->status == 'completed')
            <span class="badge badge-success">{{$order->status}}</span>            
            @elseif ($order->status == 'declined')
            <span class="badge badge-danger">{{$order->status}}</span>            
            @else
            <span class="badge badge-warning">{{$order->status}}</span>            
            @endif
        </td>
        <td>RM {{number_format($order->grand_total,2)}}</td>
    </tr>
    @endforeach
    @else
    <tr>
        <td colspan="4" class="text-center"> None received order(s)</td>
    </tr>
    @endif
</table>
  <br><br><br>
<h3>Customize Task Description:</h3>
<table class="table table-bordered">
    <thead class="thead-light">
        <tr>
            <th>ID:</th>
            <th>Description:</th>
            <th>Status</th>
            <th>Amount</th>      
        </tr>
    </thead>
    @php $no = 1; @endphp
    <tbody>
    @if (count($tasks)>0)
    @foreach ($tasks as $task)
    <tr>
      <td>{{$no++}}</td>
      <td>
        Task ID: {{$task->custom_number}} <br>
          @if ($task->grand_total !=null)
            Fully Payment: 
            @if ($task->fully_paid == true)
            <span class="badge badge-success">Is Paid</span>    
            @else
            <span class="badge badge-danger">Not Paid</span>    
            @endif
            <br>
            Deposit: 
            @if ($task->deposit_paid == true)
            <span class="badge badge-success">Is Paid</span>    
            @else
            <span class="badge badge-danger">Not Paid</span>    
            @endif
            <br>
          @endif
        Deadline: {{$task->deadline}}
      </td>
      <td>
        @if ($task->status == 'completed')
        <span class="badge badge-success">{{$task->status}}</span>            
        @elseif ($task->status == 'declined')
        <span class="badge badge-danger">{{$task->status}}</span>            
        @else
        <span class="badge badge-warning">{{$task->status}}</span>            
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
    </tr>
    @endforeach
    @else
    <tr>
        <td colspan="4" class="text-center"> None received task(s)</td>
    </tr>
    @endif
    </tbody>

</table>

</body>
</html>