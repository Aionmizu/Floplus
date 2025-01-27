<?php

class Anime {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    //Récupérer tous les animes
    public function getAllAnimes() {
        $query = 'SELECT * FROM animes';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les animes marqués comme Pépite
    public function getPepites() {
        $query = 'SELECT * FROM animes WHERE pepite = TRUE LIMIT 6';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les animes marqués comme Classique
    public function getClassiques() {
        $query = 'SELECT * FROM animes WHERE classique = TRUE LIMIT 6';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les animes par genre
    public function getAnimesByGenre($genre) {
        $query = 'SELECT * FROM animes WHERE genres LIKE :genre LIMIT 6';
        $stmt = $this->db->prepare($query);
        $genreWildcard = '%' . $genre . '%';
        $stmt->bindParam(':genre', $genreWildcard);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function searchAnimes($query) {
        try {
            // Préparer la requête SQL
            $sql = "SELECT * FROM animes WHERE title LIKE :query OR description LIKE :query";
            $stmt = $this->db->prepare($sql);

            // Ajouter les jokers pour la recherche
            $searchQuery = "%" . $query . "%";
            $stmt->bindParam(':query', $searchQuery, PDO::PARAM_STR);

            // Exécuter la requête
            $stmt->execute();

            // Récupérer les résultats
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la recherche des animes : " . $e->getMessage();
            return [];
        }
    }

}
