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

<img src="{{url('storage/image/logo.png')}}" alt="Logo">
<br>
<p>
    No. 99, Jalan Contoh 12,<br>
    Taman Pasulan,<br>
    81300 Skudai, Johor
</p>
<hr>
<h3>Sales overview:</h3>
<table class="table table-sm">
    <thead class="thead-light">
        <tr>
            <th>Order Details</th>
            <th>Customize Task Details</th>
        </tr>    
    </thead>
    <tr>
        <td>
            @if (count($orders)>0)
                <b>Total order received:</b> {{count($orders)}} <br>
                <b>Total order completed</b> {{$ordercompleted}}
            @else
                No order received
            @endif
        </td>
        <td>
            @if (count($tasks)>0)
                <b>Total task received:</b> {{count($tasks)}} <br>
                <b>Total task completed</b> {{$taskcompleted}}
            @else
                No customize task received
            @endif
        </td>
    </tr>
    <tfoot>
        <tr>
            <td colspan="4" class="text-right">
            <b>Total Sales: RM{{number_format($totalSales,2)}}</b> <br> 
            <b>Total Income: RM{{number_format($totalIncome,2)}}</b> <br>
            <b>Payment Pending: RM{{number_format($paymentPending,2)}}</b>
            </td>
        </tr>        
    </tfoot>
</table>    

</body>
</html>