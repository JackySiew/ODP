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
    <h3 class="text-center mb-5">Sales report in {{$day}} {{date('M', strtotime($month))}}, {{$year}}</h3>

<img src="{{url('storage/image/logo.png')}}" alt="Logo">
<br>
<p>
    No. 99, Jalan Contoh 12,<br>
    Taman Pasulan,<br>
    81300 Skudai, Johor
</p>
<hr>
<h3>Ordering Details:</h3>
<table class="table table-sm">
    <thead class="thead-light">
        <tr>
            @if ($day == NULL)
            <th>Date</th>
            @endif
            <th>Description</th>
            <th>Payment Remark</th>
            <th>Total Amount</th>
        </tr>    
    </thead>
    @foreach ($description as $order)
    <tr>
        <td>{{date('d-m-Y', strtotime($order->created_at))}}</td>
        <td>
            Order ID: {{$order->order_number}}<br>
            Items count: {{$order->item_count}}<br>
            Order Status: 
            @if ($order->status == 'completed')
            <span class="badge badge-success">{{$order->status}}</span>            
            @elseif($order->status == 'declined')
            <span class="badge badge-danger">{{$order->status}}</span>            
            @else
            <span class="badge badge-warning">{{$order->status}}</span>            
            @endif
            <br>
            Customer Name: {{$order->fullname}} 
        </td>
        <td>
            Payment Status:
            @if ($order->is_paid == 1)
            <span class="badge badge-success"> Is Paid</span>
            @else
            <span class="badge badge-danger"> Not Paid </span>
            @endif             
            Pay by: {{$order->payment_method}} <br>
        </td>
        <td class="text-right">RM {{number_format($order->grand_total,2)}}</td>
    </tr>
    @endforeach
    <tfoot>
        <tr>
            <td colspan="4" class="text-right">
            <b>Total sum: RM{{number_format($sum,2)}}</b> <br> 
            <b>Total Income: RM{{number_format($actual,2)}}</b> <br>
            <b>Payment Pending: RM{{number_format($paymentPending,2)}}</b>
            </td>
        </tr>        
    </tfoot>
</table>    
<br>
<br>
<div class="page-break"></div>
<h3>Customize Task Details:</h3>
<table class="table table-sm">
    <thead class="thead-light">
        <tr>
            @if ($day == NULL)
            <th>Date</th>
            @endif
            <th>Description</th>
            <th>Payment Remark</th>
            <th>Total Amount</th>
        </tr>    
    </thead>
    @foreach ($description2 as $task)
    <tr>
        <td>{{date('d-m-Y', strtotime($task->created_at))}}</td>
        <td>
            Task ID: {{$task->custom_number}}<br>
            Customize task Status: 
            @if ($task->status == 'completed')
            <span class="badge badge-success">{{$task->status}}</span>            
            @elseif($task->status == 'declined')
            <span class="badge badge-danger">{{$task->status}}</span>            
            @else
            <span class="badge badge-warning">{{$task->status}}</span>            
            @endif
            <br>
            Customer Name: {{$task->fullname}} 
        </td>

        <td>
            Fully Payment:
            @if ($task->fully_paid == 1)
            <span class="badge badge-success"> Is Paid</span><br>
            Paid by: {{$task->payment_method}} <br>
            @else
            <span class="badge badge-danger"> Not Paid </span><br>
            @endif 
            Deposit:
            @if ($task->deposit_paid == 1)
            <span class="badge badge-success"> Is Paid</span><br>
            Paid by: {{$task->payment_method}} <br>
            @else
            <span class="badge badge-danger"> Not Paid </span><br>
            @endif 
        </td>
        <td class="text-right">
            @if ($task->grand_total == null)
                None
            @else
            RM {{number_format($task->grand_total,2)}}
            @endif
        </td>
    </tr>
    @endforeach
    <tr>
        <td colspan="4" class="text-right">
            <b>Total sum: RM{{number_format($sum2,2)}}</b> <br> 
            <b>Total Income: RM{{number_format($actual2,2)}}</b> <br>
            <b>Payment Pending: RM{{number_format($paymentPending2,2)}}</b>
        </td>
    </tr>    
</table>    
</body>
</html>