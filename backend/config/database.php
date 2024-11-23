<?php
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $port;
    private $charset = 'utf8mb4';
    private $pdo;

    public function __construct($host, $db_name, $username, $password, $port) {
        $this->host = $host;
        $this->db_name = $db_name;
        $this->username = $username;
        $this->password = $password;
        $this->port = $port;
    }

    public function connect() {
        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db_name};charset={$this->charset}";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
    
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);

        } catch (PDOException $e) {
           //die("Error de conexión: " . $e->getMessage());
           header('Location: ../pdv/400.php');
           exit();
        }
    }

    public function getConnection() {
        return $this->pdo;
    }
}
?>