<?php

namespace App\Middlewares;

use Engine\Auth;

class NotLoggedInMiddleware
{
    public function handle()
    {
        if (!Auth::guard()) {
            return true;
        }

        return redirect('/admin/movies');
    }
}
