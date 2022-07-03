<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectsModel;
class ProjectsController extends Controller
{
    function index(){
        $serviceData = ProjectsModel::all();
        return view('Servuces',['serviceData'=>$serviceData]);
    }
    function getServiceData(){
        $result=json_encode(ProjectsModel::orderBy('id','desc')->get());
	    return $result;
    }
    function deleteServices(Request $req){
        $id= $req->input('id');
        $result= ProjectsModel::where('id','=',$id)->delete();
   
        if($result==true){      
          return 1;
        }
        else{
            return 0;
        }
    }
    function ServiceAdd(request $req){
        $name = $req->input('name');
        $des = $req->input('des');
        $img = $req->input('img');
        $result= ProjectsModel::insert(['service_name'=>$name,'service_des'=>$des,'service_img'=>$img]);
     if($result==true){      
       return 1;
     }
     else{
      return 0;
     }
    }
    function ServiceDetails(request $req){
        $id = $req->input('id');
        $result= json_encode(ProjectsModel::where('id','=',$id)->get());
        if($result==true){
            return $result;
        }else{
            return 0 ;
        }
    }
    function ServiceUpdate(request $req){
        $id= $req->input('id');
        $name= $req->input('name');
        $des= $req->input('des');
        $img= $req->input('img');
        $result= ProjectsModel::where('id','=',$id)->update(['service_name'=>$name,'service_des'=>$des,'service_img'=>$img]);
        if($result == true){      
          return 1;
        }
        else{
         return 0;
        }
    }
}
