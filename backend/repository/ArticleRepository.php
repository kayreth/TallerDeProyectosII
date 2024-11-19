<?php

class ArticleRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db->getConnection();
    }

    public function getAllArticles() {
        $query = "SELECT id, name, category, price, stock FROM articulos"; // Ajusta los nombres según tu tabla
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>