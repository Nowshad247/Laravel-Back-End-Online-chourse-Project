<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseModel;
class CoursesController extends Controller
{
    function HomeIndex(){
        return view('Courses');
    }
    function getCoursesData(){
        $result=json_encode(CourseModel::orderBy('id','desc')->get());
        return $result;
    }
    function ChourseDelete(request $req){
        $id = $req->input('id');
        $result = CourseModel::where('id','=',$id)->delete();
        if($result == true){
            return 1;
        }else{
            return 0 ; 
        }
        
    }
  

}
