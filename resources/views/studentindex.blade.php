<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>
<body>

<div class="container">
    <a class="btn btn-success" href="javascript:void(0)" id="createNewStudent"> Create New Student</a>
    <div class="input-group input-daterange">

        <input type="date" name="from_date" id="from_date" class="form-control" />
        <div class="input-group-addon">to</div>
        <input type="date"  name="to_date" id="to_date" class="form-control" />

    </div>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile Number</th>
                <th>Birth date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div class="modal fade" id="studModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                </div>
            @endif
            <div class="modal-body">
                <form id="studentForm" name="studentForm" class="form-horizontal">
                   <input type="hidden" name="student_id" id="student_id">
                    {{-- name --}}
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" placeholder="Enter Name" id="name" name="name" value="" required="">
                        </div>
                    </div>

                    {{-- email  --}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-12">
                            <input type="email" class="form-control"  placeholder="Enter Email" id="email" name="email" value="" required="">

                        </div>
                    </div>
                    {{-- password  --}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-12">
                            <input type="password" id="password" name="password" required="" placeholder="Enter Password" class="form-control">
                        </div>
                    </div>
                    {{-- mobile  --}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Mobile</label>
                        <div class="col-sm-12">
                            <input type="number" id="phone" name="phone" required="" placeholder="Enter Mobile Number" class="form-control">
                        </div>
                    </div>
                    {{-- Birth_Date  --}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Birth_Date</label>
                        <div class="col-sm-12">
                            <input type="date" id="dob" name="dob" required="" placeholder="Enter Birth Date" class="form-control">
                        </div>
                    </div>
                    {{-- City  --}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">City</label>
                        <div class="col-sm-12">
                            <input id="city" name="city" required="" placeholder="Enter City" class="form-control">
                        </div>
                    </div>
                    {{-- State  --}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">State</label>
                        <div class="col-sm-12">
                            <input id="state" name="state" required="" placeholder="Enter State" class="form-control">
                        </div>
                    </div>
                    {{-- Country  --}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Country</label>
                        <div class="col-sm-12">
                            <input id="country" name="country" required="" placeholder="Enter Country" class="form-control">
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>

<script type="text/javascript">
  $(function () {

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('student.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'dob', name: 'dob'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('#createNewStudent').click(function () {
        $('#saveBtn').val("create-student");
        $('#student_id').val('');
        $('#studentForm').trigger("reset");
        $('#modelHeading').html("Create New Student");
        $('#studModel').modal('show');
    });

    $('body').on('click', '.editbtn', function () {
      var student_id = $(this).data('id');
      $.get("{{ route('student.index') }}" +'/' + student_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Student");
          $('#saveBtn').val("edit-user");
          $('#studModel').modal('show');
          $('#student_id').val(data.id);
          $('#name').val(data.name);
          $('#email').val(data.email);
          $('#password').val(data.password);
          $('#phone').val(data.phone);
          $('#dob').val(data.dob);
          $('#city').val(data.city);
          $('#state').val(data.state);
          $('#country').val(data.country);
      })
   });

    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');

        $.ajax({
          data: $('#studentForm').serialize(),
          url: "{{ route('student.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {

              $('#studentForm').trigger("reset");
              $('#studModel').modal('hide');
              table.draw();

          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });

    $('body').on('click', '.deletebtn', function () {

        var student_id = $(this).data("id");
        confirm("Are You sure want to delete !");

        $.ajax({
            type: "DELETE",
            url: "{{ route('student.store') }}"+'/'+student_id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

  });
</script>


<script>
    $(document).ready(function(){

     var date = new Date();

     $('.input-daterange').datepicker({
      todayBtn: 'linked',
      format: 'yyyy-mm-dd',
      autoclose: true
     });

     var _token = $('input[name="_token"]').val();

     fetch_data();

     function fetch_data(from_date = '', to_date = '')
     {
      $.ajax({
       url:"{{ route('filter') }}",
       method:"GET",
       data:{from_date:from_date, to_date:to_date, _token:_token},
       dataType:"json",
       success:function(data)
       {
        table.draw();
       }
      })
     }

     $('#filter').click(function(){
      var from_date = $('#from_date').val();
      var to_date = $('#to_date').val();
      if(from_date != '' &&  to_date != '')
      {
       fetch_data(from_date, to_date);
      }
      else
      {
       alert('Both Date is required');
      }
     });

     $('#refresh').click(function(){
      $('#from_date').val('');
      $('#to_date').val('');
      fetch_data();
     });


    });
    </script>
</html>
