@extends('layouts.app')
@section('title')
    All Designers
@endsection
@section('class')
container
@endsection
@section('extra-css')
    <style>
.message-wrapper{
    padding: 10px;
    height: 400px;
    background: #eeeeee;
    height: 300px;
    overflow-y: auto;
}

.messages, .message{
    margin-bottom: 15px;
}
.messages .message:last-child{
    margin-bottom: 0;
}
.sent, .received{
    width: 45%;
    padding: 3px 10px;
    border-radius: 10px;
}
.message p{
    margin: 5px 0;
}

    </style>    
@endsection
@section('content')
@if (session('status'))
<div class="alert alert-success">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
  {{ session('status') }}
</div>
@elseif (session('alert'))
<div class="alert alert-danger">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
  {{ session('alert') }}
</div>
@endif
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Designers</li>
      </ol>
</nav>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row col-md-12">
                @foreach ($designers as $designer)
                <div class="card border-warning col-md-4 mb-3 ">
                    <div class="text-center">
                        <img src="{{url('/storage/image/'.$designer->profile)}}" class="img-thumbnail rounded-circle">
                        <br>
                    <div class="card-body">
                        <p><b>Name:</b> {{$designer->name}}</p>
                        <p><b>Email:</b> {{$designer->email}}</p>
                        <p><b>Mobile:</b> {{$designer->mobile}}</p>
                        <a href="{{url('designer/'.$designer->id)}}" class="btn btn-lg btn-primary">View</a>
                        <button type="button" class="btn btn-lg btn-success chat" data-toggle="modal" id="{{$designer->id}}" data-target="#exampleModal">
                            Chat
                        </button>
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Chat Box</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                    <div id="message">

                                    </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>
                    </div>
                </div>  
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.chat').click(function(){
    receiver_id = $(this).attr('id');
    $.ajax({
            type: "get",
            url:"messages/"+receiver_id,
            data: "",
            cache: false,
            success: function (data){
                $('#exampleModal').modal("show");
                $('#exampleModal').find("#message").html(data);
                scrollToBottom();
            }
    });
    });

    $(document).on('keyup','.input-text input', function(e){
        var message = $(this).val();
        //check if enter key is pressed & message not empty & receiverId not empty
        if(e.keyCode == 13 && message != '' && receiver_id != '') {
            $(this).val('');//empty the input when enter key pressed

            var datastr = "receiver_id="+receiver_id+"&message="+message;
            $.ajax({
                type: "post",
                url:"message",
                data: datastr,
                cache: false,
                success: function (data){

                },
                error: function(jqXHR, status, err){

                },
                complete: function(){
                    scrollToBottom();
                }
            });
        }
    });

    Pusher.logToConsole = true;

    var pusher = new Pusher('7ee7e2a81862561e0bd9', {
    cluster: 'ap1'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
        // alert(JSON.stringify(data));
        if (my_id == data.from) {
            $('#' + data.to).click();
            // alert('sender');
        } else if(my_id == data.to) {
            if (receiver_id == data.from) {
                //if receiver is selected, reload the selected user
                $('#' + data.from).click();
            } else {
                //if receiver is not selected, add notification for that user
                var pending = parseInt($('#' + data.from).find('.pending').html());

                if (pending) {
                    $('#' + data.from).find('.pending').html(pending + 1);
                } else {
                    $('#' + data.from).append('<span class="pending">1</span>');
                }
            }
        }
    });
});
function scrollToBottom(){
$('.message-wrapper').animate({
    scrollTop: $('.message-wrapper').get(0).scrollHeight
}, 50);
}

    </script>
@endsection