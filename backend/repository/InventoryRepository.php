<?php

class InventoryRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db->getConnection();
    }

    public function getAllInventoryMovements() {
        $query = "SELECT 
                    i.id AS id, 
                    a.name AS articulo, 
                    i.tipo_movimiento AS tipo_movimiento, 
                    i.cantidad AS cantidad, 
                    i.fecha_movimiento AS fecha_movimiento
                  FROM inventario i
                  JOIN articulos a ON i.articulo_id = a.id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>