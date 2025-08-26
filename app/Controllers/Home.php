<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('template'); // this should match a view file like app/Views/template.php
    }
}