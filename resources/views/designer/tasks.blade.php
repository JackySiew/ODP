@extends('layouts.panel')

@section('title')
   My customize tasks
@endsection

@section('content')
@if (session('status'))
<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
  {{ session('status') }}
</div>
@endif

<div class="panel col-md-12">
  <div class="panel-heading">
    <h3 class="panel-title">Customize task data</h3>
  </div>
  <div class="panel-body">
    <div class="table-responsive">
    @if (count($customs)>0)
    <table id="dataTable" class="table">
    <thead>
      <th>Id</th>
      <th>Task Description</th>
      <th>Shipping Address</th>
      <th>Payment Remark</th>
      <th>Status</th>
      <th>Action</th>
    </thead>
    
      @php $no = 1; @endphp
      @foreach ($customs as $custom)
      <tbody>
      <td>{{$no++}}</td>
      <td>
        <b>Task ID:</b> {{$custom->custom_number}} <br>
        <b>Deadline:</b> {{$custom->deadline}} <br>
        <div class="badge bg-danger">{{$day->today()->diffForHumans($custom->deadline)}}</div><br>
        <br><small>Ordered at: {{$custom->created_at}}</small>
      </td>
      <td>
        {{$custom->address1}}, {{$custom->address2}}, <br>{{$custom->postcode}} {{$custom->city}}, {{$custom->state}}
      </td>
      <td>
        <b>Amount Set:</b> RM {{number_format($custom->grand_total,2)}} 
        @if ($custom->fully_paid == true)
          <span class="badge bg-success">Is paid</span><br>
        @else
          <span class="badge bg-danger">Not paid</span> <br>
        @endif
        <br>
        <b>Deposit:</b> RM {{number_format($custom->deposit,2)}} <br>
        @if ($custom->deposit_paid == true)
          <span class="badge bg-success">Is paid</span><br>
        @else
          <span class="badge bg-danger">Not paid</span> <br>
        @endif

      </td>
      <td>
        @if ($custom->status == 'completed' || $custom->status == 'accepted')
        <span class="badge bg-success">{{$custom->status}}</span>            
        @elseif ($custom->status == 'declined' && $custom->notes != null)
        <span class="badge bg-danger">{{$custom->status}}</span>            
        @elseif ($custom->status == 'declined' && $custom->notes == null)
        <span class="badge bg-danger">{{$custom->status}} by customer</span>            
        @else
        <span class="badge bg-warning">{{$custom->status}}</span>            
        @endif
      </td>
      <td>
        <div class="btn-group">
        <p><a href="{{url('tasks/'.$custom->id)}}" class="btn btn-primary">View</a></p>
        @if ($custom->status == 'pending')
        <button class="btn btn-success confirm" id="accept" data-task="{{$custom->id}}"><i class="glyphicon glyphicon-ok"></i></button>
        <br>
        <button class="btn btn-danger confirm" id="decline" data-task="{{$custom->id}}"><i class="glyphicon glyphicon-remove"></i></button>
        @elseif($custom->status == 'accepted')
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
      <form action="{{url('accept')}}" method="POST">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <input type="hidden" name="id" id="taskID">
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
        <button type="submit" class="btn btn-primary">Send</button>
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
      <form action="{{url('decline')}}" method="POST">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <input type="hidden" name="id" id="taskID">
      <div class="modal-body">
          <div class="form-group">
            <label for="notes">Reasons:*</label>
            <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
          </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Send</button>
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
          taskID = $(this).data('task');
          if (confirm == 'accept') {
            swal({
              title: 'Are you sure?',
              text: 'The status will unable to change after update!',
              icon: 'warning',
              buttons: ["Cancel", "Yes!"],
          }).then(function(value) {
              if (value) {
                $('#exampleModal').modal("show");
                $('#exampleModal').find("#taskID").val(taskID);
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
                $('#exampleModal2').find("#taskID").val(taskID);
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
                swal({
                icon: 'success',
                title: 'Status Updated!',
                text: 'The status is updated and informed to the customer!',
                buttons: true,
                }).then(function(value){
                  window.location = 'task-deliver/'+id;
                });
              }
          });
      });
    });
    </script>
@endsection