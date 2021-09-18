@extends('layouts.panel')

@section('title')
   Customize Task Data
@endsection

@section('content')

<div class="panel col-md-12">
  <div class="panel-heading">
    <h3 class="panel-title">Customize Task Data</h3>
  </div>
  <div class="panel-body">
  <div class="table-responsive">
    <table id="dataTable" class="table table-bordered">
    <thead>
      <th>Id</th>
      <th>Description</th>
      <th>Shipping Address</th>
      <th>Amount</th>
      <th>Status</th>
      <th>Action</th>
    </thead>
    
     
      <tbody>
      @if (count($customs)>0)

      @php $no = 1; @endphp
      @foreach ($customs as $custom)
      <td>{{$no++}}</td>
      <td>
        Task ID: {{$custom->custom_number}} <br>
        @if ($custom->grand_total !=null)
          Fully Payment: 
          @if ($custom->fully_paid == true)
          <span class="badge bg-success">Is Paid</span>    
          @else
          <span class="badge bg-danger">Not Paid</span>    
          @endif
          Deposit: 
          @if ($custom->deposit_paid == true)
          <span class="badge bg-success">Is Paid</span>    
          @else
          <span class="badge bg-danger">Not Paid</span>    
          @endif
          <br>
        @endif
        Deadline: {{$custom->deadline}}
      </td>
      <td>
        {{$custom->address1}}, {{$custom->address2}}, {{$custom->postcode}} {{$custom->city}}, {{$custom->state}}
      </td>
      <td>
        @if ($custom->grand_total == null)
        The price has not been set 
        @else
        RM {{number_format($custom->grand_total,2)}}
        @endif
      </td>
      <td>
        @if ($custom->status == 'completed')
        <span class="badge bg-success">{{$custom->status}}</span>            
        @elseif ($custom->status == 'declined')
        <span class="badge bg-danger">{{$custom->status}}</span>            
        @else
        <span class="badge bg-warning">{{$custom->status}}</span>            
        @endif
      </td>
      <td>
        <div class="btn-group">
        <p><a href="{{url('atask/'.$custom->id)}}" class="btn btn-primary">View</a></p>
      </div>
      </td>
      @endforeach
      @else
      <div class="text-center">
        <h1>No customize task received. </h1>
      </div>  
    @endif
    </tbody>
    </table>
    </div>

  </div>
</div>

@endsection

@section('scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
  $(document).ready( function () {
  $('#dataTable').DataTable();
  });
</script>
@endsection