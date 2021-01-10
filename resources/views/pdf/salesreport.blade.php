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
<table class="table table-sm">
    <thead class="thead-light">
        <tr>
            @if ($day == NULL)
            <th>Date</th>
            @endif
            <th>Description</th>
            <th>Payment Remark</th>
            <th>Amount</th>
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
            Pay by: {{$order->payment_method}} <br>
            @if ($order->is_paid == 1)
            <span class="badge badge-success"> Is Paid</span>
            @else
            <span class="badge badge-danger"> Not Paid </span>
            @endif 
            <br>
            
        </td>
        <td class="text-right">RM {{$order->grand_total}}</td>
    </tr>
    @endforeach
    <tr>
        <td colspan="4" class="text-right"><b>Total sum: RM{{$sum}}</b> <br> <b>Actual sum: RM{{$actual}}</b></td>
    </tr>    
</table>    
<br>
<div class="page-break"></div>
<footer>
    <p>For more about information, please email to info@odp.com or contact no(07-5638525).</p>
    <p>Thank You.</p>        
</footer>
</body>
</html>