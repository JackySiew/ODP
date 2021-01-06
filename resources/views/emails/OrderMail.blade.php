<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">  
    <style>
                table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
table{
    width: 100%;
    text-align: center;
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
        <b>Order ID:</b> {{$details['orderNumber']}}<br>
        <b>Order Date:</b> {{$details['orderDate']}}
    </p>
    </div>
    
    <p>
        <b>Bill to:</b><br>
        {{$details['address']['address1']}}<br>
        {{$details['address']['address2']}}<br>
        {{$details['address']['postcode']}} {{$details['address']['city']}}<br>
        {{$details['address']['state']}}<br>
    </p>
    <br>
        
<p>Dear {{$details['name']}},</p>
<p>Thank you for visiting our <a href="http://odp.test">Online Designer Platform(ODP)</a>.</p>
<p>This mail is to inform you that we have received your order.</p>
<p>Your order will be delivered within one week.</p>
<br>
<p><b>Order Details:</b></p>    
<table class="table">
    <tr>
        <th>Product ID</th>
        <th>Image</th>
        <th>Name</th>
        <th>Qty</th>
        <th>Price</th>
    </tr>
    @foreach ($details['products'] as $item)
    <tr>
        <td>{{$item['id']}}</td>
        <td><img src="{{url('storage/image/'.$item->image)}}" width="200" height="150" alt="Product Image"></td>
        <td>{{$item['name']}}</td>
        <td>{{$item['quantity']}} Unit(s)</td>
        <td>RM {{$item['price']}}</td>
    </tr>
    @endforeach
</table>
<p>Total: RM{{$details['total']}}</p>
<br>
<br>
<p>This email is only used to confirm your order on <a href="http://odp.test">Online Designer Platform(ODP)</a>.</p>
<p>This is an auto-reply emailand you don’t have to reply. If you have further questions.please email to info@odp.com.</p>
<p>Thank You.</p>
</body>
</html>