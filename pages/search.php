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

<!-- Head-->
<?php include '../components/head.php'; ?>
<!-- Barre de navigation -->
<?php include '../components/navbar.php'; ?>
<main>
    <section class="catalog">
        <div class="catalog-sections">
            <div class="content-cards">
                <?php
                if (isset($_GET['q'])) {
                    $query = htmlspecialchars($_GET['q']);
                    $results = $animeClass->searchAnimes($query);

                    // Afficher les résultats
                    if (!empty($results)) {
                        foreach ($results as $anime) {
                            echo '<div class="card">';
                            echo '<a href="anime_detail.php?id=' . $anime['id'] . '" class="card-link">';
                            echo '<img src="../assets/images/' . htmlspecialchars($anime['thumbnail']) . '" alt="' . htmlspecialchars($anime['title']) . '">';
                            echo '<h3>' . htmlspecialchars($anime['title']) . '</h3>';
                            echo '<p>' . htmlspecialchars($anime['description']) . '</p>';
                            echo '</a>';
                            echo '</div>';
                         }
                    } else {
                        echo '<p>Aucun résultat trouvé pour "' . htmlspecialchars($query) . '"</p>';
                    }
                }
                ?>
            </div>
        </div>
    </section>
</main>

<!-- Pied de page -->
<?php include '../components/footer.php'; ?>
</body>
</html>