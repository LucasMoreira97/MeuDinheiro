<?php

namespace Models;

class Session
{

    public static function init(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!self::isLoggedIn()) {
            exit;
        }
    }

    private static function isLoggedIn(){
        return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
    }


    public static function logout(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];
        session_destroy();
    }
}
