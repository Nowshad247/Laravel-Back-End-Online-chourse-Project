<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisitorModel;
use App\Models\ServiceModel;
use App\Models\ProjectsModel;
use App\Models\CourseModel;
use App\Models\ContactModel;
class HomeController extends Controller
{
    function HomeIndex(){
        $total = VisitorModel::count();
        $Service = ServiceModel::count();
        $project = ProjectsModel::count();
        $course = CourseModel::count();
        $contact = ContactModel::count();
        return view('Home',
        ['total'=>$total,
        'service'=> $Service,
        'project'=> $project,
        'course'=> $course,
        'contact'=> $contact,

    ]);
    }
}
