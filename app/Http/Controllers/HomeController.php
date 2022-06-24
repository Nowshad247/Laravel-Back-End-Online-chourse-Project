<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    function HomeIndex(){
        $total = 'adkjshkjah';
        return view('Home',['total'=>$total]);
    }
}
