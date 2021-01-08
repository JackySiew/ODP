@extends('layouts.panel')

@section('title')
    Search Report
@endsection

@section('content')
@if (session('error'))
<div class="alert alert-danger">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
  <p>{{session('error')}}    
</p>
</div>
@endif
<h2>Sales Report</h2>
<div class="row">
    <div class="col-md-4">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Search by Date</h3>
            </div>
            <div class="panel-body">
                <form action="{{url('check')}}" method="POST">
                    {{ csrf_field() }}
                <label for="date">Take a date:</label>
                <input type="date" class="form-control" name="date">
                <br>
                <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Search by Month</h3>
            </div>
            <div class="panel-body">
                <form action="{{url('check')}}" method="POST">
                    {{ csrf_field() }}
                    <label for="month">Take a month</label>
                    <select class="form-control" name="month">
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                    <br>
                    <label for="year">Select a Year:</label>
                    <select name="year" class="form-control">
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                    </select>
                    <br>    
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Search by Year</h3>
            </div>
            <div class="panel-body">
                <form action="{{url('check')}}" method="POST">
                    {{ csrf_field() }}
                <label for="year">Take a Year:</label>
                <select name="year" class="form-control">
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                </select>
                <br>
                <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">Search by Designer</h3>
        </div>
        <div class="panel-body">
            <form action="{{url('check')}}" method="POST">
                {{ csrf_field() }}
            <label for="year">Take a Year:</label>
            <select name="year" class="form-control">
                <option value="2020">2020</option>
                <option value="2021">2021</option>
            </select>
            <br>
            <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

@endsection