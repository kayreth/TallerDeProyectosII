<?php

class ArticleRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db->getConnection();
    }

    public function getAllArticles() {
        $query = "SELECT ArticuloID, 
                         Codigo, 
                         Nombre, 
                         Precio, 
                         Stock,
                         Categoria
                  FROM Articulos";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            throw new Exception('Error al obtener los artículos: ' . $e->getMessage());
        }
    }

    public function getArticleById($id) {
        $query = "SELECT ArticuloID, Codigo, Nombre, Precio, Stock, Categoria 
                  FROM Articulos 
                  WHERE ArticuloID = :id";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            throw new Exception('Error al obtener el artículo: ' . $e->getMessage());
        }
    }

    public function createArticle($data) {
        $query = "INSERT INTO Articulos (Codigo, Nombre, Precio, Stock, Categoria) 
                  VALUES (:codigo, :nombre, :precio, :stock, :categoria)";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':codigo', $data['codigo']);
            $stmt->bindParam(':nombre', $data['nombre']);
            $stmt->bindParam(':precio', $data['precio']);
            $stmt->bindParam(':stock', $data['stock']);
            $stmt->bindParam(':categoria', $data['categoria']);
            return $stmt->execute();
        } catch (\Throwable $e) {
            throw new Exception('Error al crear el artículo: ' . $e->getMessage());
        }
    }

    public function updateArticle($data) {
        $query = "UPDATE Articulos 
                  SET Codigo = :codigo, Nombre = :nombre, Precio = :precio, Stock = :stock, Categoria = :categoria 
                  WHERE ArticuloID = :id";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
            $stmt->bindParam(':codigo', $data['codigo']);
            $stmt->bindParam(':nombre', $data['nombre']);
            $stmt->bindParam(':precio', $data['precio']);
            $stmt->bindParam(':stock', $data['stock']);
            $stmt->bindParam(':categoria', $data['categoria']);
            return $stmt->execute();
        } catch (\Throwable $e) {
            throw new Exception('Error al actualizar el artículo: ' . $e->getMessage());
        }
    }

    public function deleteArticleById($id) {
        $query = "DELETE FROM Articulos WHERE ArticuloID = :id";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\Throwable $e) {
            throw new Exception('Error al borrar el artículo: ' . $e->getMessage());
        }
    }
}

