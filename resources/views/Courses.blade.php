@extends('Layouts.app')
@section('content')
<div class="container">
    <div class="row">
    <div class="col-md-12 p-5">
      <button id="addNewBtnId" class="btn my-3 btn-sm btn-danger">Add New </button>

        <table class="table table-striped table-bordered d-none" id='mainDiv' cellspacing="0" width="100%">
            <thead>
              <tr>
                <th class="th-sm">Name</th>
                <th class="th-sm">Fee</th>
                <th class="th-sm">Class</th>
                <th class="th-sm">Enroll</th>
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
         <div class="container">
          <div class="row">
            <div class="col-md-6">
                <input id="CourseNameId" type="text" id="" class="form-control mb-3" placeholder="Course Name">
                <input id="CourseDesId" type="text" id="" class="form-control mb-3" placeholder="Course Description">
            <input id="CourseFeeId" type="text" id="" class="form-control mb-3" placeholder="Course Fee">
            <input id="CourseEnrollId" type="text" id="" class="form-control mb-3" placeholder="Total Enroll">
            </div>
            <div class="col-md-6">
            <input id="CourseClassId" type="text" id="" class="form-control mb-3" placeholder="Total Class">      
            <input id="CourseLinkId" type="text" id="" class="form-control mb-3" placeholder="Course Link">
            <input id="CourseImgId" type="text" id="" class="form-control mb-3" placeholder="Course Image">
            </div>
          </div>
        </div>
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
      <h5 id="courseEditId" class="mt-4 d-none">  </h5>
      <div id="courseEditForm" class="container d-none">
          <div class="row">
            <div class="col-md-6">
            <input id="CourseNameUpdateId" type="text" id="" class="form-control mb-3" placeholder="Course Name">
            <input id="CourseDesUpdateId" type="text" id="" class="form-control mb-3" placeholder="Course Description">
            <input id="CourseFeeUpdateId" type="text" id="" class="form-control mb-3" placeholder="Course Fee">
            <input id="CourseEnrollUpdateId" type="text" id="" class="form-control mb-3" placeholder="Total Enroll">
            </div>
            <div class="col-md-6">
            <input id="CourseClassUpdateId" type="text" id="" class="form-control mb-3" placeholder="Total Class">      
            <input id="CourseLinkUpdateId" type="text" id="" class="form-control mb-3" placeholder="Course Link">
            <input id="CourseImgUpdateId" type="text" id="" class="form-control mb-3" placeholder="Course Image">
            </div>
          </div>
        </div>

        <img id="courseEditLoader" class="loading-icon m-5" src="{{asset('images/loding.gif')}}">
        <h5 id="courseEditWrong" class="d-none">Something Went Wrong !</h5>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
      <button  id="CourseUpdateConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Save</button>
    </div>
  </div>
</div>
</div>




    @endsection
