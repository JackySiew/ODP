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
          <span class="number">3</span> <span class="percentage"><i class="fa fa-caret-up text-success"></i> 12%</span>
          <span class="info-label">Total Sales</span>
        </div>
        <div class="weekly-summary text-right">
          <span class="number">$5,758</span> <span class="percentage"><i class="fa fa-caret-up text-success"></i> 23%</span>
          <span class="info-label">Monthly Income</span>
        </div>
        <div class="weekly-summary text-right">
          <span class="number">$65,938</span> <span class="percentage"><i class="fa fa-caret-down text-danger"></i> 8%</span>
          <span class="info-label">Total Income</span>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END OVERVIEW -->
@endsection