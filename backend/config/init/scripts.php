<?php
require_once __DIR__ . '/../config/database.php';

try {
    $database = new Database();
    $conn = $database->getConnection();

    $sql = "CREATE TABLE IF NOT EXISTS Clientes (
        ClienteID INT AUTO_INCREMENT PRIMARY KEY,
        Nombre NVARCHAR(100) NOT NULL,
        Direccion NVARCHAR(200),
        Telefono NVARCHAR(15),
        Email NVARCHAR(100)
    )";
    $conn->exec($sql);
    echo "Tabla Clientes creada correctamente.<br>";

    // Tabla Articulos
    $sql = "CREATE TABLE IF NOT EXISTS Articulos (
        ArticuloID INT AUTO_INCREMENT PRIMARY KEY,
        Nombre NVARCHAR(100) NOT NULL,
        Codigo NVARCHAR(50) UNIQUE,
        Precio DECIMAL(10, 2) NOT NULL,
        Stock INT NOT NULL,
        Categoria NVARCHAR(50)
    )";
    $conn->exec($sql);
    echo "Tabla Articulos creada correctamente.<br>";

    // Tabla Ventas
    $sql = "CREATE TABLE IF NOT EXISTS Ventas (
        VentaID INT AUTO_INCREMENT PRIMARY KEY,
        ClienteID INT,
        FechaVenta DATETIME DEFAULT CURRENT_TIMESTAMP,
        Total DECIMAL(10, 2) NOT NULL,
        FOREIGN KEY (ClienteID) REFERENCES Clientes(ClienteID)
    )";
    $conn->exec($sql);
    echo "Tabla Ventas creada correctamente.<br>";

    // Tabla DetalleVentas
    $sql = "CREATE TABLE IF NOT EXISTS DetalleVentas (
        DetalleID INT AUTO_INCREMENT PRIMARY KEY,
        VentaID INT,
        ArticuloID INT,
        Cantidad INT NOT NULL,
        PrecioUnitario DECIMAL(10, 2) NOT NULL,
        Subtotal DECIMAL(10, 2) GENERATED ALWAYS AS (Cantidad * PrecioUnitario) STORED,
        FOREIGN KEY (VentaID) REFERENCES Ventas(VentaID),
        FOREIGN KEY (ArticuloID) REFERENCES Articulos(ArticuloID)
    )";
    $conn->exec($sql);
    echo "Tabla DetalleVentas creada correctamente.<br>";

    // Tabla Inventario
    $sql = "CREATE TABLE IF NOT EXISTS Inventario (
        MovimientoID INT AUTO_INCREMENT PRIMARY KEY,
        ArticuloID INT,
        Cantidad INT NOT NULL,
        TipoMovimiento NVARCHAR(50) CHECK (TipoMovimiento IN ('Ingreso', 'Salida')),
        FechaMovimiento DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (ArticuloID) REFERENCES Articulos(ArticuloID)
    )";
    $conn->exec($sql);
    echo "Tabla Inventario creada correctamente.<br>";

} catch (PDOException $e) {
    echo "Error al crear las tablas: " . $e->getMessage();
}
