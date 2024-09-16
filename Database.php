<?php
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $dsn = 'mysql:host=localhost;dbname=bookings';
        $username = 'root';
        $password = '';

        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Database connection error']);
            exit();
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->pdo;
    }
}
?>
