<table class="table table-responsive-sm">
    <tr>
        <th>Product Image</th>
        <th>Product Details</th>
        <th>Requirement</th>
    </tr>
    @foreach ($customItems as $item)
    <tr>
        <td><img src="storage/image/{{$item->prodImage}}" alt="Product Image" width="100"></td>
        <td>
            Product Id: {{$item->id}}<br>
            Product Name: {{$item->prodName}}<br>
            Qty: {{$item->quantity}} Unit(s)<br>
        </td>
        <td>{!! $item->request !!}</td>
    </tr>   
    @endforeach
</table>      