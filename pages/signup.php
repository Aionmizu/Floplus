<?php
require_once '../php/classes/Database.php';
require_once '../php/classes/User.php';

// Connexion à la base de données
$db = (new Database())->connect();

// Variable pour stocker d'éventuels messages d'erreur
$error = '';

// Si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sécurisation des entrées
    $username = htmlspecialchars($_POST['username']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    try {
        // Vérifie si le nom d'utilisateur ou l'email sont déjà utilisés
        $stmtCheck = $db->prepare('SELECT 1 FROM users WHERE username = :username OR email = :email');
        $stmtCheck->bindParam(':username', $username);
        $stmtCheck->bindParam(':email', $email);
        $stmtCheck->execute();

        // Si un enregistrement existe déjà, on renvoie une erreur
        if ($stmtCheck->fetch()) {
            $error = "Nom d'utilisateur ou email déjà utilisé.";
        } else {
            // Tentative d'insertion de l'utilisateur
            $stmt = $db->prepare(
                'INSERT INTO users (username, email, password_hash) 
                 VALUES (:username, :email, :password_hash)'
            );
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password_hash', $password);

            if ($stmt->execute()) {
                // Redirection en cas de succès
                header('Location: login.php');
                exit;
            } else {
                $error = "Erreur lors de l'inscription.";
            }
        }
    } catch (PDOException $e) {
        // Gestion spécifique des erreurs PDO (ex: duplicata)
        if ($e->errorInfo[1] == 1062) {
            $error = 'Cet email ou nom d\'utilisateur est déjà utilisé.';
        } else {
            $error = 'Erreur lors de l\'inscription : ' . $e->getMessage();
        }
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

        <?php if (!empty($error)): ?>
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
