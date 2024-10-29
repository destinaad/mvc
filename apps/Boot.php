<?php

require "config.php";
require "Controller.php";
require "Database.php";
require "Model.php";

class Boot {
    protected $controller = 'Index';
    protected $action = 'Index';
    protected $params = [];
    protected $db; // Tambahkan properti database

    public function __construct() {
        // Inisialisasi koneksi database
        $this->db = new DB();
        if (!$this->db->connect('mysql', 'localhost', 'root', '', 'nama_database', 3306, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ])) {
            die('Database connection failed: ' . $this->db->error());
        }

        // Lanjutkan routing atau logika lainnya
        $url = isset($_GET['r']) ? $_GET['r'] : null;
        $url = $this->parseUrl($url);

        // Controller logic
        if (isset($url[0]) && file_exists('apps/controllers/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        }

        require('apps/controllers/' . $this->controller . '.php');
        $this->controller = new $this->controller($this->db); // Berikan objek DB ke controller

        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->action = $url[1];
            unset($url[1]);
        }

        $this->params = !empty($url) ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->action], $this->params);
    }

    // Parsing URL
    public function parseUrl($url) {
        if ($url !== null) {
            $url = rtrim($url, '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode("/", $url);
        }
        return [];
    }
}