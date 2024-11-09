<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../../core/Session.php';
require_once __DIR__ . '/../../core/helper/JwtHelper.php';

class AuthController
{
    public function index()
    {
        $user = $this->getUserFromJwt();

        if ($user) {
            header('Location: ' . route('dashboard'));
            exit();
        }

        include __DIR__ . '/../views/login.php';
    }

    private function getUserFromJwt()
    {
        if (!isset($_COOKIE['jwt_token'])) {
            return null;
        }

        return JwtHelper::verifyToken($_COOKIE['jwt_token']);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $userModel = new User();
                $user = $userModel->login($_POST['username'], $_POST['password']);
                if ($user) {
                    unset($user['password']);
                    $token = JwtHelper::createToken(['id' => $user['id'], 'username' => $user['username']]);
                    setcookie('jwt_token', $token, time() + (60 * 60), "/");
                    $_SESSION['user'] = $user;
                    header('Location: ' . route('dashboard'));
                } else {
                    throw new Exception("Invalid credentials.");
                }
            } catch (Exception $e) {
                echo "<script>
                alert('Error: " . $e->getMessage() . "');
                window.location.href = '" . route('login') . "';
            </script>";
            }
        }
    }

    public function logout()
    {
        setcookie('jwt_token', '', time() - 3600, "/");
        header('Location: ' . route('login'));
    }
}
