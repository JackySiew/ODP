@extends('layouts.panel2')

@section('title')
Dashboard
@endsection

@section('content')
<div class="row">
  <div class="col-lg-4">
    <div class="card card-chart">
      <div class="card-header">
        <h5 class="card-category">Users</h5>
        <h4 class="card-title">All users</h4>
        <div class="dropdown">
          <button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
            <i class="now-ui-icons loader_gear"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
            <a class="dropdown-item text-danger" href="#">Remove Data</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        {!! $chartjs2->render() !!}
      </div>
      <div class="card-footer">
        <div class="stats">
          <i class="now-ui-icons arrows-1_refresh-69"></i> Just Updated
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card card-chart">
      <div class="card-header">
        <h5 class="card-category">Products Sales</h5>
        <h4 class="card-title">Sales Report</h4>
        <div class="dropdown">
          <button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
            <i class="now-ui-icons loader_gear"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
            <a class="dropdown-item text-danger" href="#">Remove Data</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        {!! $chartjs->render() !!}
      </div>
      <div class="card-footer">
        <div class="stats">
          <i class="now-ui-icons arrows-1_refresh-69"></i> Just Updated
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card card-chart">
      <div class="card-header">
        <h5 class="card-category">Rates & Reviews</h5>
        <h4 class="card-title">Reviews & Star Rates</h4>
        <div class="dropdown">
          <button type="button" class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret" data-toggle="dropdown">
            <i class="now-ui-icons loader_gear"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
            <a class="dropdown-item text-danger" href="#">Remove Data</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        {!! $chartjs3->render() !!}
      </div>
      <div class="card-footer">
        <div class="stats">
          <i class="now-ui-icons arrows-1_refresh-69"></i> Just Updated
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
