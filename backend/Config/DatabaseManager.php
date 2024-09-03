<?php
namespace Config;

class DatabaseManager {
    private static $instance = null;
    private $db;

    private function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DatabaseManager();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->db;
    }
}
