@extends('layouts.app')

@section('title')
    Checkout
@endsection
@section('class2')
    <div class="container">
@endsection
@section('content')
<div class="col-md-6 col-md-offset-3">
    <h1 class="text-center"> Your Checkout</h1>
    <h3 class="text-center">Total: <span class='amount'>RM{{$total}}</span></h3>
<div id="charge-error" class="alert alert-danger {{ !Session::has('error') ? 'hidden' : ''}}">
{{Session::get('error')}}
</div>
    <form action="/checkout" class="require-validation" id="checkout-form" method="POST">
    <div class='form-row'>
        <div class='col-xs-12 form-group required'>
            <label for="name" class='control-label'>Name</label> 
            <input class='form-control' type='text' name="name" value="{{Auth::user()->name}}" required>
        </div>
    </div>
    <div class='form-row'>
        <div class='col-xs-12 form-group required'>
            <label for="address" class='control-label'>Address</label> 
            <input class='form-control' type='text' name="address" required>
        </div>
    </div>
    <div class='form-row'>
        <div class='col-xs-12 form-group required'>
            <label for="card-name" class='control-label'>Card Holder Name</label> 
            <input class='form-control' type='text' id='card-name' required>
        </div>
    </div>
    <div class='form-row'>
        <div class='col-xs-12 form-group required'>
            <label for="card-number" class='control-label'>Credit Card Number</label> 
            <input autocomplete='off' class='form-control' type='text' id="card-number" value="4242 4242 4242 4242">
        </div>
    </div>
    <div class='form-row'>
        <div class='col-xs-4 form-group expiration required'>
            <label for="card-expiry-month" class='control-label'>Expiration</label> 
            <input class='form-control' placeholder='MM' size='2' type='text' id="card-expiry-month">
        </div>
        <div class='col-xs-4 form-group expiration required'>
            <label for="card-expiry-year" class='control-label'> </label> 
            <input class='form-control' placeholder='YYYY' size='4' type='text' id="card-expiry-year">
        </div>        
        <div class='col-xs-4 form-group cvc required'>
            <label for="card-cvc" class='control-label'>CVC</label> 
            <input autocomplete='off' class='form-control' placeholder='ex. 311' size='4' type='text' id="card-cvc">
        </div>
    </div>
    <div class='form-row'>
        <div class='col-md-12 form-group'>
            {{ csrf_field() }}
            <button class='form-control btn btn-primary submit-button'
                type='submit' style="margin-top: 10px;">Pay</button>
        </div>
    </div>
</form> 
</div>
@endsection

@section('scripts')
<script src="https://js.stripe.com/v2/"></script>
<script src="https://js.stripe.com/v3/"></script>
<script src="{{ asset('js/checkout.js')}}"></script>
@endsection