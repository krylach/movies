<?php

namespace App\Middlewares;

use Engine\Auth;

class LoggedInMiddleware
{
    public function handle()
    {
        if (Auth::guard()) {
            return true;
        }

        return redirect('/login');
    }
}
