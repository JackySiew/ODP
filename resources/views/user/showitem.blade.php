<table class="table table-responsive-sm">
    <tr>
        <th>Product Image</th>
        <th>Product Details</th>
        <th>Total Sum</th>
        <th>Status</th>
    </tr>
    @foreach ($orderItems as $item)
    <tr>
        <td><img src="storage/image/{{$item->prodImage}}" alt="Product Image" width="100"></td>
        <td>
            Product Id: {{$item->id}}<br>
            Product Name: {{$item->prodName}}<br>
            Qty: {{$item->quantity}} Unit(s)<br>
            Price per Unit: RM {{$item->prodPrice}}
        </td>
        <td>
            RM {{$item->quantity * $item->prodPrice}}
        </td>
        <td>{{$item->status}}</td>
    </tr>   
    @endforeach
</table>      
