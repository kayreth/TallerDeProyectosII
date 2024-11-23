<?php

class SaleRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db->getConnection();
    }

    public function listSales() {
        $query = "SELECT 
                    v.VentaID,
                    v.FechaVenta,
                    v.Total,
                    c.Nombre AS Cliente 
                  FROM Ventas v
                  INNER JOIN Clientes c ON v.ClienteID = c.ClienteID";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new Exception('Error al listar las ventas: ' . $e->getMessage());
        }
    }

    public function getSaleDetails($ventaId) {
        $queryVenta = "SELECT 
                          v.VentaID,
                          v.FechaVenta,
                          v.Total,
                          c.Nombre AS Cliente 
                       FROM Ventas v
                       INNER JOIN Clientes c ON v.ClienteID = c.ClienteID
                       WHERE v.VentaID = :ventaId";

        $queryArticulos = "SELECT 
                              dv.ArticuloID,
                              a.Nombre,
                              dv.Cantidad,
                              dv.PrecioUnitario,
                              dv.Subtotal
                           FROM DetalleVentas dv
                           INNER JOIN Articulos a ON dv.ArticuloID = a.ArticuloID
                           WHERE dv.VentaID = :ventaId";

        try {
            $stmtVenta = $this->db->prepare($queryVenta);
            $stmtVenta->bindParam(':ventaId', $ventaId, PDO::PARAM_INT);
            $stmtVenta->execute();
            $venta = $stmtVenta->fetch(PDO::FETCH_ASSOC);

            if (!$venta) {
                throw new Exception('No se encontró la venta con el ID proporcionado.');
            }

            $stmtArticulos = $this->db->prepare($queryArticulos);
            $stmtArticulos->bindParam(':ventaId', $ventaId, PDO::PARAM_INT);
            $stmtArticulos->execute();
            $articulos = $stmtArticulos->fetchAll(PDO::FETCH_ASSOC);

            $venta['articulos'] = $articulos;
            return $venta;
        } catch (Throwable $e) {
            throw new Exception('Error al obtener los detalles de la venta: ' . $e->getMessage());
        }
    }

    public function createSale($clienteId, $articulos) {
        try {
            $this->db->beginTransaction();

            $queryVenta = "INSERT INTO Ventas (ClienteID, Total) 
                           VALUES (:clienteId, :total)";
            $total = array_reduce($articulos, function ($carry, $item) {
                return $carry + ($item['cantidad'] * $item['precioUnitario']);
            }, 0);

            $stmtVenta = $this->db->prepare($queryVenta);
            $stmtVenta->execute([
                ':clienteId' => $clienteId,
                ':total' => $total
            ]);

            $ventaId = $this->db->lastInsertId();

            $queryDetalle = "INSERT INTO DetalleVentas (VentaID, ArticuloID, Cantidad, PrecioUnitario) 
                             VALUES (:ventaId, :articuloId, :cantidad, :precioUnitario)";
            $stmtDetalle = $this->db->prepare($queryDetalle);

            foreach ($articulos as $articulo) {
                $stmtDetalle->execute([
                    ':ventaId' => $ventaId,
                    ':articuloId' => $articulo['articuloID'],
                    ':cantidad' => $articulo['cantidad'],
                    ':precioUnitario' => $articulo['precioUnitario']
                ]);

                $this->updateInventory($articulo['articuloID'], $articulo['cantidad']);
            }

            $this->db->commit();
            return $ventaId;
        } catch (Throwable $e) {
            $this->db->rollBack();
            throw new Exception('Error al crear la venta: ' . $e->getMessage());
        }
    }

    private function updateInventory($articuloId, $cantidad) {
        $query = "UPDATE Articulos SET Stock = Stock - :cantidad WHERE ArticuloID = :articuloId";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':cantidad' => $cantidad,
                ':articuloId' => $articuloId
            ]);
        } catch (Throwable $e) {
            throw new Exception('Error al actualizar el inventario: ' . $e->getMessage());
        }
    }
}
