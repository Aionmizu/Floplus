<?php
session_start();
require_once '../php/classes/Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $db = (new Database())->connect();
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData && password_verify($password, $userData['password_hash'])) {
            $_SESSION['user'] = $userData['id'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Email ou mot de passe incorrect.';
        }
    } catch (Exception $e) {
        $error = 'Erreur : ' . $e->getMessage();
    }
}
?>

<?php include '../components/head.php'; ?>
<body>
    <?php include '../components/navbar.php'; ?>

    <div class="auth-container">
        <h1>Connexion</h1>

        <form class="auth-form" method="POST" action="../php/handlers/login.php">
            <label>Email :</label>
            <input type="email" name="email" placeholder="Entrez votre email" required>

            <label>Mot de passe :</label>
            <input type="password" name="password" placeholder="Entrez votre mot de passe" required>

            <button type="submit">Se connecter</button>

            <?php if (isset($error)): ?>
                <p class="error-message"><?php echo $error; ?></p>
                <!-- Bouton pour revenir à la page précédente -->
            <?php endif; ?>
        </form>

        <div class="auth-links">
            <a href="signup.php">Pas encore de compte ? Inscrivez-vous</a>
        </div>
    </div>

    <?php include '../components/footer.php'; ?>
</body>
</html>
