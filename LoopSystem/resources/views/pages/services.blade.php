@extends('includes.admin_template')

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">

          <h1 class="m-0 text-dark"><i class="nav-icon fas fa-box"></i> Services</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Starter Page</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->





    <div class="card">
      <div class="card-header">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
          <i class="fas fa-plus mr-2"></i>Add Category
        </button>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="categories_table" class="table table-bordered table-striped">
          <thead>
           <tr>
                <th width="10%">ID</th>
                <th width="80%">Name</th>
                <th width="10%"></th>
              </tr>
          </thead>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

<!-- add items modal -->
    <div class="modal fade" id="modal-default">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-danger">
            <h4 class="modal-title">Add New Service</h4>
          </div>
          <form action="" method="POST">
          <div class="modal-body">
            <div class="form-group">
              {{ csrf_field() }}
              <label>Service Name:</label>
              <input type="text" class="form-control @error('catName') is-invalid @enderror " name="catName" id="catName" placeholder="Category Name" required>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-success" name="submit" id='categoryAddBtn' onclick="categoryAdd()">Save changes</button>
          </div>
        </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.add items modal -->


     <!-- edit item modal -->
     <div class="modal fade" id="modal-edit-category">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header btn-danger">
            <h4 class="modal-title">Edit Service</h4>
          </div>
          <form action="" method="POST">
              {{ csrf_field() }}
              {{method_field('PATCH')}}
          <div class="modal-body">
              <input type="hidden" class="form-control" id="eCatID" name="eCatID" value="" placeholder="Category Name" required>
              <div class="form-group">
              <label>Service Name:</label>
              <input type="text" class="form-control" id="eCatName" name="eCatName" placeholder="Category Name" required>
            </div>


          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-success" id="categoryEditBtn" onclick="categoryEdit()">Save changes</button>
          </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.edit item modal -->

          <!-- delete categories modal -->
    <div class="modal fade" id="modal-delete-category">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-danger">
            <h4 class="modal-title">Delete Service</h4>
          </div>
          {{-- <!-- <form action="{{route('catSoftDelete')}}" method="POST"> --> --}}
           {{ csrf_field() }}
          <div class="modal-body">
          <input type="hidden" id="dCatID" name="dCatID" class="form-control">
          <h6 style="text-align:center">Are you sure you want to delete service <label id="dCatName"></label>?</h6>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" id='categoryDelBtn' onclick='categoryDel()'>Delete</button>
          </div>
          <!-- </form> -->
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.delete item modal -->

  {{-- <script type="text/javascript">
      function categoryDel(){
          var id = $('#dCatID').val();
            $.ajax({
              type: 'POST',
              url: 'softDelCat',
              data: {'_token': $('input[name=_token').val(),
                      'dCatID': $('input[name=dCatID').val()},
              beforeSend:function(){
                  $("#categoryDelBtn").attr("disabled", true);
                  $('#categoryDelBtn').text('Deleting...');
              },
              success: function (response){
                  // setTimeout(function(){
                      $('#modal-delete-category').modal('hide');
                      $('#categories_table').DataTable().ajax.reload();
                      $("#categoryDelBtn").attr("disabled", false);
                      $('#categoryDelBtn').text('Delete');

                      if(response.ok == "Error"){
                          alert('Category "'+ $('#dCatName').html() + '" cannot be deleted.');
                      }else{
                          alert('Category "'+ $('#dCatName').html() + '" deleted successfully.');
                      }
                  // }, 2000);
              },

              error: function(err){
                  alert('Error! Deletion is not successful.');
              }
          });
      }


      function categoryEdit(){
          var url =  "editCat";
          var eCatDesc = $('#eCatDesc').val();
          var eCatName =$('#eCatName').val();
          if(eCatName == "" || eCatDesc==""){
              alert('All fields are required!');

          }else{
            $.ajax({
              type: 'POST',
              url: url,
              data: {
                      '_token': $('input[name=_token').val(),
                      'eCatID':$('input[name=eCatID').val(),
                      'eCatName': eCatName,
                      'eCatDesc': eCatDesc
                      },
              beforeSend:function(){
                  $('#categoryEditBtn').text('Updating...');
              },
              success: function (data){
                  // setTimeout(function(){
                      $('#modal-edit-category').modal('hide');
                      $('#categories_table').DataTable().ajax.reload();
                      $('#categoryEditBtn').text('Save Changes');
                      alert('Category updated successfully');
                  // }, 2000);
              },
              error: function(err){
                  alert('Error! Update unsuccessful');
              }
          });
      }
      }


      function categoryAdd(){
          var catDesc = $('#catDesc').val();
          if(catDesc == "" || $('#catName').val()==""){
              alert('All Fields are required!');
          }else{
          $.ajax({
              type: 'POST',
              url: "{{ route('categoryInsert') }}",
              data: {
                      '_token': $('input[name=_token').val(),
                      'catName':$('input[name=catName').val(),
                      'catDesc': catDesc
                      },
              beforeSend:function(){
                  $('#categoryAddBtn').text('Inserting...');
              },
              success: function (response){
                  // setTimeout(function(){
                      $('#modal-default').modal('hide');
                      $('#categories_table').DataTable().ajax.reload();
                      $('#categoryAddBtn').text('Save Changes');
                  // }, 2000);
              },
              error: function(err){
                  alert('Error! Category Name Exists!')
              }
          });
      }
      }
  </script> --}}

 @endsection


