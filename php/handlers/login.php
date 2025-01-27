<?php
session_start();
require_once '../classes/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = (new Database())->connect();
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user'] = $user['id'];
            header('Location: ../../pages/dashboard.php');
            exit;
        } else {
            echo 'Email ou mot de passe incorrect.';
            echo '<br><br>';
            echo '<button
                    style="
                        background-color: #e573ff;
                        color: #ffffff;
                        padding: 10px 15px;
                        border: none;
                        border-radius: 4px;
                        cursor: pointer;
                    "
                    onclick="history.back()"
                >
                Retour
                </button>';
        }

    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
    }
}
?>
