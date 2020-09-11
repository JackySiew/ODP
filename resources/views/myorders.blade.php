@extends('layouts.app')

@section('title')
My Order
@endsection
@section('class')
container
@endsection
@section('content')
    <h1 class="mb-5">My Order Status</h1>
@if(count($orders) > 0)
@foreach ($orders as $order)
   <div class="card mb-4">
       <div class="card-header text-center">
        @if($order->status == 0)
            <h3>Your order is under process</h3>
        @elseif($order->status == 1) 
            <h3>Your order is shipping</h3>
        @else
            <h3>Your item(s) has received</h3>  
        @endif
       </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach ($order->cart->items as $item)
                <li class="list-group-item">{{$item['item']['prodName']}} | {{$item['qty']}} Unit(s) <b class="pull-right">RM {{$item['prodPrice']}}</b></li>
                @endforeach
                <li class="list-group-item"><strong class="pull-right">Total Price: {{$order->cart->totalPrice}}</strong>
                    <small>{{$order->created_at}}</small></li>
            </ul>
        </div>
   </div>
@endforeach

@else
<div class="card mb-4">
    <div class="card-body text-center">
        <h3>You don't have any order yet.</h3>
    </div>
</div>
@endif
@endsection