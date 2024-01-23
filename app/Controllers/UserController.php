<?php

namespace App\Controllers;

use Engine\Auth;
use Symfony\Component\HttpFoundation\Request;

class UserController
{
    public function login(Request $request)
    {
        return view('crud.users.login')
            ->multipleAssign([
                'title' => 'Login'
            ])
            ->render();
    }

    public function authorize(Request $request)
    {
        if ($user = Auth::login($request)) {
            return redirect('/admin/movies');
        }

        return redirect('/login');
    }
}
