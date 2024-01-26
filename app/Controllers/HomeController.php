<?php

namespace App\Controllers;

use Engine\Auth;

class HomeController
{
    public function index()
    {
        if (Auth::guard()) {
            redirect('/admin/movies');
        }

        return redirect('/login');
    }
}
