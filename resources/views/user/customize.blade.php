@extends('layouts.app')
@section('title')
    All Products
@endsection
@section('class')
container
@endsection
@section('content')

<div class="row">
    <div class="col-md-3">
        <div class="panel panel-default">
            <img src="/storage/image/{{$product->prodImage}}" class="img-fluid mb-3">
            <p><b>{{$product->prodName}}</b></p>
        </div>
    </div>
    <div class="offset-md-1 col-md-8">
        <div class="panel panel-default">
            <div class="panel-body">
                @if (session('error'))
                <div class="alert alert-danger text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                </div>
                @else
                <div class="alert alert-success text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                    <p>To make a request for customize products, You have to insert all the details below.</p>
                    <p>Besides, we will request to pay a deposit to customize the product when the request is accept.</p>
                    <p>!! Make sure you have communicate with the product designers. !!</p>
                </div>
                @endif
                <h3 class="text-center">User Details</h3>
                <form role="form" action="{{ route('customize.store') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="prodid" value="{{$product->id}}">
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
                            <label class='control-label'>Address line 1:</label> <input
                                class='form-control' type='text' name="address1">
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-xs-12 form-group required'>
                            <label class='control-label'>Address line 2:</label> <input
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
                        <div class='col-xs-12 form-group'>
                            <label class='control-label'>Description:</label> 
                            <textarea class="ckeditor form-control" name="description"></textarea>
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class='col-xs-12 form-group'>
                            <label class='control-label'>Quantity:</label> 
                            <input type="number" class="form-control" name="quantity" min="1" max="10">
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class='col-xs-12 form-group'>
                            <label class='control-label'>Deadline:</label> 
                            <input type="date" name="deadline" id="deadline" class="form-control">
                        </div>
                    </div>
                        <div class="col-xs-12">
                            <button class="btn btn-success btn-lg btn-block" type="submit">Send Request</button>
                            <a href="{{url('all-products')}}" class="btn btn-secondary btn-lg btn-block">Cancel</a>
                        </div>
                      
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>
  $(document).ready(function () {
      $('.ckeditor').ckeditor();
  });
</script>
@endsection