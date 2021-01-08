@extends('layouts.panel')

@section('title')
   My customize tasks
@endsection

@section('content')

<div class="panel col-md-12">
  <div class="panel-heading">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    <h3 class="panel-title">Customize task data</h3>
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
      <th>Deadline</th>
      <th>Status</th>
      <th>Action</th>
    </thead>
    
      @php $no = 1; @endphp
      @foreach ($customs as $custom)
      <tbody>
      <td>{{$no++}}</td>
      <td>
        <p><b>Customize ID:</b> {{$custom->custom_number}}</p>
        <small>Ordered at: {{$custom->created_at}}</small>
      </td>
      <td>
        {{$custom->address1}}, {{$custom->address2}}, <br>{{$custom->postcode}} {{$custom->city}}, {{$custom->state}}
      </td>
      <td>
        {{$custom->deadline}}
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
        <p><a href="{{url('tasks/'.$custom->id)}}" class="btn btn-primary">View</a></p>
        @if ($custom->status == 'pending')
        <button class="btn btn-success confirm" id="accept"><i class="glyphicon glyphicon-ok"></i></button>
        <br>
        <button class="btn btn-danger confirm" id="decline"><i class="glyphicon glyphicon-remove"></i></button>
        @elseif($custom->status == 'accepted' || $custom->status == 'processing')
        {{$day->today()->diffForHumans($custom->deadline)}}
        <br>
        <button class="btn btn-success deliver" id="{{$custom->id}}">Ready to deliver</button>        
        @endif
      </div>
      </td>
    </tbody>
      @endforeach
    </table>
    </div>

<!-- Modal Accept -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Notify/Price Setup</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{url('accept/'.$custom->id)}}" method="POST">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
      <div class="modal-body">
        <div class="form-group">
          <label for="totalPrice">Total Price:</label>
          <input type="number" class="form-control" name="totalPrice" value="0.00" step="1.00" max="10000" min="0.00" required>
        </div>
        <div class="form-group">
          <label for="deposit">Deposit:</label><br>
          <input type="checkbox" name="deposit"> <span>Pay Deposit</span>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary accept" id="{{$custom->id}}">Send</button>
      </div>
    </form>
    </div>
  </div>
</div>
<!-- Modal Decline -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

        $('.confirm').on('click', function (event) {
          event.preventDefault();
          confirm = $(this).attr('id');
          if (confirm == 'accept') {
            swal({
              title: 'Are you sure?',
              text: 'The status will unable to change after update!',
              icon: 'warning',
              buttons: ["Cancel", "Yes!"],
          }).then(function(value) {
              if (value) {
                $('#exampleModal').modal("show");
              }
            });
          } else {
            swal({
              title: 'Are you sure?',
              text: 'The status will unable to change after update!',
              icon: 'warning',
              buttons: ["Cancel", "Yes!"],
          }).then(function(value) {
              if (value) {
                $('#exampleModal2').modal("show");
              }
            });
          }
      });

      $('.deliver').on('click', function (event) {
        event.preventDefault();
        id = $(this).attr('id');
        swal({
              title: 'Are you sure?',
              text: 'The status will be inform the customer and unable to change!',
              icon: 'warning',
              buttons: ["Cancel", "Yes!"],
          }).then(function(value) {
              if (value) {
                window.location = 'task-deliver/'+id;
              }
          });
      });
    });
    </script>
@endsection