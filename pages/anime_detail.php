<?php
// pages/anime_detail.php

session_start();

// Inclusion des classes
require_once '../php/classes/Database.php';
require_once '../php/classes/Anime.php';

$database = new Database();
$db = $database->connect();

// Vérifier la présence du param "id"
if (!isset($_GET['id'])) {
    echo "Aucun anime spécifié.";
    exit;
}
$animeId = intval($_GET['id']);

// Récupérer l'anime
$stmt = $db->prepare("SELECT * FROM animes WHERE id = :id");
$stmt->bindParam(':id', $animeId, PDO::PARAM_INT);
$stmt->execute();
$anime = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$anime) {
    echo "Animé introuvable.";
    exit;
}

// Exemple : on simule 10 épisodes
$episodes = range(1, 10);

include '../components/head.php';
?>
<body>
    <?php include '../components/navbar.php'; ?>

    <div class="anime-detail-container">
        <!-- Colonne Gauche : Liste des épisodes -->
        <div class="left-pane">
            <h2>Liste des Épisodes</h2>
            <div class="episodes-list">
                <?php foreach ($episodes as $ep): ?>
                    <div class="episode-card"
                         onclick="playEpisode(<?php echo $ep; ?>)">
                        Épisode <?php echo $ep; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Colonne Droite : Infos sur l'anime + faux lecteur -->
        <div class="right-pane">
            <div class="anime-info">
                <h1><?php echo htmlspecialchars($anime['title']); ?></h1>
                <img class="anime-cover"
                     src="../assets/images/<?php echo htmlspecialchars($anime['thumbnail']); ?>"
                     alt="<?php echo htmlspecialchars($anime['title']); ?>">

                <p><strong>Genres :</strong> <?php echo htmlspecialchars($anime['genres']); ?></p>
                <p><strong>Année :</strong> <?php echo htmlspecialchars($anime['release_year']); ?></p>
                <p class="anime-description">
                    <?php echo nl2br(htmlspecialchars($anime['description'])); ?>
                </p>
            </div>

            <!-- Faux lecteur (overlay local à la colonne) -->
            <div class="fake-player" id="fakePlayer">
                <h3 id="episodeTitle">Lecture de l'épisode X</h3>
                <div class="player-illustration">
                    Ici se trouverait la vidéo (fictive)
                </div>
                <button class="close-btn" onclick="closePlayer()">Fermer</button>
            </div>
        </div>
    </div>

    <?php include '../components/footer.php'; ?>

    <!-- Script JS pour gérer la sélection d'épisode -->
    <script>
        const fakePlayer = document.getElementById('fakePlayer');
        const episodeTitle = document.getElementById('episodeTitle');

        function playEpisode(num) {
            episodeTitle.textContent = "Lecture de l'épisode " + num;
            // Rendre le lecteur visible
            fakePlayer.style.display = "block";
        }

        function closePlayer() {
            fakePlayer.style.display = "none";
        }
    </script>
</body>
</html>
