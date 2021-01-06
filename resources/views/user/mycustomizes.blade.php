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
@if ($custom->status == 'processing')
<div class="card-header bg-warning text-center text-white">
    <b>{{$custom->status}}</b>
</div>

@elseif($custom->status == 'accepted' || $custom->status == 'completed')
<div class="card-header bg-success text-center text-white">
    <b>{{$custom->status}}</b>
</div>

@elseif($custom->status == 'declined')
<div class="card-header bg-danger text-center text-white">
    <b>{{$custom->status}}</b>
    <p>Reason: {{$custom->notes}}</p>
</div>
@else
       <div class="card-header text-center">
        <b>{{$custom->status}}</b>
    </div>
        @endif

        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item">{{$custom->custom_number}}</li>
                @if ($custom->status == 'accepted')
                <li class="list-group-item">    
                    <a href="{{url('deposit/'.$custom->id)}}"><i class="fa fa-cc-stripe"></i>Pay deposit</a>
                </li>    
                @endif
                    <li class="list-group-item">
                        <button class="btn btn-light btn-sm task pull-right" id="{{$custom->id}}" data-toggle="collapse" data-target="#tasks{{$custom->id}}" aria-expanded="false" aria-controls="tasks{{$custom->id}}"><i class="fa fa-eye"></i></button>
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

                <small>{{$custom->created_at}}</small>
                
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
            url:"task/"+task_id,
            cache:false,
            success: function (data) {
                $('#tasks'+task_id).html(data);
            }
           });
        })
    });
</script>

@endsection