<?php
// Inclure les fichiers nécessaires
require_once '../php/classes/Database.php';
require_once '../php/classes/Anime.php';

// Vérifier si la session est déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Connexion à la base de données
$database = new Database();
$db = $database->connect();

// Initialiser la classe Anime
$animeClass = new Anime($db);

// Récupérer les animes par catégories
$classiques = $animeClass->getClassiques();
$pepites = $animeClass->getPepites();
$action = $animeClass->getAnimesByGenre('Action');
$comedie = $animeClass->getAnimesByGenre('Comédie');
?>

<!-- Head-->
<?php include '../components/head.php'; ?>

<body>
    <!-- Barre de navigation -->
    <?php include '../components/navbar.php'; ?>

    <!-- Section principale : Vidéo d'entrée -->
    <main>
        <section class="intro-video">
            <div class="video-wrapper">
                <video
                    autoplay
                    muted
                    loop
                    playsinline
                    style="width: 100%; height: 100%; object-fit: cover;">
                    <source src="../assets/videos/videoplayback.mp4" type="video/mp4" />
                    Votre navigateur ne supporte pas la balise vidéo HTML5.
                </video>

                <div class="video-overlay">
                    <h1>Bienvenue sur FloPlus</h1>
                    <p>Découvrez notre incroyable catalogue d'animes, soigneusement sélectionné pour vous !</p>
                </div>
            </div>
        </section>



        <!-- Section : Classiques -->
        <section class="catalog">
            <h2>Animés Classiques</h2>
            <div class="catalog-sections">
                <div class="content-cards">
                    <?php foreach ($classiques as $anime): ?>
                        <div class="card">
                            <a href="anime_detail.php?id=<?php echo $anime['id']; ?>" class="card-link">
                                <img src="../assets/images/<?php echo htmlspecialchars($anime['thumbnail']); ?>" alt="<?php echo htmlspecialchars($anime['title']); ?>">
                                <h3><?php echo htmlspecialchars($anime['title']); ?></h3>
                                <p><strong>Genres :</strong> <?php echo htmlspecialchars($anime['genres']); ?></p>
                                <p><?php echo htmlspecialchars($anime['description']); ?></p>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Section : Pépites -->
        <section class="catalog">
            <h2>Les Pépites</h2>
            <div class="catalog-sections">
                <div class="content-cards">
                    <?php foreach ($pepites as $anime): ?>
                        <div class="card">
                            <a href="anime_detail.php?id=<?php echo $anime['id']; ?>" class="card-link">
                                <img src="../assets/images/<?php echo htmlspecialchars($anime['thumbnail']); ?>" alt="<?php echo htmlspecialchars($anime['title']); ?>">
                                <h3><?php echo htmlspecialchars($anime['title']); ?></h3>
                                <p><strong>Genres :</strong> <?php echo htmlspecialchars($anime['genres']); ?></p>
                                <p><?php echo htmlspecialchars($anime['description']); ?></p>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Section : Action -->
        <section class="catalog">
            <h2>Action</h2>
            <div class="catalog-sections">
                <div class="content-cards">
                    <?php foreach ($action as $anime): ?>
                        <div class="card">
                            <a href="anime_detail.php?id=<?php echo $anime['id']; ?>" class="card-link">
                                <img src="../assets/images/<?php echo htmlspecialchars($anime['thumbnail']); ?>" alt="<?php echo htmlspecialchars($anime['title']); ?>">
                                <h3><?php echo htmlspecialchars($anime['title']); ?></h3>
                                <p><strong>Genres :</strong> <?php echo htmlspecialchars($anime['genres']); ?></p>
                                <p><?php echo htmlspecialchars($anime['description']); ?></p>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Section : Comédie -->
        <section class="catalog">
            <h2>Comédie</h2>
            <div class="catalog-sections">
                <div class="content-cards">
                    <?php foreach ($comedie as $anime): ?>
                        <div class="card">
                            <a href="anime_detail.php?id=<?php echo $anime['id']; ?>" class="card-link">
                                <img src="../assets/images/<?php echo htmlspecialchars($anime['thumbnail']); ?>" alt="<?php echo htmlspecialchars($anime['title']); ?>">
                                <h3><?php echo htmlspecialchars($anime['title']); ?></h3>
                                <p><strong>Genres :</strong> <?php echo htmlspecialchars($anime['genres']); ?></p>
                                <p><?php echo htmlspecialchars($anime['description']); ?></p>
                            </a>
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
