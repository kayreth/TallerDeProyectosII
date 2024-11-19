<?php
class Database {
    private $host = '';
    private $db_name = '';
    private $username = '';
    private $password = '';
    private $port = '';
    private $charset = 'utf8mb4';
    private $pdo;

    public function __construct() {
        $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db_name};charset={$this->charset}";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            echo json_encode(['error' => "Error en la conexión"]);
            exit();
        }
    }

    public function getConnection() {
        return $this->pdo;
    }
}
?>