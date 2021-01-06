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
<div class="row">
  <div class="col-md-7">
    <!-- TODO LIST -->
    <div class="panel">
      <div class="panel-heading">
        <h3 class="panel-title">To-Do List</h3>
        <div class="right">
          <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
          <button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
        </div>
      </div>
      <div class="panel-body">
        <ul class="list-unstyled todo-list">
          <li>
            <label class="control-inline fancy-checkbox">
              <input type="checkbox"><span></span>
            </label>
            <p>
              <strong>Functional Spec Meeting</strong>
              <span class="short-description">Monotonectally formulate client-focused core competencies after parallel web-readiness.</span>
              <span class="date">Oct 11, 2016</span>
            </p>
            <div class="controls">
              <a href="#"><i class="icon-software icon-software-pencil"></i></a> <a href="#"><i class="icon-arrows icon-arrows-circle-remove"></i></a>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <!-- END TODO LIST -->
  </div>
</div>
@endsection