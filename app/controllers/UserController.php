<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../../core/helper/JwtHelper.php';

class UserController
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function index()
    {
        $user = $this->getUserFromJwt();

        if (!$user) {
            header('Location: ' . route('login'));
            exit();
        }

        include __DIR__ . '/../views/User.php';
    }

    private function getUserFromJwt()
    {
        if (!isset($_COOKIE['jwt_token'])) {
            return null;
        }

        return JwtHelper::verifyToken($_COOKIE['jwt_token']);
    }

    public function listUsers($page = 1, $search = '')
    {
        return $this->user->getUsers($page, 5, $search);
    }

    public function addUser($data)
    {
        $currentDateTime = date('Y-m-d H:i:s');
        if (isset($data['username'], $data['password'], $data['role'])) {
            $inserted = $this->user->insertuser($data['username'], md5($data['password']), $data['role'], $_SESSION['user']['username'], $currentDateTime);

            if ($inserted) {
                $_SESSION['message'] = ['type' => 'success', 'text' => 'User successfully added!'];
            } else {
                $_SESSION['message'] = ['type' => 'danger', 'text' => 'Failed to add user. Please try again.'];
            }

            header('Location: ' . route('user'));
            exit();
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'All fields are required.'];
            header('Location: ' . route('user'));
            exit();
        }
    }

    public function deleteUser($data)
    {
        if (isset($data['id'])) {
            $id = intval($data['id']);
            $deleted = $this->user->deleteuser($id);

            if ($deleted) {
                $_SESSION['message'] = ['type' => 'success', 'text' => 'User successfully deleted!'];
            } else {
                $_SESSION['message'] = ['type' => 'danger', 'text' => 'Failed to delete user. Please try again.'];
            }

            header('Location: ' . route('user'));
            exit();
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'All fields are required.'];
            header('Location: ' . route('user'));
            exit();
        }
    }
}
