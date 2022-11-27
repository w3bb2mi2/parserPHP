<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParseController extends Controller
{
    public function index(){
        dd($_FILES);
    }
}
