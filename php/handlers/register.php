<?php
require_once '../classes/Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $db = (new Database())->connect();
        $username = htmlspecialchars($_POST['username']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $stmt = $db->prepare('INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password_hash)');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password_hash', $password);

        if ($stmt->execute()) {
            header('Location: ../../pages/login.php');
            exit;
        } else {
            throw new Exception('Erreur : impossible de s’inscrire.');
        }
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
    }
}
?>
