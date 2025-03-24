<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'floplus';
    private $username = 'root'; // Remplacez 'root' si vous avez un autre utilisateur
    private $password = ''; // Ajoutez votre mot de passe si nécessaire
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Erreur de connexion : ' . $e->getMessage();
        }

        return $this->conn;
    }

}
