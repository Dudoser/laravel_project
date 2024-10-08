<?php

namespace App\Http\Controllers;

class MainController extends Controller
{
    public function indexAction()
    {
        return view('index');
    }
}
