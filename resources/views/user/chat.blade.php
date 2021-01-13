@extends('layouts.app')
@section('title')
   Chat Room
@endsection
@section('extra-css')
<style>

.user{
    cursor: pointer;
    padding: 5px 0;
    position: relative;
}
.user:hover{
    background: #eeeeee;
}
.user:last-child{
    margin-bottom: 0;
}
.pending{
    position: absolute;
    left: 13px;
    top: 9px;
    background: #b600ff;
    margin: 0;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    line-height: 18px;
    padding-left: 5px;
    color: #ffffff;
    font-size: 12px;
}
.media-left{
    margin: 0 10px;
}
.media-left img{
    width: 64px;
    border-radius: 64px;
}
.media-body p{
    margin: 6px 0;
}
.message-wrapper{
    padding: 10px;
    height: 400px;
    background: #eeeeee;
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
.active{
    background: #eeeeee;
}
</style>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="user-wrapper border overflow-auto" style="height: 400px;">
                <ul class="users m-0 p-0">
                    @foreach ($users as $user)
                    <li class="user m-0 p-0 list-unstyled" id="{{$user->id}}">
                        @if ($user->unread)
                        <span class="pending">
                            {{$user->unread}}
                        </span>
                        @endif
                        <div class="media">
                            <div class="media-left">
                                <img src="storage/image/{{$user->profile}}" alt="Profile" class="media-object">
                            </div>
                            <div class="media-body">
                                <p class="name">{{$user->name}}</p>
                                <p class="email">{{$user->email}}</p>
                            </div>
                        </div>
                    </li>    
 
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-md-8" id="messages">

        </div>    
    </div>
</div>
@endsection

@section('scripts')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
    var receiver_id = '';
    var my_id = "{{Auth::id()}}";
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.user').click(function(){
           $('.user').removeClass('active');
           $(this).find('.pending').remove();
           $(this).addClass('active');
           receiver_id = $(this).attr('id');
           $.ajax({
                type: "get",
                url:"messages/"+receiver_id,
                data: "",
                cache: false,
                success: function (data){
                    $('#messages').html(data);
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