<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class JwtHelper
{
    // Fungsi untuk membuat token
    public static function createToken($data)
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
        // Memastikan bahwa kunci rahasia sudah dimuat
        if (!$_ENV['JWT_SECRET_KEY']) {
            throw new Exception("JWT Secret Key is not set.");
        }

        // Membuat payload JWT
        $payload = [
            'iss' => $_ENV['JWT_ISS'],
            'aud' => $_ENV['JWT_AUD'],
            'iat' => time(),
            'exp' => time() + (60 * 60), // Token berlaku 1 jam
            'data' => $data
        ];

        // Menghasilkan token JWT
        return JWT::encode($payload, $_ENV['JWT_SECRET_KEY'], $_ENV['JWT_ALGORITHM']);
    }

    // Fungsi untuk memverifikasi token
    public static function verifyToken($token)
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        try {
            // Memverifikasi dan mendekode token menggunakan kunci dan algoritma yang sudah ditentukan
            $decoded = JWT::decode($token, new Key($_ENV['JWT_SECRET_KEY'], $_ENV['JWT_ALGORITHM']));
            return (array) $decoded->data;
        } catch (Exception $e) {
            // Menangani error dengan mencatat pesan kesalahan lebih lengkap
            error_log("JWT Verification failed: " . $e->getMessage());
            return null;
        }
    }
}
