<?php
// Inclure les fichiers nécessaires
require_once '../php/classes/Database.php';
require_once '../php/classes/Anime.php';

// Démarrer la session
session_start();

// Connexion à la base de données
$database = new Database();
$db = $database->connect();

// Initialiser la classe Anime
$animeClass = new Anime($db);

// Récupérer tous les animes
$animes = $animeClass->getAllAnimes();

?>

<?php include '../components/head.php'; ?>

<body>
    <!-- Barre de navigation -->
    <?php include '../components/navbar.php'; ?>
    <?php
    if (isset($_GET['q'])) {
        $query = htmlspecialchars($_GET['q']);
        $results = $animeClass->searchAnimes($query);

        // Afficher les résultats
        if (!empty($results)) {
            foreach ($results as $anime) {
                echo '<div class="card">';
                echo '<img src="../assets/images/' . htmlspecialchars($anime['thumbnail']) . '" alt="' . htmlspecialchars($anime['title']) . '">';
                echo '<h3>' . htmlspecialchars($anime['title']) . '</h3>';
                echo '<p>' . htmlspecialchars($anime['description']) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>Aucun résultat trouvé pour "' . htmlspecialchars($query) . '"</p>';
        }
    }
    ?>

<!-- Section principale : Catalogue -->
<main>
    <section class="catalog">
        <h2>Catalogue des Animes</h2>
        <div class="catalog-sections">
            <div class="content-cards">
                <?php foreach ($animes as $anime): ?>
                    <div class="card">
                        <img src="../assets/images/<?php echo htmlspecialchars($anime['thumbnail']); ?>" alt="<?php echo htmlspecialchars($anime['title']); ?>">
                        <h3><?php echo htmlspecialchars($anime['title']); ?></h3>
                        <p><strong>Genres :</strong> <?php echo htmlspecialchars($anime['genres']); ?></p>
                        <p><strong>Année :</strong> <?php echo htmlspecialchars($anime['release_year']); ?></p>
                        <p><?php echo htmlspecialchars($anime['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<!-- Pied de page -->
<?php include '../components/footer.php'; ?>
</body>
</html>
