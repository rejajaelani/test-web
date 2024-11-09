<?php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../../core/helper/JwtHelper.php';

class OrderController
{
    private $order;

    public function __construct()
    {
        $this->order = new Order();
    }

    public function index()
    {
        $user = $this->getUserFromJwt();

        if (!$user) {
            header('Location: ' . route('login'));
            exit();
        }

        include __DIR__ . '/../views/Order.php';
    }

    private function getUserFromJwt()
    {
        if (!isset($_COOKIE['jwt_token'])) {
            return null;
        }

        return JwtHelper::verifyToken($_COOKIE['jwt_token']);
    }

    public function listOrders($page = 1, $search = '')
    {
        return $this->order->getOrders($page, 5, $search);
    }

    public function showOrderAPI($id)
    {
        $orderData = $this->order->getOrderById($id);

        if ($orderData) {
            header('Content-Type: application/json');

            echo json_encode($orderData, JSON_PRETTY_PRINT);
        } else {
            echo json_encode(['error' => 'Order not found'], JSON_PRETTY_PRINT);
        }

        exit;
    }

    public function addOrder($data)
    {
        $currentDateTime = date('Y-m-d H:i:s');
        if (isset($data['name_order'], $data['id_customer'], $data['notes'], $data['order_start'], $data['order_end'])) {
            $inserted = $this->order->insertOrder($data['name_order'], $data['id_customer'], $data['notes'], $data['order_start'], $data['order_end'], $_SESSION['user']['username'], $currentDateTime);

            if ($inserted) {
                $_SESSION['message'] = ['type' => 'success', 'text' => 'Order successfully added!'];
            } else {
                $_SESSION['message'] = ['type' => 'danger', 'text' => 'Failed to add order. Please try again.'];
            }

            header('Location: ' . route('order'));
            exit();
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'All fields are required.'];
            header('Location: ' . route('order'));
            exit();
        }
    }

    public function editOrder($data)
    {
        // var_dump($_SESSION['user']['username']) . die();
        $currentDateTime = date('Y-m-d H:i:s');
        if (isset($data['name_order'], $data['id_customer'], $data['notes'], $data['order_start'], $data['order_end'])) {
            $inserted = $this->order->updateOrder($data['id'], $data['name_order'], $data['id_customer'], $data['notes'], $data['order_start'], $data['order_end'], $_SESSION['user']['username'], $currentDateTime);

            if ($inserted) {
                $_SESSION['message'] = ['type' => 'success', 'text' => 'Order successfully edited!'];
            } else {
                $_SESSION['message'] = ['type' => 'danger', 'text' => 'Failed to add order. Please try again.'];
            }

            header('Location: ' . route('order'));
            exit();
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'All fields are required.'];
            header('Location: ' . route('order'));
            exit();
        }
    }

    public function deleteOrder($data)
    {
        if (isset($data['id'])) {
            $id = intval($data['id']);
            $deleted = $this->order->deleteOrder($id);

            if ($deleted) {
                $_SESSION['message'] = ['type' => 'success', 'text' => 'Order successfully deleted!'];
            } else {
                $_SESSION['message'] = ['type' => 'danger', 'text' => 'Failed to delete order. Please try again.'];
            }

            header('Location: ' . route('order'));
            exit();
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'All fields are required.'];
            header('Location: ' . route('order'));
            exit();
        }
    }
}
