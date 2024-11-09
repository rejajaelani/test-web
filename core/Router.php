<?php
session_start();

require_once __DIR__ . '/../core/middleware/JwtMiddleware.php';
require_once __DIR__ . '/../config/config.php';

class Router
{
    public function __construct()
    {
        $this->route();
    }

    private function route()
    {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        if ($uri === 'test-web') {
            $controller = new AuthController();
            $controller->index();
        } elseif ($uri === 'test-web/login-process') {
            $controller = new AuthController();
            $controller->login();
        } elseif ($uri === 'test-web/logout-process') {
            $controller = new AuthController();
            $controller->logout();
        } elseif ($uri === 'test-web/dashboard') {
            JwtMiddleware::validate();
            $controller = new DashboardController();
            $controller->index();
        } elseif ($uri === 'test-web/login') {
            $controller = new AuthController();
            $controller->index();
        } elseif ($uri === 'test-web/customer') {
            JwtMiddleware::validate();
            $controller = new CustomerController();
            $controller->index();
        } elseif ($uri === 'test-web/customer/add') {
            JwtMiddleware::validate();
            $controller = new CustomerController();
            $controller->addCustomer($_POST);
        } elseif ($uri === 'test-web/customer/edit') {
            JwtMiddleware::validate();
            $controller = new CustomerController();
            $controller->editCustomer($_POST);
        } elseif ($uri === 'test-web/customer/delete') {
            JwtMiddleware::validate();
            $controller = new CustomerController();
            $controller->deleteCustomer($_POST);
        } elseif ($uri === 'test-web/customer/API') {
            JwtMiddleware::validate();
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $id = (int) $_GET['id'];
                $controller = new CustomerController();
                $controller->showCustomerAPI($id);
            } else {
                echo json_encode(['error' => 'ID parameter is required'], JSON_PRETTY_PRINT);
            }
        } elseif ($uri === 'test-web/order') {
            JwtMiddleware::validate();
            $controller = new OrderController();
            $controller->index();
        } elseif ($uri === 'test-web/order/add') {
            JwtMiddleware::validate();
            $controller = new OrderController();
            $controller->addOrder($_POST);
        } elseif ($uri === 'test-web/order/edit') {
            JwtMiddleware::validate();
            $controller = new OrderController();
            $controller->editOrder($_POST);
        } elseif ($uri === 'test-web/order/delete') {
            JwtMiddleware::validate();
            $controller = new OrderController();
            $controller->deleteOrder($_POST);
        } elseif ($uri === 'test-web/order/API') {
            JwtMiddleware::validate();
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $id = (int) $_GET['id'];
                $controller = new OrderController();
                $controller->showOrderAPI($id);
            } else {
                echo json_encode(['error' => 'ID parameter is required'], JSON_PRETTY_PRINT);
            }
        } elseif ($uri === 'test-web/user') {
            JwtMiddleware::validate();
            $controller = new UserController();
            $controller->index();
        } elseif ($uri === 'test-web/user/add') {
            JwtMiddleware::validate();
            $controller = new UserController();
            $controller->addUser($_POST);
        } elseif ($uri === 'test-web/user/delete') {
            JwtMiddleware::validate();
            $controller = new UserController();
            $controller->deleteUser($_POST);
        } else {
            echo "Page not found!";
        }
    }
}
