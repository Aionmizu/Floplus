<?php

class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Vérifier si un utilisateur est connecté
    public function isLoggedIn() {
        return isset($_SESSION['user']);
    }

    // Récupérer les informations de l'utilisateur connecté
    public function getUserInfo($userId) {
        $query = 'SELECT * FROM users WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
