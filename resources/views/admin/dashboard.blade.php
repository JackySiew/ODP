@extends('layouts.panel')

@section('title')
Dashboard
@endsection

@section('content')
<div class="panel panel-headline">
  <div class="panel-heading">
    <h3 class="panel-title">Sales Overview</h3>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-9">
        {!! $chartjs->render() !!}
      </div>
      <div class="col-md-3">
        <div class="weekly-summary text-right">
          <span class="number">{{count($orders)}} / {{count($tasks)}}</span> 
          {{-- <span class="percentage"><i class="fa fa-caret-up text-success"></i> 12%</span> --}}
          <span class="info-label">Total Orders / Customize Tasks</span>
        </div>
        <div class="weekly-summary text-right">
          <span class="number"></span> 
          {{-- <span class="percentage"><i class="fa fa-caret-up text-success"></i> 12%</span> --}}
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

<div class="row">
  <div class="col-lg-4">
    <div class="panel panel-chart">
      <div class="panel-heading">
        <h3 class="panel-title">Users</h3>
        <p class="panel-subtitle">All users</p>
      </div>
        <div class="panel-body">
        {!! $chartjs2->render() !!}
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="panel panel-chart">
      <div class="panel-heading">
        <h5 class="panel-title">Rates & Reviews</h5>
        <h4 class="panel-subtitle">Reviews & Star Rates</h4>
      </div>
      <div class="panel-body">
        {!! $chartjs3->render() !!}
      </div>
    </div>
  </div>
</div>
@endsection
