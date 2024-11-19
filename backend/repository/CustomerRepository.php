<?php

class CustomerRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db->getConnection();
    }

    public function getAllCustomers() {
        $query = "SELECT id, name, email, phone FROM clientes"; // Ajusta los nombres de columnas según tu tabla
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>