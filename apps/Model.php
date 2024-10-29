<?php

class Model {
    protected $db;

    public function __construct() {
        $this->db = new DB(); // Inisialisasi objek DB
        if ($this->db->connect('mysql', 'localhost', 'root', '', 'lkmvc_db', 3306, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ])) {
            // Database connected successfully
        } else {
            die('Database connection failed: ' . $this->db->error());
        }
    }
}