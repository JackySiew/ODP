<div class="message-wrapper" style="overflow-y:auto;">
    <ul class="messages" style="margin: 0; padding: 0;">
        @foreach ($messages as $message)
        <li class="message clearfix list-unstyled">
            <div class="{{($message->from == Auth::id()) ? 'sent bg-success text-right text-white float-right' : 'received bg-white'}}">
                <p>{{$message->message}}</p>
                <small>{{date("d M Y", strtotime($message->created_at))}}</small>
            </div>
        </li>
        @endforeach
    </ul>
</div>
<div class="input-text">
    <input type="text" name="message" class="submit form-control" style="padding: 12px 20px; margin: 15px 0 0 0;">
</div>
