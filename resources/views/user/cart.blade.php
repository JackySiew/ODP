@extends('layouts.app')

@section('title')
    Cart
@endsection
@section('class')
    container
@endsection
@section('content')
    <h1>Your Cart</h1>
@if (!Cart::isEmpty())
<table class="table table-bordered">
    <tr>
        <th>Quantity</th>
        <th>Product Image</th>
        <th>Product Name</th>
        <th>Price</th>
    </tr>
    @foreach ($cartItems as $product)
    <tr>
        <td>
        <form action="{{url('/update',$product->id)}}">
        <input type="number" name="quantity" value="{{ $product->quantity}}" min="1" max="50">
        <input type="submit" class="btn btn-success" value="Update">
        </form>
        <br>
        <br>
        <a class="btn btn-danger" href="{{url('remove/'.$product['id'])}}"><i class="fa fa-trash fa-lg">Remove</i></a>
        </td>
        <td>
            <img src="{{url('storage/image/'.$product['image'])}}" width="200" height="150">
        </td>
        <td>{{$product['name']}}
        <br>
        </td>
        <td>RM {{number_format(\Cart::session(auth()->id())->get($product->id)->getPriceSum(),2)}}</td>
    </tr>
    @endforeach
    <tr>

        <td colspan="4" class="text-right">Total: <strong>RM {{number_format(\Cart::session(auth()->id())->getTotal(),2)}}</strong></td>
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