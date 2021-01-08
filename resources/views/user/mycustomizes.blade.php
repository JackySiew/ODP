@extends('layouts.app')

@section('title')
My Customize request
@endsection
@section('class')
container
@endsection
@section('content')
    <h1 class="mb-5">My Customize Request Status</h1>      
    <p><a href="{{url('/my-orders')}}" class="btn btn-primary">Change to Orders</a></p>
@if(count($customs) > 0)
@foreach ($customs as $custom)
<div class="card mb-4">
       <div class="card-header text-center">
        <b>Customize Task ID:</b> {{$custom->custom_number}}<br>
        <small>Order Date: {{$custom->created_at->format('d M, Y H:i A')}}</small>         
    </div>

        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item">
                    <b>Task Status:</b> 
                    @if ($custom->status =='accepted' || $custom->status == 'completed')
                        <span class="badge badge-success">{{$custom->status}}</span>                   
                    @elseif($custom->status == 'processing')
                        <span class="badge badge-warning">{{$custom->status}}</span>                   
                    @else
                        <span class="badge badge-warning">{{$custom->status}}</span>                   
                    @endif
                </li>
                @if ($custom->grand_total != NULL)
                    <li class="list-group-item">
                        <b>Payment Status:</b> 
                        @if ($custom->is_paid == 0)
                            <span class="badge badge-danger">Not Pay </span>
                        @else
                            <span class="badge badge-success">Is Paid </span>
                        @endif
                    </li>
                @endif
                @if ($custom->status == 'accepted')
                <li class="list-group-item">    
                    <b>Pay Deposit: </b><a href="{{url('deposit/'.$custom->id)}}" class="btn btn-success"><i class="fa fa-cc-stripe"></i>Pay</a> | <a href="#" class="btn btn-danger"><i class="fa fa-times"></i></a>
                </li>    
                @endif
                    <li class="list-group-item">
                        <b>Item(s):</b>
                        <button class="btn btn-light btn-sm task " id="{{$custom->id}}" data-toggle="collapse" data-target="#tasks{{$custom->id}}" aria-expanded="false" aria-controls="tasks{{$custom->id}}"><i class="fa fa-eye"></i></button>
                    <div class="collapse panel-collapse" id="tasks{{$custom->id}}">
                        
                    </div>
                    </li>
                </li>    
            </ul>
            <a href="{{url('showcustom/'.$custom->id)}}">See more details >></a>
        </div>
        <div class="card-footer">
            <div class="pull-right">
                @if ($custom->grand_total != NULL)
                <strong>Total Price: RM{{$custom->grand_total}}</strong><br>
                @endif

                @if ($custom->status == 'accepted')
                <strong>Deposit: RM{{$custom->deposit}}</strong><br>
                <strong>Subtotal: RM{{$custom->grand_total - $custom->deposit}}</strong><br>  
                @endif                
            </div>
        </div>
   </div>
@endforeach

@else
<div class="card mb-4">
    <div class="card-body text-center">
        <h3>You don't have any customize request yet.</h3>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
    var task_id = ''
    $(document).ready( function () {
        $('.task').on('click',function(){
            task_id = $(this).attr('id');
            $.ajax({
            type:"get",
            url:"task-item/"+task_id,
            cache:false,
            success: function (data) {
                $('#tasks'+task_id).html(data);
            }
           });
        })
    });
</script>

@endsection