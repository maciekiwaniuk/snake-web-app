<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PHPInfoController extends Controller
{
    /**
     * Show page with php info
     */
    public function index()
    {
        return view('admin.php-info');
    }

    /**
     * Return what phpinfo function showed
     */
    public function src()
    {
        app('debugbar')->disable();
        return view('admin.php-info-src');
    }
}
