@extends('layouts.panel')

@section('title')
Dashboard
@endsection

@section('content')
<div class="panel panel-headline">
  <div class="panel-heading">
    <h3 class="panel-title">Weekly Overview</h3>
    <p class="panel-subtitle">Period: Jan 2020 - Oct 2020</p>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-9">
        {!! $chartjs->render() !!}
      </div>
      <div class="col-md-3">
        <div class="weekly-summary text-right">
          <span class="number">{{$products}}</span> 
          <span class="info-label">Uploaded Product</span>
        </div>
        <div class="weekly-summary text-right">
          <span class="number">{{$allOrderComplete}}/{{$allOrder}} completed</span> 
          <span class="info-label">Total Order(s)</span>
        </div>
        <div class="weekly-summary text-right">
          <span class="number">{{$allTaskComplete}}/{{$allTask}} completed</span> 
          <span class="info-label">Total Customize Task(s)</span>
        </div>        
        <div class="weekly-summary text-right">
          <span class="number">RM {{number_format($totalSales,2)}}</span> 
          <span class="info-label">Total Sales</span>
        </div>
        <div class="weekly-summary text-right">
          <span class="number">RM {{number_format($totalIncome,2)}}</span> 
          <span class="info-label">Total Income</span>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END OVERVIEW -->
@endsection