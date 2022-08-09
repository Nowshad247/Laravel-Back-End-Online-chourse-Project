@extends('Layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 m-4">
                <table class="table table-striped table-bordered d-none" id='mainDiv' cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th class="th-sm">ID</th>
                        <th class="th-sm">Number</th>
                        <th class="th-sm">Phone</th>
                        <th class="th-sm">Email</th>
                        <th class="th-sm">Text</th>
                        <th class="th-sm">Delete</th>
                      </tr>
                    </thead>
                    <tbody id="service_table">
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 text-center p-5" id="loaderDiv">
      <img class="loading-icon m-5" src="{{asset('images/loding.gif')}}">
  </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body p-3 text-center">
            <h5 class="mt-4">Do You Want To Delete?</h5>
            <h5 id="serviceDeleteId" class="mt-4 d-none">   </h5>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">No</button>
            <button  id="serviceDeleteConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Yes</button>
          </div>
        </div>
      </div>
    </div>
@endsection
@section('scripts')
<script>
      getdata();
      function getdata(){
        axios.post('/contacts')
        .then(function (response) {
          
          $('#mainDiv').DataTable().destroy();
          var tableTd = document.getElementById('service_table') ;
           tableTd.innerHTML = ' ' ;

         if(response.status == 200){
          $('#mainDiv').removeClass('d-none');
           $('#loaderDiv').addClass('d-none');
          var jsonData = response.data;
          $.each(jsonData, function(i, item) {
                    $('<tr>').html(
                        "<td>"+jsonData[i].id+"</td>" +
                        "<td>"+jsonData[i].contact_name+"</td>" +
                        "<td>"+jsonData[i].contact_mobile+"</td>" +
                        "<td>"+jsonData[i].contact_email+"</td>" +
                        "<td>"+jsonData[i].contact_msg+"</td>" +     
                        "<td><a  class='serviceDeleteBtn' data-id=" +jsonData[i].id +" ><i class='fas fa-trash-alt'></i></a></td>"
                    ).appendTo('#service_table');
                });
                //Data Table 
                $('#mainDiv').DataTable({
        order: [[3, 'desc']],
    });
                $('.dataTables_length').addClass('bs-select');
                // Services Table Delete Icon Click
                $('.serviceDeleteBtn').click(function() {
                    var id = $(this).data('id');
                    $('#serviceDeleteId').html(id);
                    $('#deleteModal').modal('show');

                })
                $('.courseEditBtn').click(function(){
                  var id = $(this).data('id');
                    $('#courseEditId').html(id);
                    CourseUpdateDetails(id);
                  $('#EditModal').modal('show');
          });
         }
        })
        .catch(function (error) {
          console.log(error);
        })
        .then(function () {
        });
      }
// Services Delete Modal Yes Btn
$('#serviceDeleteConfirmBtn').click(function() {
  var id = $('#serviceDeleteId').html();
      ServiceDelete(id);
    })
    function ServiceDelete(deleteID){
      $('#serviceDeleteConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") 
      axios.post('/contactsDelete', {
          id: deleteID
      })
      .then(function(response) {
          $('#serviceDeleteConfirmBtn').html("Yes");
          if(response.status==200){
          if (response.data == 1) {
              $('#deleteModal').modal('hide');
              toastr.success('Delete Success');
              getdata();
          } else {
              $('#deleteModal').modal('hide');
              toastr.error('Delete Fail');
              getdata();
          }

          }
          else{
           $('#deleteModal').modal('hide');
           toastr.error('Something Went Wrong !');
          }

      })
      .catch(function(error) {
           $('#deleteModal').modal('hide');
           toastr.error('Something Went Wrong !');
       });

}


</script>
@endsection