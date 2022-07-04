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
            <h5 id="ProjectDeleteBtn" class="mt-4 d-none">   </h5>
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
            <div class="col-md-12">
                <input id="ProjectNameId" type="text" id="" class="form-control mb-3" placeholder="Project Name">
                <input id="ProjectDesId" type="text" id="" class="form-control mb-3" placeholder="Project Description">
                <input id="ProjectLinkId" type="text" id="" class="form-control mb-3" placeholder="Project Link">
                <input id="ProjectImgId" type="text" id="" class="form-control mb-3" placeholder="Project Image">
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
      <h5 id="ProjectEditId" class="mt-4 d-none">  </h5>
      <div id="ProjectEditForm" class="container d-none">
        <div class="row">
            <div class="col-md-12">
            <input id="ProjectNameUpdateId" type="text" id="" class="form-control mb-3" placeholder="Project Name">
            <input id="ProjectDesUpdateId" type="text" id="" class="form-control mb-3" placeholder="Project Description">  
            <input id="ProjectLinkUpdateId" type="text" id="" class="form-control mb-3" placeholder="Project Link">
            <input id="ProjectImgUpdateId" type="text" id="" class="form-control mb-3" placeholder="Project Image">
           </div>
         </div>
        </div>
        <img class="loading-icon m-5" id='ProjectEditLoader' src="{{asset('images/loding.gif')}}">
        <h5 id="courseEditWrong" class="d-none">Something Went Wrong !</h5>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
      <button  id="ProjectEditConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Save</button>
    </div>
  </div>
</div>
</div>
@endsection

@section('scripts')
<script>
    getdata();
    function getdata(){
      axios.get('/ProjectsList')
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
                        "<td>"+jsonData[i].project_name+"</td>" +
                        "<td>"+jsonData[i].project_desc+"</td>" +  
                        "<td><a class='ProjectEditBtn' data-id="+jsonData[i].id+"><i class='fas fa-edit'></i></a></td>" +
                        "<td><a class='ProjectDeleteBtn' data-id="+jsonData[i].id+"><i class='fas fa-trash-alt'></i></a></td>"
                  ).appendTo('#service_table');
              });
              //Data Table 
              $('#mainDiv').DataTable({
      order: [[3, 'desc']],
  });
              $('.dataTables_length').addClass('bs-select');
              // Services Table Delete Icon Click
              $('.ProjectDeleteBtn').click(function() {
                  var id = $(this).data('id');
                  $('#ProjectDeleteBtn').html(id);
                  $('#deleteModal').modal('show');

              })
              $('.ProjectEditBtn').click(function(){
                var id = $(this).data('id');
                  $('#ProjectEditId').html(id);
                  ProjectUpdateDetails(id);
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
  var id = $('#ProjectDeleteBtn').html();
      ServiceDelete(id);
    })
    function ServiceDelete(deleteID){
      $('#serviceDeleteConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") 
      axios.post('/projectsDelete', {
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
function ProjectUpdateDetails(detailsID) {
    
  axios.post('/projectsDetails', {
          id: detailsID
      })
      .then(function(response) {
       
        if(response.status==200){
                        $('#ProjectEditForm').removeClass('d-none');
                        $('#ProjectEditLoader').addClass('d-none');    
                        var jsonData = response.data;
                        $('#ProjectNameUpdateId').val(jsonData[0].project_name);
                        $('#ProjectDesUpdateId').val(jsonData[0].project_desc);
                        $('#ProjectLinkUpdateId').val(jsonData[0].project_link);
                        $('#ProjectImgUpdateId').val(jsonData[0].project_img);
                    }
                  
                  else{
                      $('#ProjectEditLoader').addClass('d-none');
                      $('#ProjectEditWrong').removeClass('d-none');
                    }
                  })
  .catch(function(error) {
                $('#serviceEditLoader').addClass('d-none');
                $('#serviceEditWrong').removeClass('d-none');
 });

}
             
// Services Edit Modal Save Btn
$('#serviceAddConfirmBtn').click(function() {
    var ProjectName=$('#ProjectNameId').val();
  var ProjectDes=$('#ProjectDesId').val();
  var ProjectLink=$('#ProjectLinkId').val();
  var ProjectImg=$('#ProjectImgId').val();
  ProjectAdd(ProjectName,ProjectDes,ProjectLink,ProjectImg);
})
function ProjectAdd(ProjectName,ProjectDes,ProjectLink,ProjectImg){
    if(ProjectName.length==0){
     toastr.error('Project Name is Empty !');
    }
    else if(ProjectDes.length==0){
     toastr.error('Project Description is Empty !');
    }
    else if(ProjectLink.length==0){
      toastr.error('Project Link is Empty !');
    }
    else if(ProjectImg.length==0){
      toastr.error('Project Image is Empty !');
    }
  else{
  $('#serviceAddConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
  axios.post('/projectsAdd', {
            project_name: ProjectName,
            project_desc: ProjectDes,
            project_link: ProjectLink,
            project_img: ProjectImg 
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
$('#ProjectEditConfirmBtn').click(function() {
    var ProjectID=$('#ProjectEditId').html();
    var  ProjectName=$('#ProjectNameUpdateId').val();
    var  ProjectDes=$('#ProjectDesUpdateId').val();
    var ProjectLink=$('#ProjectLinkUpdateId').val();
    var  ProjectImg=$('#ProjectImgUpdateId').val();
    ProjectUpdate(ProjectID,ProjectName,ProjectDes,ProjectLink,ProjectImg);
})


function ProjectUpdate(ProjectID,ProjectName,ProjectDes,ProjectLink,ProjectImg) {

    if(ProjectName.length==0){
     toastr.error('Project Name is Empty !');
    }
    else if(ProjectDes.length==0){
     toastr.error('Project Description is Empty !');
    }
    else if(ProjectLink.length==0){
      toastr.error('Project Link is Empty !');
    }
    else if(ProjectImg.length==0){
      toastr.error('Project Image is Empty !');
    }
else{
$('#serviceEditConfirmBtn').html("<div class='spinner-border spinner-border-sm' role='status'></div>") //Animation....
axios.post('/projectsUpdate', {
            id: ProjectID,
            project_name:ProjectName,
            project_desc:ProjectDes,
            project_link:ProjectLink,             
            project_img:ProjectImg, 

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
        console.log(response.data);
          $('#CourseUpdateConfirmBtn').html("Save");
          if(response.status==200){
            if (response.data == 1) {
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