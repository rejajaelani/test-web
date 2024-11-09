<?php
require_once __DIR__ . '/../../core/models/Model.php';

class Order extends Model
{
    public function getOrders($page = 1, $limit = 5, $search = '')
    {
        $sqlWhere = "";
        $username = $_SESSION['user']['username'];

        if ($_SESSION['user']['role'] !== 0 && $_SESSION['user']['role'] !== 1) {
            $sqlWhere = "AND ord.created_by = :username";
        }

        $offset = ($page - 1) * $limit;
        $query = "SELECT ord.*, cust.name 
              FROM orders ord 
              JOIN customers cust ON ord.id_customer = cust.id 
              WHERE ord.name_order ILIKE :search $sqlWhere 
              ORDER BY ord.created_at DESC 
              LIMIT :limit OFFSET :offset";

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

    public function getOrderById($id)
    {
        $sqlWhere = "";
        $username = $_SESSION['user']['username'];

        if ($_SESSION['user']['role'] !== 0 && $_SESSION['user']['role'] !== 1) {
            $sqlWhere = "AND ord.created_by = :username";
        }

        $query = "SELECT ord.*, cust.name AS customer_name, cust.email AS customer_email, 
                     cust.phone AS customer_phone, cust.address AS customer_address, 
                     ord.updated_by 
              FROM orders ord 
              JOIN customers cust ON ord.id_customer = cust.id 
              WHERE ord.id = :id $sqlWhere";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($_SESSION['user']['role'] !== 0 && $_SESSION['user']['role'] !== 1) {
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertOrder($name_order, $id_customer, $notes, $order_start, $order_end, $created_by, $created_at)
    {
        $query = "INSERT INTO orders (name_order, id_customer, notes, order_start, order_end, created_by, created_at) VALUES (:name_order, :id_customer, :notes, :order_start, :order_end, :created_by, :created_at)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name_order', $name_order);
        $stmt->bindParam(':id_customer', $id_customer);
        $stmt->bindParam(':notes', $notes);
        $stmt->bindParam(':order_start', $order_start);
        $stmt->bindParam(':order_end', $order_end);
        $stmt->bindParam(':created_by', $created_by);
        $stmt->bindParam(':created_at', $created_at);
        return $stmt->execute();
    }

    public function updateOrder($id, $name_order, $id_customer, $notes, $order_start, $order_end, $updated_by, $updated_at)
    {
        //var_dump($updated_by) . die();
        $query = "UPDATE orders SET name_order = :name_order, id_customer = :id_customer, notes = :notes, order_start = :order_start, order_end = :order_end, updated_by = :updated_by, updated_at = :updated_at WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name_order', $name_order);
        $stmt->bindParam(':id_customer', $id_customer);
        $stmt->bindParam(':notes', $notes);
        $stmt->bindParam(':order_start', $order_start);
        $stmt->bindParam(':order_end', $order_end);
        $stmt->bindParam(':updated_by', $updated_by);
        $stmt->bindParam(':updated_at', $updated_at);
        return $stmt->execute();
    }

    public function deleteOrder($id)
    {
        $stmt = $this->db->prepare("DELETE FROM orders WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
