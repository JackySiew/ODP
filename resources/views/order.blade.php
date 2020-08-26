@extends('layouts.app')

@section('title')
My Order
@endsection
@section('class2')
    <div class="container">
@endsection
@section('content')
    <h1>My Orders</h1>
@if(count($orders) > 0)
@foreach ($orders as $order)
   <div class="panel panel-default">
       <div class="panel-header text-center">
        @if($order->status == 0)
            <h1 class="bg-warning text-white">Pending</h1>
        @elseif($order->status == 1) 
            <h1 class="bg-info text-white">Your products is shipping</h1>
        @else
            <h1 class="bg-success text-white">Product Received</h1>  
        @endif
       </div>
        <div class="panel-body">
            <ul class="list-group">
                @foreach ($order->cart->items as $item)
                <li class="list-group-item">{{$item['item']['prodName']}} | {{$item['qty']}} Unit(s) <b class="pull-right">RM {{$item['prodPrice']}}</b></li>
                @endforeach
                <li class="list-group-item text-center"><small>{{$order->created_at}}</small></li>
            </ul>
        </div>
        <div class="panel-footer">
        <strong>Total Price: {{$order->cart->totalPrice}}</strong>
        </div>
   </div>
@endforeach

@else

@endif
@endsection