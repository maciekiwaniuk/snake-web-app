<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;

class EmailsController extends Controller
{
    public function showWelcomeMail()
    {
        return new WelcomeMail(Auth::user());
    }
}
