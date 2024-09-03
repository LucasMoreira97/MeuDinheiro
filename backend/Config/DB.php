<?php

namespace Config;

class DB {

    protected $db;

    public function __construct() {
        $this->db = DatabaseManager::getInstance()->getConnection();
    }
}
