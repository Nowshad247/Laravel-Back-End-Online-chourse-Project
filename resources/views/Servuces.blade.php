@extends('Layouts.app')
@section('content')
<div class="container">
    <div class="row">
    <div class="col-md-12 p-5">
      <button id="addNewBtnId" class="btn my-3 btn-sm btn-danger">Add New </button>

        <table class="table table-striped table-bordered d-none" id='mainDiv' cellspacing="0" width="100%">
            <thead>
              <tr>
                <th class="th-sm">Image</th>
                <th class="th-sm">Name</th>
                <th class="th-sm">Description</th>
                <th class="th-sm">Edit</th>
                <th class="th-sm">Delete</th>
              </tr>
            </thead>
            <tbody id="service_table">
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div id="loaderDiv" class="container">
      <div class="row">
      <div class="col-md-12 text-center p-5">
          <img class="loading-icon m-5" src="{{asset('images/loding.gif')}}">
      </div>
      </div>
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
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body p-5 text-center">
          <div id="serviceAddForm" class=" w-100">
         <h6 class="mb-4">Add New Service</h6>  
          <input id="serviceNameAddID" type="text" id="" class="form-control mb-4" placeholder="Service Name">
          <input id="serviceDesAddID" type="text" id="" class="form-control mb-4" placeholder="Service Description">
          <input id="serviceImgAddID" type="text" id="" class="form-control mb-4" placeholder="Service Image Link">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
        <button  id="serviceAddConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Save</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
  <div class="modal-header">
      <h5 class="modal-title">Update Service</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body p-4 text-center">
        <h5 id="serviceEditId" class="mt-4 d-none">   </h5>
        <div id="serviceEditForm" class="d-none w-100">
        <input id="serviceNameID" type="text" id="" class="form-control mb-4" placeholder="Service Name">
        <input id="serviceDesID" type="text" id="" class="form-control mb-4" placeholder="Service Description">
        <input id="serviceImgID" type="text" id="" class="form-control mb-4" placeholder="Service Image Link">
        </div>

        <img id="serviceEditLoader" class="loading-icon m-5" src="{{asset('images/loding.gif')}}">
        <h5 id="serviceEditWrong" class="d-none">Something Went Wrong !</h5>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
      <button  id="serviceEditConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Save</button>
    </div>
  </div>
</div>
</div>




    @endsection
@section('scripts')
    <script>
      getdata();
      function getdata(){
        axios.get('/getServiceData')
        .then(function (response) {
          var tableTd = document.getElementById('service_table') ;
           tableTd.innerHTML = ' ' ;
         if(response.status == 200){
           $('#mainDiv').removeClass('d-none');
           $('#loaderDiv').addClass('d-none');
          var jsonData = response.data;
          $.each(jsonData, function(i, item) {
                    $('<tr>').html(
                        "<td><img class='table-img' src=" + jsonData[i].service_img + "></td>" +
                        "<td>" + jsonData[i].service_name + "</td>" +
                        "<td>" + jsonData[i].service_des + "</td>" +
                        "<td id='addEditbtn'><a  class='serviceEditBtn'  data-id=" + jsonData[i].id + "><i class='fas fa-edit'></i></a></td>" +
                        "<td><a  class='serviceDeleteBtn'  data-id=" + jsonData[i].id +" ><i class='fas fa-trash-alt'></i></a></td>"
                    ).appendTo('#service_table');
                });
                // Services Table Delete Icon Click
                $('.serviceDeleteBtn').click(function() {
                    var id = $(this).data('id');
                    $('#serviceDeleteId').html(id);
                    $('#deleteModal').modal('show');

                })
                $('.serviceEditBtn').click(function(){
                  var id = $(this).data('id');
                    $('#serviceEditId').html(id);
                    ServiceUpdateDetails(id);
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
        axios.post('/deleteServices', {
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
$('#addNewBtnId').click(function(){
   $('#addModal').modal('show');
});



// Services Table Edit Icon Click
function ServiceUpdateDetails(detailsID) {
    axios.post('/ServiceDetails', {
            id: detailsID
        })
        .then(function(response) {
                if(response.status==200){
                    $('#serviceEditForm').removeClass('d-none');
                    $('#serviceEditLoader').addClass('d-none');
                    var jsonData = response.data;
                    $('#serviceNameID').val(jsonData[0].service_name);
                    $('#serviceDesID').val(jsonData[0].service_des);
                    $('#serviceImgID').val(jsonData[0].service_img);
                }
                else{
                   $('#serviceEditLoader').addClass('d-none');
                   $('#serviceEditWrong').removeClass('d-none');
                }
    })
    .catch(function(error) {
                  $('#serviceEditLoader').addClass('d-none');
                  $('#serviceEditWrong').removeClass('d-none');
   });

}
               
// Services Edit Modal Save Btn
$('#serviceAddConfirmBtn').click(function() {
    var name = $('#serviceNameAddID').val();
    var des = $('#serviceDesAddID').val();
    var img = $('#serviceImgAddID').val();
    ServiceAdd(name,des,img);
})
function ServiceAdd(serviceName,serviceDes,serviceImg){
  if(serviceName.length==0){
     toastr.error('Service Name is Empty !');
    }
    else if(serviceDes.length==0){
     toastr.error('Service Description is Empty !');
    }
    else if(serviceImg.length==0){
      toastr.error('Service Image is Empty !');
    }
    else{
    $('#serviceAddConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
    axios.post('/ServiceAdd', {
            name: serviceName,
            des: serviceDes,
            img: serviceImg,
        })
        .then(function(response) {
            $('#serviceAddConfirmBtn').html("Save");
            if(response.status==200){
              if (response.data == 1) {
                $('#addModal').modal('hide');
                toastr.success('Add Success');
                getdata();
            } else {
                $('#addModal').modal('hide');
                toastr.error('Add Fail');
                getdata();
            }  
         } 
         else{
             $('#addModal').modal('hide');
             toastr.error('Something Went Wrong !');
         }   

    })
    .catch(function(error) {
             $('#addModal').modal('hide');
             toastr.error('Something Went Wrong !');
   });

}
}
// Services Edit Modal Save Btn
$('#serviceEditConfirmBtn').click(function() {
    var id = $('#serviceEditId').html();
    var name = $('#serviceNameID').val();
    var des = $('#serviceDesID').val();
    var img = $('#serviceImgID').val();
    ServiceUpdate(id,name,des,img);
})


function ServiceUpdate(serviceID,serviceName,serviceDes,serviceImg) {
  
  if(serviceName.length==0){
   toastr.error('Service Name is Empty !');
  }
  else if(serviceDes.length==0){
   toastr.error('Service Description is Empty !');
  }
  else if(serviceImg.length==0){
    toastr.error('Service Image is Empty !');
  }
  else{
  $('#serviceEditConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
  axios.post('/ServiceUpdate', {
          id: serviceID,
          name: serviceName,
          des: serviceDes,
          img: serviceImg,

      })
      .then(function(response) {
          $('#serviceEditConfirmBtn').html("Save");

          if(response.status==200){

            if (response.data == 1) {
              $('#EditModal').modal('hide');
              toastr.success('Update Success');

              getdata();

          } else {
              $('#editModal').modal('hide');
              toastr.error('Update Fail');
              getdata();
          }  
       } 
       else{
          $('#editModal').modal('hide');
           toastr.error('Something Went Wrong !');
       }   

      
  })
  .catch(function(error) {
      $('#editModal').modal('hide');
      toastr.error('Something Went Wrong !',+error);
 });

}

}



    </script>
@endsection