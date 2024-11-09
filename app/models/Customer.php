<?php
require_once __DIR__ . '/../../core/models/Model.php';

class Customer extends Model
{
    public function getAllCustomers()
    {
        $sqlWhere = "";
        $username = $_SESSION['user']['username'];
        if ($_SESSION['user']['role'] !== 0 && $_SESSION['user']['role'] !== 1) {
            $sqlWhere = "WHERE created_by = :username";
        }
        $stmt = $this->db->prepare("SELECT * FROM customers $sqlWhere");

        if ($_SESSION['user']['role'] !== 0 && $_SESSION['user']['role'] !== 1) {
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCustomers($page = 1, $limit = 5, $search = '')
    {
        $sqlWhere = "";
        $username = $_SESSION['user']['username'];

        if ($_SESSION['user']['role'] !== 0 && $_SESSION['user']['role'] !== 1) {
            $sqlWhere = "AND created_by = :username";
        }

        $offset = ($page - 1) * $limit;
        $query = "SELECT * FROM customers WHERE name ILIKE :search $sqlWhere ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        if ($_SESSION['user']['role'] !== 0 && $_SESSION['user']['role'] !== 1) {
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCustomerById($id)
    {
        $sqlWhere = "";
        $username = $_SESSION['user']['username'];

        if ($_SESSION['user']['role'] !== 0 && $_SESSION['user']['role'] !== 1) {
            $sqlWhere = "AND created_by = :username";
        }

        $stmt = $this->db->prepare("SELECT * FROM customers WHERE id = :id $sqlWhere");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($_SESSION['user']['role'] !== 0 && $_SESSION['user']['role'] !== 1) {
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertCustomer($name, $email, $phone, $address, $created_by, $created_at)
    {
        $query = "INSERT INTO customers (name, email, phone, address, created_by, created_at) VALUES (:name, :email, :phone, :address, :created_by, :created_at)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':created_by', $created_by);
        $stmt->bindParam(':created_at', $created_at);
        return $stmt->execute();
    }

    public function updateCustomer($id, $name, $email, $phone, $address, $updated_by, $updated_at)
    {
        $query = "UPDATE customers SET name = :name, email = :email, phone = :phone, address = :address, updated_by = :updated_by, updated_at = :updated_at WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':updated_by', $updated_by);
        $stmt->bindParam(':updated_at', $updated_at);
        return $stmt->execute();
    }

    public function deleteCustomer($id)
    {
        $stmt = $this->db->prepare("DELETE FROM customers WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
