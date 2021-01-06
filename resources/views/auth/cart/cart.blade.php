@extends('layouts.app')

@section('title')
    Cart
@endsection
@section('class')
    container
@endsection
@section('content')
    <h1>Your Cart</h1>
@if (Session::has('cart'))
<table class="table table-bordered">
    <tr>
        <th>Quantity</th>
        <th>Product Image</th>
        <th>Product Name</th>
        <th>Price</th>
    </tr>
    @foreach ($products as $product)
    <tr>
        <td>
        <a href="{{url('reduceqty/'.$product['item']['id'])}}" class="btn btn-danger">-</a>
            {{$product['qty']}}
        <a href="{{url('addqty/'.$product['item']['id'])}}" class="btn btn-success">+</a>
        <br>
        <br>
        <a class="btn btn-danger" href="{{url('remove/'.$product['item']['id'])}}"><i class="fa fa-trash fa-lg">Remove</i></a>
        </td>
        <td>
            <img src="{{url('storage/image/'.$product['item']['prodImage'])}}" width="200" height="150">
        </td>
        <td>{{$product['item']['prodName']}}</td>
        <td>RM{{$product['prodPrice']}}</td>
    </tr>
    @endforeach
    <tr>

        <td colspan="4" class="text-right">Total: <strong>RM {{$totalPrice}}</strong></td>
    </tr>
</table>
<a href="{{url('checkout')}}" class="btn btn-info pull-right">Checkout</a>
@else
<table class="table table-bordered">
    <tr>
        <th>Quantity</th>
        <th>Product Image</th>
        <th>Product Name</th>
        <th>Price</th>
    </tr>
    <tr>
        <td colspan="4" class="text-center"><h1>There is nothing in your cart!</h1>
            <br>
            <a href="{{url('all-products')}}" class="btn btn-warning text-white"><h1>Shop Now!</h1></a>
        </td>
    </tr>
</table>
@endif
@endsection