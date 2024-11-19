<?php

class SaleRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db->getConnection();
    }

    public function createSale($cliente_id, $tipo_comprobante, $articulo_id, $cantidad) {
        try {
            $this->db->beginTransaction();

            // Insertar en la tabla ventas
            $ventaQuery = "INSERT INTO ventas (cliente_id, tipo_comprobante) VALUES (:cliente_id, :tipo_comprobante)";
            $ventaStmt = $this->db->prepare($ventaQuery);
            $ventaStmt->execute([
                ':cliente_id' => $cliente_id,
                ':tipo_comprobante' => $tipo_comprobante
            ]);

            // Obtener el ID de la venta recién creada
            $venta_id = $this->db->lastInsertId();

            // Insertar en la tabla detalle_ventas
            $detalleQuery = "INSERT INTO detalle_ventas (venta_id, articulo_id, cantidad) VALUES (:venta_id, :articulo_id, :cantidad)";
            $detalleStmt = $this->db->prepare($detalleQuery);
            $detalleStmt->execute([
                ':venta_id' => $venta_id,
                ':articulo_id' => $articulo_id,
                ':cantidad' => $cantidad
            ]);

            // Actualizar inventario
            $inventarioQuery = "UPDATE inventario SET stock = stock - :cantidad WHERE articulo_id = :articulo_id";
            $inventarioStmt = $this->db->prepare($inventarioQuery);
            $inventarioStmt->execute([
                ':cantidad' => $cantidad,
                ':articulo_id' => $articulo_id
            ]);

            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
?>