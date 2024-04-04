@extends('admin.layout.layout')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Account Settings</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Update Password</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      @includeIf('admin.layout.alert')
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Update Password</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="{{ route('admin.updatePassword') }}" class="form-horizontal">@csrf
                <div class="card-body">
                  <div class="form-group row">
                    <label for="current_pwd" class="col-sm-2 col-form-label">Current Password</label>
                    <div class="col-sm-10">
                      <input name="current_pwd" type="password" class="form-control" id="current_pwd" placeholder="Current Password">
                      <span id="verifyCurrentPwd"></span>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="new_pwd" class="col-sm-2 col-form-label">New Password</label>
                    <div class="col-sm-10">
                      <input name="new_pwd" type="password" class="form-control" id="new_pwd" placeholder="New Password">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="confirm_pwd" class="col-sm-2 col-form-label">Confirm Password</label>
                    <div class="col-sm-10">
                      <input name="confirm_pwd" type="password" class="form-control" id="confirm_pwd" placeholder="Confirm Password">
                    </div>
                  </div>
                  
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-success float-right">Save</button>
                </div>
                <!-- /.card-footer -->
              </form>
            </div>
            <!-- /.card -->

          </div>
          <!--/.col (left) -->
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection

@push('bottom_js')
  <script>
      $(document).ready(function(){
          // check current admin password correct or not
          $("#current_pwd").keyup(function(){
              var current_pwd = $("#current_pwd").val();
              // alert(current_pwd);
              $.ajax({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  type: 'post',
                  url: '/admin/check-current-password',
                  data: {current_pwd: current_pwd},
                  success: function(resp) {
                      if (resp=="false") {
                          $("#verifyCurrentPwd").html("Current Password is Incorrect");
                      } else if (resp=="true"){
                          $("#verifyCurrentPwd").html("Current Password is Correct");
                      }
                  }, error: function(){
                      alert("error");
                  }
              })
          })
      })
  </script>
@endpush