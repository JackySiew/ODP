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
<img src="{{url('storage/image/logo.png')}}" alt="Logo">
<br>
<p>
    No. 99, Jalan Contoh 12,<br>
    Taman Pasulan,<br>
    81300 Skudai, Johor
</p>
<hr>
<p class="float-right">
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
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Image</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Amount</th>
            </tr>    
        </thead>
        @foreach ($products as $item)
        <tr>
            <td><img src="storage/image/{{$item->prodImage}}" width="100"></td>
            <td>
                Product Id: {{$item->id}}<br>
                Product Name: {{$item->prodName}}<br>
                Price per Unit: RM {{$item->prodPrice}}
            </td>
            <td>{{$item->quantity}} Unit(s)</td>
            <td>RM {{$item->prodPrice * $item->quantity}}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="4" class="text-right"><b>Total: RM{{$total}}</b></td>
        </tr>    
    </table>    
    <br>
    <footer>
        <p>For more about information, please email to info@odp.com or contact no(07-5638525).</p>
        <p>Thank You.</p>        
    </footer>
</body>
</html>