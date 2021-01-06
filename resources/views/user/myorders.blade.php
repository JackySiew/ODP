@extends('layouts.app')

@section('title')
My Order
@endsection
@section('class')
container
@endsection
@section('content')
@if (Session::has('status'))
<div class="alert alert-success text-center">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    <p>{{ Session::get('status') }}</p>
</div>
@endif

    <h1 class="mb-5">My Order Status</h1>     
<p><a href="{{url('/my-customize')}}" class="btn btn-primary">Change to Customize request</a></p>
@if(count($orders) > 0)
@foreach ($orders as $order)
   <div class="card mb-4">
       <div class="card-header text-center">
        <b>Order ID:</b> {{$order->order_number}}   <br>  
        <small>Order Date: {{$order->created_at->format('d M, Y H:i A')}}</small>         
        </div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item"><b>Payment Status:</b> 
                    @if ($order->is_paid == 0)
                        <span class="badge badge-danger">Haven't Pay </span>
                    @else
                        <span class="badge badge-success">Is Paid </span>
                    @endif
                    <br>
                    <b>Paid by:</b> {{$order->payment_method}} 
                </li>
                <li class="list-group-item"><b>Item(s):</b> {{$order->item_count}} 
                    <button class="btn btn-light btn-sm item pull-right" id="{{$order->id}}" data-toggle="collapse" data-target="#items{{$order->id}}" aria-expanded="false" aria-controls="items{{$order->id}}"><i class="fa fa-eye"></i></button>
                    <div class="collapse panel-collapse" id="items{{$order->id}}">
                        
                    </div>
                </li>    
            </ul>
            <a href="{{url('showorder/'.$order->id)}}">See more details >></a>
        </div>
        <div class="card-footer">
            <div class="pull-right">
                <strong>Total Price: RM{{$order->grand_total}}</strong><br>
            </div>
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

@section('scripts')
<script>
    var item_id = ''
    $(document).ready( function () {
        $('.item').on('click',function(){
            item_id = $(this).attr('id');
            $.ajax({
            type:"get",
            url:"item/"+item_id,
            cache:false,
            success: function (data) {
                $('#items'+item_id).html(data);
            }
           });
        })
    });
</script>

@endsection