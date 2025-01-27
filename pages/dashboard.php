<?php
session_start();
require_once '../php/classes/Database.php';
require_once '../php/classes/Anime.php';  // <-- Ajout pour accéder à la classe Anime

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$db = (new Database())->connect();
$animeObj = new Anime($db); // Instanciation de votre classe Anime

// Récupération de la liste de tous les animes pour alimenter les <select>
$animeList = $animeObj->getAllAnimes();

// --- 1) Récupération infos user ---
$userId = $_SESSION['user'];
$stmt = $db->prepare('SELECT * FROM users WHERE id = :id');
$stmt->bindParam(':id', $userId);
$stmt->execute();
$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$currentUser) {
    header('Location: login.php');
    exit;
}

// --- 2) Vérifier s'il est admin ---
$isAdmin = ($currentUser['role'] === 'admin');

// --- 3) Si admin, on récupère tous les utilisateurs ---
if ($isAdmin) {
    $stmtAll = $db->prepare('SELECT id, username, email, role,
                                    favorite_anime_1, favorite_anime_2, favorite_anime_3
                             FROM users');
    $stmtAll->execute();
    $users = $stmtAll->fetchAll(PDO::FETCH_ASSOC);
}

// --- 4) Suppression d'un utilisateur (admin only) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_id']) && $isAdmin) {
    $idToDelete = $_POST['delete_user_id'];
    if ($idToDelete == $userId) {
        // Optionnel : empêcher la suppression de soi-même
        $errorMsg = "Vous ne pouvez pas vous supprimer vous-même.";
    } else {
        $deleteStmt = $db->prepare('DELETE FROM users WHERE id = :id');
        $deleteStmt->bindParam(':id', $idToDelete);
        $deleteStmt->execute();
        header("Location: dashboard.php");
        exit;
    }
}

// --- 5) Mise à jour des 3 animés préférés (pour l'utilisateur connecté) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_anime'])) {
    // Récupère le "titre" sélectionné dans chaque <select>
    $anime1 = $_POST['anime1'] ?? null;
    $anime2 = $_POST['anime2'] ?? null;
    $anime3 = $_POST['anime3'] ?? null;

    $updateStmt = $db->prepare('UPDATE users
                                SET favorite_anime_1 = :a1,
                                    favorite_anime_2 = :a2,
                                    favorite_anime_3 = :a3
                                WHERE id = :id');
    $updateStmt->bindParam(':a1', $anime1);
    $updateStmt->bindParam(':a2', $anime2);
    $updateStmt->bindParam(':a3', $anime3);
    $updateStmt->bindParam(':id', $userId);

    if ($updateStmt->execute()) {
        $successMsg = "Vos animés préférés ont bien été mis à jour.";
        // On rafraîchit les infos du user
        $stmt->execute();
        $currentUser = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $errorMsg = "Erreur lors de la mise à jour de vos animés préférés.";
    }
}

?>

<?php include '../components/head.php'; ?>
<body>
    <?php include '../components/navbar.php'; ?>

    <div class="dashboard-container">

        <!-- Accueil de l'utilisateur -->
        <div class="user-welcome">
            <h1>Bienvenue, <?php echo htmlspecialchars($currentUser['username']); ?> !</h1>
            <p>Votre rôle : <span class="role-tag"><?php echo htmlspecialchars($currentUser['role']); ?></span></p>
        </div>

        <!-- Formulaire pour gérer les 3 animés préférés -->
        <div class="anime-section">
            <h2>Vos 3 animés préférés</h2>
            <form method="POST">
                <input type="hidden" name="update_anime" value="1" />

                <!-- Animé 1 -->
                <label for="anime1">Animé 1</label>
                <select name="anime1" id="anime1">
                    <option value="">-- Sélectionner un animé --</option>
                    <?php foreach ($animeList as $anime): ?>
                        <?php
                            // Si le user a déjà ce titre en base, on marque "selected"
                            $selected = ($anime['title'] == $currentUser['favorite_anime_1']) ? 'selected' : '';
                        ?>
                        <option value="<?php echo htmlspecialchars($anime['title']); ?>" <?php echo $selected; ?>>
                            <?php echo htmlspecialchars($anime['title']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Animé 2 -->
                <label for="anime2">Animé 2</label>
                <select name="anime2" id="anime2">
                    <option value="">-- Sélectionner un animé --</option>
                    <?php foreach ($animeList as $anime): ?>
                        <?php
                            $selected = ($anime['title'] == $currentUser['favorite_anime_2']) ? 'selected' : '';
                        ?>
                        <option value="<?php echo htmlspecialchars($anime['title']); ?>" <?php echo $selected; ?>>
                            <?php echo htmlspecialchars($anime['title']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Animé 3 -->
                <label for="anime3">Animé 3</label>
                <select name="anime3" id="anime3">
                    <option value="">-- Sélectionner un animé --</option>
                    <?php foreach ($animeList as $anime): ?>
                        <?php
                            $selected = ($anime['title'] == $currentUser['favorite_anime_3']) ? 'selected' : '';
                        ?>
                        <option value="<?php echo htmlspecialchars($anime['title']); ?>" <?php echo $selected; ?>>
                            <?php echo htmlspecialchars($anime['title']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="button">
                    <button type="submit">Mettre à jour</button>
                </div>
            </form>

            <!-- Afficher messages de succès/erreur -->
            <?php if (!empty($successMsg)): ?>
                <p class="success-msg"><?php echo htmlspecialchars($successMsg); ?></p>
            <?php endif; ?>
            <?php if (!empty($errorMsg)): ?>
                <p class="error-msg"><?php echo htmlspecialchars($errorMsg); ?></p>
            <?php endif; ?>
        </div>

        <!-- Section Admin : liste des utilisateurs + suppression -->
        <?php if ($isAdmin): ?>
            <div class="admin-section">
                <h2>Liste des utilisateurs</h2>
                <div class="table-container">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom d'utilisateur</th>
                                <th>Email</th>
                                <th>Animé 1</th>
                                <th>Animé 2</th>
                                <th>Animé 3</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo htmlspecialchars($user['favorite_anime_1'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($user['favorite_anime_2'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($user['favorite_anime_3'] ?? ''); ?></td>
                                    <td>
                                        <!-- Bouton supprimer (ne pas se supprimer soi-même) -->
                                        <?php if ($user['id'] != $userId): ?>
                                            <form method="POST" onsubmit="return confirm('Supprimer cet utilisateur ?');">
                                                <input type="hidden" name="delete_user_id" value="<?php echo $user['id']; ?>">
                                                <button type="submit" class="delete-btn">-</button>
                                            </form>
                                        <?php else: ?>
                                            <em>Vous-même</em>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <p class="no-access">Vous n'êtes pas administrateur. Accès limité.</p>
        <?php endif; ?>
    </div>

    <?php include '../components/footer.php'; ?>
</body>
</html>
