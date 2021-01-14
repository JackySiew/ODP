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
        <td>
            @if ($item->status == 'completed')
                <span class="badge badge-success">{{$item->status}}</span> <br> <br>
            @elseif($item->status == 'declined')
                <span class="badge badge-danger">{{$item->status}}</span> <br> <br>
            @else
                <span class="badge badge-warning">{{$item->status}}</span> <br> <br> 
            @endif
            @if ($item->status == 'pending')
            <a href="{{url('cancel-product/'.$item->id)}}" class="btn btn-danger">Cancel</a>
            @endif
        </td>
    </tr>   
    @endforeach
</table>      
