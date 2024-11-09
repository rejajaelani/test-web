<?php
require_once __DIR__ . '/../models/Customer.php';
require_once __DIR__ . '/../../core/helper/JwtHelper.php';

class CustomerController
{
    private $customer;

    public function __construct()
    {
        $this->customer = new Customer();
    }

    public function index()
    {
        $user = $this->getUserFromJwt();

        if (!$user) {
            header('Location: ' . route('login'));
            exit();
        }

        include __DIR__ . '/../views/Customer.php';
    }

    private function getUserFromJwt()
    {
        if (!isset($_COOKIE['jwt_token'])) {
            return null;
        }

        return JwtHelper::verifyToken($_COOKIE['jwt_token']);
    }

    public function listCustomers($page = 1, $search = '')
    {
        return $this->customer->getCustomers($page, 5, $search);
    }

    public function listAllCustomers()
    {
        return $this->customer->getAllCustomers();
    }

    public function showCustomerAPI($id)
    {
        $customerData = $this->customer->getCustomerById($id);

        if ($customerData) {
            header('Content-Type: application/json');

            echo json_encode($customerData, JSON_PRETTY_PRINT);
        } else {
            echo json_encode(['error' => 'Customer not found'], JSON_PRETTY_PRINT);
        }

        exit;
    }

    public function addCustomer($data)
    {
        $currentDateTime = date('Y-m-d H:i:s');
        if (isset($data['name'], $data['email'], $data['phone'], $data['address'])) {
            $inserted = $this->customer->insertCustomer($data['name'], $data['email'], $data['phone'], $data['address'], $_SESSION['user']['username'], $currentDateTime);

            if ($inserted) {
                $_SESSION['message'] = ['type' => 'success', 'text' => 'Customer successfully added!'];
            } else {
                $_SESSION['message'] = ['type' => 'danger', 'text' => 'Failed to add customer. Please try again.'];
            }

            header('Location: ' . route('customer'));
            exit();
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'All fields are required.'];
            header('Location: ' . route('customer'));
            exit();
        }
    }

    public function editCustomer($data)
    {
        $currentDateTime = date('Y-m-d H:i:s');
        if (isset($data['id'], $data['name'], $data['email'], $data['phone'], $data['address'])) {
            $inserted = $this->customer->updateCustomer($data['id'], $data['name'], $data['email'], $data['phone'], $data['address'], $_SESSION['user']['username'], $currentDateTime);

            if ($inserted) {
                $_SESSION['message'] = ['type' => 'success', 'text' => 'Customer successfully edited!'];
            } else {
                $_SESSION['message'] = ['type' => 'danger', 'text' => 'Failed to add customer. Please try again.'];
            }

            header('Location: ' . route('customer'));
            exit();
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'All fields are required.'];
            header('Location: ' . route('customer'));
            exit();
        }
    }

    public function deleteCustomer($data)
    {
        if (isset($data['id'])) {
            $id = intval($data['id']);
            $deleted = $this->customer->deleteCustomer($id);

            if ($deleted) {
                $_SESSION['message'] = ['type' => 'success', 'text' => 'Customer successfully deleted!'];
            } else {
                $_SESSION['message'] = ['type' => 'danger', 'text' => 'Failed to delete customer. Please try again.'];
            }

            header('Location: ' . route('customer'));
            exit();
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'All fields are required.'];
            header('Location: ' . route('customer'));
            exit();
        }
    }
}
