<?php

class CustomerRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db->getConnection();
    }

    public function getAllCustomers() {
        $query = "SELECT ClienteID, 
                         Nombre, 
                         Direccion, 
                         Telefono,
                         Email FROM Clientes";
        try {
         $stmt = $this->db->prepare($query);
         $stmt->execute();
        } catch (\Throwable $e) {
        //die("Error de conexión: " . $e->getMessage());
         header('Location: ../pdv/400.php');
         exit();
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteCustomerById($id) {
        $query = "DELETE FROM Clientes WHERE ClienteID = :id";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\Throwable $e) {
            header('Location: ../pdv/400.php');
            exit();
        }
    }

    public function getCustomerById($id) {
        $query = "SELECT ClienteID, Nombre, Direccion, Telefono, Email 
                  FROM Clientes 
                  WHERE ClienteID = :id";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            throw new Exception('Error al obtener los detalles del cliente: ' . $e->getMessage());
        }
    }

    public function createCustomer($data) {
        $query = "INSERT INTO Clientes (Nombre, Email, Telefono, Direccion) 
                  VALUES (:nombre, :email, :telefono, :direccion)";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nombre', $data['nombre']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':telefono', $data['telefono']);
            $stmt->bindParam(':direccion', $data['direccion']);
            return $stmt->execute();
        } catch (\Throwable $e) {
            throw new Exception('Error al crear el cliente: ' . $e->getMessage());
        }
    }
    
    public function updateCustomer($data) {
        $query = "UPDATE Clientes 
                  SET Nombre = :nombre, 
                      Email = :email, 
                      Telefono = :telefono, 
                      Direccion = :direccion 
                  WHERE ClienteID = :id";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $data['nombre']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':telefono', $data['telefono']);
            $stmt->bindParam(':direccion', $data['direccion']);
            return $stmt->execute();
        } catch (\Throwable $e) {
            throw new Exception('Error al actualizar el cliente: ' . $e->getMessage());
        }
    }
    

}
?>