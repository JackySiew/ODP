@extends('layouts.app')

@section('title')
    Checkout
@endsection
@section('class')
    container
@endsection
@section('content')
<div class="row">
    <div class="col-md-6">
        <table class="table table-responsive">
            <tr>
                <th>Image</th>
                <th>Product Details</th>
                <th>Total</th>
            </tr>
            @foreach ($product as $item)
            <tr>
                <td><img src="/storage/image/{{$item->image}}" width="100" class="img-fluid mb-3"></td>
                <td>
                    Product Id: {{$item->id}}<br>
                    Product Name: {{$item->name}}<br>
                    Qty: {{$item->quantity}} Unit(s)<br>
                    Price per Unit: RM {{number_format($item->price,2)}}
                </td>
                <td>RM {{number_format(\Cart::session(auth()->id())->get($item->id)->getPriceSum(), 2)}}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="4">
                    <strong>Grand Total: RM {{number_format(\Cart::session(auth()->id())->getTotal(),2)}}</strong>
                </td>
            </tr>
        </table>
    </div>

    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-heading">Checkout Form</h3>
            </div>
            <div class="panel-body">
                @if (Session::has('error'))
                    <div class="alert alert-danger text-center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <p>{{ Session::get('error') }}</p>
                    </div>
                @endif
                <form role="form" action="{{ route('orders.store') }}" method="post"
                class="validation" data-cc-on-file="false"
               data-stripe-publishable-key="pk_test_51HFVGNCFq6SzGxX2zzStHtD9N673SVQ5nUqVXeHivLn454y1GZCyOLY6UGIMkzsvhje3XRSgnZlGJ1MEu0OBWBkH00KOxIOjIg"
               id="payment-form">
                    {{ csrf_field() }}
                    <div class='form-group'>
                        <div class='col-xs-12 form-group required'>
                            <label class='control-label'>Full Name:</label> <input
                                class='form-control' type='text' name="fullname">
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-xs-12 form-group required'>
                            <label class='control-label'>Mobile No.:</label> <input
                                class='form-control' type='text' name="mobile">
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-xs-12 form-group required'>
                            <label class='control-label'>Address Line1:</label> <input
                                class='form-control' type='text' name="address1">
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-xs-12 form-group required'>
                            <label class='control-label'>Address Line2:</label> <input
                                class='form-control' type='text' name="address2">
                        </div>
                    </div>
                    <div class='form-group row'>
                        <div class='col-xs-12 col-md-4 form-group required'>
                            <label class='control-label'>Postcode:</label> <input
                                class='form-control' type='text' name="postcode">
                        </div>
                        <div class='col-xs-12 col-md-4 form-group required'>
                            <label class='control-label'>City:</label> <input
                                class='form-control' type='text' name="city">
                        </div>
                        <div class='col-xs-12 col-md-4 form-group required'>
                            <label class='control-label'>State:</label> <input
                                class='form-control' type='text' name="state">
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class='col-xs-12 form-group required'>
                            <label class='control-label'>Payment method:</label> 
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" value="cash">
                                <label class="form-check-label">
                                 <i class="fa fa-money"></i> Cash on delivery
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" value="card">
                                <label class="form-check-label">
                                <i class="fa fa-credit-card"></i>  Credit/Debit Card
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" value="stripe" checked>
                                <label class="form-check-label">
                                <i class="fa fa-cc-stripe"></i>  Stripe
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" value="paypal">
                                <label class="form-check-label">
                                <i class="fa fa-paypal"></i>  Paypal
                                </label>
                              </div>
                        </div>
                    </div>
                    <div class="stripe box">
                    <div class='form-group'>
                        <div class='col-xs-12 form-group card required'>
                            <label class='control-label'>Card Number</label> <input
                                autocomplete='off' class='form-control card-num' maxlength='20'
                                type='text' value="4242424242424242">
                        </div>
                    </div>

                    <div class='form-group row'>
                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                            <label class='control-label'>Expiration Month</label> <input
                                class='form-control card-expiry-month' placeholder='MM' maxlength='2'
                                type='text' value="12">
                        </div>
                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                            <label class='control-label'>Expiration Year</label> <input
                                class='form-control card-expiry-year' placeholder='YYYY' maxlength='4'
                                type='text' value="2024">
                        </div>
                        <div class='col-xs-12 col-md-4 form-group cvc required'>
                            <label class='control-label'>CVC</label> 
                            <input autocomplete='off' class='form-control card-cvc' placeholder='e.g 415' maxlength='4'
                                type='text' value="123">
                        </div>
                    </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-xs-12 form-group'>
                            <label class='control-label'>Remark:(optional)</label> <input
                                class='form-control' type='text' name="notes">
                        </div>
                    </div>
                        <div class="col-xs-12">
                            <button class="btn btn-success btn-lg btn-block" type="submit">Place Order</button>
                            <a href="{{url('cart')}}" class="btn btn-secondary btn-lg btn-block">Cancel</a>
                        </div>
                      
                </form>
            </div>
        </div>        
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    $(function() {
        var $form         = $(".validation");
      $('form.validation').bind('submit', function(e) {
        var $form         = $(".validation"),
            inputVal = ['input[type=email]', 'input[type=password]',
                             'input[type=text]', 'input[type=file]',
                             'textarea'].join(', '),
            $inputs       = $form.find('.required').find(inputVal),
            $errorStatus = $form.find('div.error'),
            valid         = true;
            $errorStatus.addClass('hide');
     
            $('.has-error').removeClass('has-error');
        $inputs.each(function(i, el) {
          var $input = $(el);
          if ($input.val() === '') {
            $input.parent().addClass('has-error');
            $errorStatus.removeClass('hide');
            e.preventDefault();
          }
        });
      
        if (!$form.data('cc-on-file')) {
          e.preventDefault();
          Stripe.setPublishableKey($form.data('stripe-publishable-key'));
          Stripe.createToken({
            number: $('.card-num').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $('.card-expiry-month').val(),
            exp_year: $('.card-expiry-year').val()
          }, stripeHandleResponse);
        }
      
      });
      
      function stripeHandleResponse(status, response) {
            if (response.error) {
                $('.error')
                    .removeClass('hide')
                    .find('.alert')
                    .text(response.error.message);
            } else {
                var token = response['id'];
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }

        $('input[type="radio"]').click(function(){
        var inputValue = $(this).attr("value");
        var targetBox = $("." + inputValue);
        $(".box").not(targetBox).hide();
        $(targetBox).show();
    });
    });
</script>
@endsection