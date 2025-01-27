<?php
require_once '../php/classes/Database.php';
require_once '../php/classes/User.php';

$db = (new Database())->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $db->prepare('INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password_hash)');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password_hash', $password);

    if ($stmt->execute()) {
        header('Location: login.php');
        exit;
    } else {
        $error = 'Erreur lors de l\'inscription.';
    }
}
?>

<?php include '../components/head.php'; ?>
<body>
    <?php include '../components/navbar.php'; ?>

    <div class="auth-container">
        <h1>Inscription</h1>

        <form class="auth-form" method="POST">
            <label>Nom d'utilisateur :</label>
            <input type="text" name="username" required>

            <label>Email :</label>
            <input type="email" name="email" required>

            <label>Mot de passe :</label>
            <input type="password" name="password" required>

            <button type="submit">S'inscrire</button>

            <?php if (isset($error)): ?>
                <p class="error-message"><?php echo $error; ?></p>
            <?php endif; ?>
        </form>

        <div class="auth-links">
            <a href="login.php">Déjà inscrit ? Connectez-vous</a>
        </div>
    </div>

    <?php include '../components/footer.php'; ?>
</body>
</html>
