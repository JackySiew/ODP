@extends('layouts.panel')

@section('title')
   Designer Sales Report
@endsection

@section('content')
<div class="panel col-md-12">
    <div class="panel-heading">
      @foreach ($designer as $user)    
        <h3> {{$user->name}}'s sales data</h3>
        <a href="{{url('sales-pdf')}}" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Download PDF</a>  
        <a href="{{url('report')}}" class="btn btn-primary">Go back</a>
      @endforeach
    </div>
  <div class="panel-body">
    <table class="table table-bordered">
      <thead>
        <th>Total Orders</th>
        <th>Total Tasks</th>
        <th>Total Sales</th>
        <th>Total Income</th>
        <th>Payment Pending</th>
      </thead>
      <tbody>
        <tr>
          <td>
            @if (count($orders) > 0)
              {{$ordercompleted}}/ {{count($orders)}} completed
            @else
              No order received
            @endif       
            </td>   
          <td>
            @if (count($tasks) > 0)
              {{$taskcompleted}}/ {{count($tasks)}} completed
            @else
              No customize task received
            @endif       
          </td>   
          <td>RM {{number_format($totalSales,2)}}</td>
          <td>RM {{number_format($totalIncome,2)}}</td>
          <td>RM {{number_format($paymentPending,2)}}</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
@endsection

@section('scripts')
    <script>
      $(document).ready( function () {
      $('#dataTable').DataTable();
      });
    </script>
@endsection