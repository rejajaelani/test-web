<?php

// Memuat autoload Composer untuk dotenv
require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;

class Model
{
    protected $db;

    public function __construct()
    {
        // Memuat file .env
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        // Mengambil konfigurasi database dari .env
        $host = $_ENV['DB_HOST'];
        $port = $_ENV['DB_PORT'];
        $dbname = $_ENV['DB_NAME'];
        $username = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];

        // Membuat koneksi PDO
        try {
            $this->db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}
