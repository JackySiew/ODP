<!DOCTYPE html>
<html lang="en  ">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .page-break {
            page-break-after: always;
        }
        table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
table{
    width: 100%;
}
    </style>
</head>
<body>      
<img src="{{url('storage/image/logo.png')}}" alt="Logo">
<br>
<p>
    No. 99, Jalan Contoh 12,<br>
    Taman Pasulan,<br>
    81300 Skudai, Johor
</p>
<hr>
<div style="float: right;">
<p>
    <b>Order ID:</b> {{$orderNumber}}<br>
    <b>Order Date:</b> {{$orderDate}}
</p>
</div>

<p>
    <b>Bill to:</b><br>
    {{$address['address1']}}<br>
    {{$address['address2']}}<br>
    {{$address['postcode']}} {{$address['city']}}<br>
    {{$address['state']}}<br>
</p>
<br>

<p><b>Purchase Order:</b>
    <table>
        <tr>
            <th>Image</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Amount</th>
        </tr>
        @foreach ($products as $item)
        <tr>
            <td><img src="storage/image/{{$item->prodImage}}" width="100"></td>
            <td>
                Product Id: {{$item->id}}<br>
                Product Name: {{$item->prodName}}<br>
                Price per Unit: RM {{$item->prodPrice}}
            </td>
            <td>{{$item->quantity}} Unit(s)</td>
            <td style="text-align: center;">RM {{$item->prodPrice * $item->quantity}}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="4" style="text-align:right;"><b>Total: RM{{$total}}</b></td>
        </tr>    
    </table>    
    <br>
    <footer>
        <p>For more about information, please email to info@odp.com or contact no(07-5638525).</p>
        <p>Thank You.</p>        
    </footer>
</body>
</html>