<?php

namespace Engine;

use App\Models\User;
use Symfony\Component\HttpFoundation\Request;

class Auth
{
    public static function login(Request $request)
    {
        $email = $request->request->get('email');
        $password = md5(config('app.secret') . $request->request->get('password') . config('app.secret'));

        $user = User::where('email', $email)
            ->andWhere('password', $password)
            ->first();

        if ($user) {
            Session::set('user', $user->toArray());

            return $user;
        }

        return false;
    }

    public static function guard()
    {
        if ($guard = Session::get('user')) {
            return $guard;
        }

        return false;
    }
}
