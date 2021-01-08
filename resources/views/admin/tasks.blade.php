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
    @if (session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
    @endif

    <div class="table-responsive">
    @if (count($customs)>0)
    <table id="dataTable" class="table">
    <thead>
      <th>Id</th>
      <th>Task Number</th>
      <th>Shipping Address</th>
      <th>Order Date</th>
      <th>Status</th>
      <th>Action</th>
    </thead>
    
      @php $no = 1; @endphp
      @foreach ($customs as $custom)
      <tbody>
      <td>{{$no++}}</td>
      <td>
        <p>{{$custom->custom_number}}</p>
      </td>
      <td>
        {{$custom->address1}}, {{$custom->address2}}, {{$custom->postcode}} {{$custom->city}}, {{$custom->state}}
      </td>
      <td>
        {{$custom->created_at}}
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
    </tbody>
      @endforeach
    </table>
    </div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Decline Reason</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{url('decline/'.$custom->id)}}" method="POST">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
      <div class="modal-body">
          <div class="form-group">
            <label for="notes">Reasons:*</label>
            <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
          </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary decline" id="{{$custom->id}}">Send</button>
      </div>
    </form>
    </div>
  </div>
</div>
    @else
    <div class="text-center">
      <h1>You don't have any task for now! =="</h1>
      </div>  
    @endif
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