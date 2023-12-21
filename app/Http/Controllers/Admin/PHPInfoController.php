<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PHPInfoController extends Controller
{
    public function index()
    {
        return view('admin.php-info');
    }

    public function src()
    {
        app('debugbar')->disable();
        return view('admin.php-info-src');
    }
}
