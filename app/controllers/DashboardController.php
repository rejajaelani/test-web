<?php
require_once __DIR__ . '/../../core/helper/JwtHelper.php'; // Pastikan JWT Helper sudah di-load

class DashboardController
{
    public function index()
    {
        // Validasi token JWT yang diterima dari cookie
        $user = $this->getUserFromJwt();

        if (!$user) {
            // Jika token tidak valid atau tidak ada, arahkan ke halaman login
            header('Location: ' . route('login'));
            exit();
        }

        // Token valid, tampilkan dashboard
        include __DIR__ . '/../views/dashboard.php';
    }

    // Fungsi untuk mendapatkan data user dari token JWT
    private function getUserFromJwt()
    {
        if (!isset($_COOKIE['jwt_token'])) {
            return null; // Jika tidak ada token, tidak ada user
        }

        // Verifikasi token dan ambil data user
        return JwtHelper::verifyToken($_COOKIE['jwt_token']);
    }
}
