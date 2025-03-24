<?php
require_once '../classes/Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $db = (new Database())->connect();

        $username = htmlspecialchars($_POST['username']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        // Vérification : pseudo ou mail déjà utilisé ?
        $checkStmt = $db->prepare('SELECT * FROM users WHERE username = :username OR email = :email');
        $checkStmt->bindParam(':username', $username);
        $checkStmt->bindParam(':email', $email);
        $checkStmt->execute();
        $existingUser = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            if ($existingUser['username'] === $username) {
                echo "Erreur : Le nom d'utilisateur est déjà pris.";
            } elseif ($existingUser['email'] === $email) {
                echo "Erreur : Cette adresse email est déjà utilisée.";
            }
        } else {
            $stmt = $db->prepare('INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password_hash)');
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password_hash', $password_hash);

            if ($stmt->execute()) {
                header('Location: ../../pages/login.php');
                exit;
            } else {
                echo "Erreur : Impossible d'enregistrer l'utilisateur.";
            }
        }

    } catch (PDOException $e) {
        echo 'Erreur PDO : ' . $e->getMessage();
    }
}
?>
