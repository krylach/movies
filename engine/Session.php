<?php

namespace Engine;

class Session
{
    public function __construct()
    {
        $config = config('session');

        if (session_status() === PHP_SESSION_NONE) {
            session_name($config->name);
            session_cache_expire($config->expire);
        }
    }

    public static function __callStatic($name, $parameters)
    {
        return call_user_func_array([new static, $name], $parameters);
    }

    private function put($name, $values)
    {
        if (is_array($values)) {
            foreach ($values as $key => $value) {
                $_SESSION[$name][$key] = $value;
            }
        } else {
            $_SESSION[$name][] = $values;
        }
    }

    private function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    private function getAndDelete($name)
    {
        $value = Session::get($name);

        if ($value) {
            Session::delete($name);
        }

        return $value;
    }

    private function get($name)
    {
        return $_SESSION[$name] ?? null;
    }

    private function delete($name)
    {
        unset($_SESSION[$name]);
    }
}
