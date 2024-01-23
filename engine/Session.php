<?php

namespace Engine;

class Session
{
    public static function set($name, $value)
    {
        $_SESSION[$name] = $value;
        session_commit();

        return $_SESSION[$name];
    }

    public static function get($name)
    {
        return $_SESSION[$name] ?? null;
    }

    public static function delete($name)
    {
        unset($_SESSION[$name]);
        session_commit();
    }
}
