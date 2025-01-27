<?php
// pages/anime.php

// On démarre la session (si besoin de sessions, par ex. pour user login)
session_start();

// Inclusion des classes
require_once '../php/classes/Database.php';
require_once '../php/classes/Anime.php';

// Connexion à la base
$database = new Database();
$db = $database->connect();

// Instanciation de la classe Anime
$animeClass = new Anime($db);

// Vérifier si on a un paramètre de recherche (ex: ?q=naruto)
$results = [];
$searchQuery = null;

if (isset($_GET['q']) && !empty($_GET['q'])) {
    $searchQuery = htmlspecialchars($_GET['q']);
    // Faire la recherche
    $results = $animeClass->searchAnimes($searchQuery);
} else {
    // Sinon, récupérer tous les animes
    $results = $animeClass->getAllAnimes();
}

// Inclure l'entête HTML (head) et la navbar
include '../components/head.php';
?>
<body>
    <?php include '../components/navbar.php'; ?>

    <main class="catalog">
        <h2>Catalogue des Animes</h2>

        <!-- Formulaire de recherche (optionnel) -->
        <form action="anime.php" method="get" class="search-form">
            <input type="text" name="q" placeholder="Rechercher un anime..."
                   value="<?php echo $searchQuery ? htmlspecialchars($searchQuery) : ''; ?>"
                   class="search-input">
            <button type="submit" class="search-button">Chercher</button>
        </form>

        <div class="catalog-sections">
            <div class="content-cards">
                <?php if (!empty($results)): ?>
                    <?php foreach ($results as $anime): ?>
                        <!-- On crée un lien cliquable vers anime_detail.php?id=XX -->
                        <a href="anime_detail.php?id=<?php echo $anime['id']; ?>" class="card-link">
                            <div class="card">
                                <img src="../assets/images/<?php echo htmlspecialchars($anime['thumbnail']); ?>"
                                     alt="<?php echo htmlspecialchars($anime['title']); ?>">
                                <h3><?php echo htmlspecialchars($anime['title']); ?></h3>
                                <p><strong>Genres :</strong> <?php echo htmlspecialchars($anime['genres']); ?></p>
                                <p><strong>Année :</strong> <?php echo htmlspecialchars($anime['release_year']); ?></p>
                                <p>
                                    <?php
                                    // On limite éventuellement la description :
                                    echo mb_strimwidth(htmlspecialchars($anime['description']), 0, 100, '...');
                                    ?>
                                </p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Si aucun résultat (recherche ou table vide) -->
                    <p>Aucun anime à afficher.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include '../components/footer.php'; ?>
</body>
</html>