@section('scripts')
    <script>
      getdata();
      function getdata(){
        axios.get('/CoursesList')
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
                        "<td>"+jsonData[i].course_name+"</td>" +
                        "<td>"+jsonData[i].course_fee+"</td>" +
                        "<td>"+jsonData[i].course_totalclass+"</td>" +
                        "<td>"+jsonData[i].course_totalenroll+"</td>" +     
                        "<td><a  class='courseEditBtn' data-id=" + jsonData[i].id + "><i class='fas fa-edit'></i></a></td>" +
                        "<td><a  class='serviceDeleteBtn'  data-id=" + jsonData[i].id +" ><i class='fas fa-trash-alt'></i></a></td>"
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
                    $('#serviceEditId').html(id);
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
        axios.post('/ChourseDelete', {
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
function CourseUpdateDetails(detailsID) {
    axios.post('/CourseDetails', {
            id: detailsID
        })
        .then(function(response) {
          console.log(response);
                if(response.status==200){
                  $('#courseEditForm').removeClass('d-none');
                        $('#courseEditLoader').addClass('d-none');    
                        var jsonData = response.data;
                        $('#CourseNameUpdateId').val(jsonData[0].course_name);
                        $('#CourseDesUpdateId').val(jsonData[0].course_des);
                        $('#CourseFeeUpdateId').val(jsonData[0].course_fee);
                        $('#CourseEnrollUpdateId').val(jsonData[0].course_totalenroll);
                        $('#CourseClassUpdateId').val(jsonData[0].course_totalclass);
                        $('#CourseLinkUpdateId').val(jsonData[0].course_link);
                        $('#CourseImgUpdateId').val(jsonData[0].course_img);
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
  var CourseName=$('#CourseNameId').val();
  var CourseDes=$('#CourseDesId').val();
  var CourseFee=$('#CourseFeeId').val();
  var CourseEnroll=$('#CourseEnrollId').val();    
  var CourseClass=$('#CourseClassId').val();
  var CourseLink=$('#CourseLinkId').val();
  var CourseImg=$('#CourseImgId').val();
    CourseAdd(CourseName,CourseDes,CourseFee,CourseEnroll,CourseClass,CourseLink,CourseImg);
})
function CourseAdd(CourseName,CourseDes,CourseFee,CourseEnroll,CourseClass,CourseLink,CourseImg){
  if(CourseName.length==0){
     toastr.error('Course Name is Empty !');
    }
    else if(CourseDes.length==0){
     toastr.error('Course Description is Empty !');
    }
    else if(CourseFee.length==0){
      toastr.error('Course Fee is Empty !');
    }
    else if(CourseEnroll.length==0){
      toastr.error('Course Enroll is Empty !');
    }
    else if(CourseClass.length==0){
      toastr.error('Course Class is Empty !');
    }
    else if(CourseLink.length==0){
      toastr.error('Course Link is Empty !');
    }
    else if(CourseImg.length==0){
      toastr.error('Course Image is Empty !');
    }
    else{
    $('#serviceAddConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
    axios.post('/CourseAdd', {
            course_name: CourseName,
            course_des: CourseDes,
            course_fee: CourseFee,
            course_totalenroll: CourseEnroll,
            course_totalclass: CourseClass,
            course_link: CourseLink,
            course_img: CourseImg,   
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
//update data send 
$('#CourseUpdateConfirmBtn').click(function(){
var courseID=$('#courseEditId').html();
var  courseName=$('#CourseNameUpdateId').val();
var  courseDes=$('#CourseDesUpdateId').val();
var courseFee=$('#CourseFeeUpdateId').val();
var  courseEnroll=$('#CourseEnrollUpdateId').val();
var  courseClass=$('#CourseClassUpdateId').val();
var courseLink=$('#CourseLinkUpdateId').val();
var  courseImg=$('#CourseImgUpdateId').val();
CourseUpdate(courseID,courseName,courseDes,courseFee,courseEnroll,courseClass,courseLink,courseImg);
})
function CourseUpdate(courseID,courseName,courseDes,courseFee,courseEnroll,courseClass,courseLink,courseImg) {
  
    if(courseName.length==0){
     toastr.error('Course Name is Empty !');
    }
    else if(courseDes.length==0){
     toastr.error('Course Description is Empty !');
    }
    else if(courseFee.length==0){
      toastr.error('Course Fee is Empty !');
    }
    else if(courseEnroll.length==0){
      toastr.error('Course Enroll is Empty !');
    }
    else if(courseClass.length==0){
      toastr.error('Course Class is Empty !');
    }
    else if(courseLink.length==0){
      toastr.error('Course Link is Empty !');
    }
    else if(courseImg.length==0){
      toastr.error('Course Image is Empty !');
    }
    else{
    $('#CourseUpdateConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
    axios.post('/CoursesUpdate', {
            id: courseID,
            course_name: courseName,
            course_des: courseDes,
            course_fee: courseFee,
            course_totalenroll: courseEnroll,
            course_totalclass: courseClass,  
            course_link: courseLink,             
            course_img: courseImg,   
        })
        .then(function(response) {
            $('#CourseUpdateConfirmBtn').html("Save");
          
            if(response.status==200){
              if (response.data == 0) {
                $('#EditModal').modal('hide');
                toastr.success('Update Success');
                getdata();
            } else {
                $('#EditModal').modal('hide');
                toastr.error('Update Fail');
                getdata();
            }  
         } 
         else{
            $('#updateCourseModal').modal('hide');
             toastr.error('Something Went Wrong !');
         }   
    })
    .catch(function(error) {
        $('#updateCourseModal').modal('hide');
        toastr.error('Something Went Wrong !');
   });

}
}

    </script>
@endsection