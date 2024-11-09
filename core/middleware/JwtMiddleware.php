<?php

require_once __DIR__ . '/../helper/JwtHelper.php';

class JwtMiddleware
{
    public static function validate()
    {
        if (!isset($_COOKIE['jwt_token'])) {
            error_log("JWT Token not set in cookie.");
            header('Location: ' . route('login'));
            exit();
        }

        $user = JwtHelper::verifyToken($_COOKIE['jwt_token']);
        if (!$user) {
            error_log("JWT Token validation failed.");
            header('Location: ' . route('login'));
            exit();
        }

        // Log data pengguna jika berhasil
        error_log("JWT Token validated successfully for user: " . json_encode($user));
        return $user;
    }
}
