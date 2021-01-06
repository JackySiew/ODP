@extends('layouts.panel')

@section('title')
    Search Report
@endsection

@section('content')
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
                        <option value="January">January</option>
                        <option value="February">February</option>
                        <option value="March">March</option>
                        <option value="April">April</option>
                        <option value="May">May</option>
                        <option value="June">June</option>
                        <option value="July">July</option>
                        <option value="August">August</option>
                        <option value="September">September</option>
                        <option value="October">October</option>
                        <option value="November">November</option>
                        <option value="December">December</option>
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

@endsection