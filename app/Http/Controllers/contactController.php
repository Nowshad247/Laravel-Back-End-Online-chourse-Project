<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactModel;
class contactController extends Controller
{
    function index(){
        return view('contact');
    }
    function getAllContactInfo(){
        $result=json_encode(ContactModel::orderBy('id','desc')->get());
	    return $result;
    }
    function contactsDelete(request $req){
        $id= $req->input('id');
        $result= ContactModel::where('id','=',$id)->delete();
        if($result==true){      
          return 1;
        }
        else{
            return 0;
        }
    }
}
