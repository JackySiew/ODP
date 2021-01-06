<table class="table table-responsive-sm">
    <tr>
        <th>Product Name</th>
        <th>Quantity</th>
    </tr>
    @foreach ($customItems as $item)
    <tr>
        <td>{{$item->prodName}}</td>
        <td>{{$item->quantity}}</td>
    </tr>      
    @endforeach
</table>      
