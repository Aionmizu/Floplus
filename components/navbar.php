<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="index.php">
            <img src="../assets/images/logo.webp" alt="Logo" style="height: 40px;">
        </a>

        <!-- Bouton pour mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Liens de navigation -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="anime.php">Anime</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Mon compte</a>
                </li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../php/handlers/logout.php">Déconnexion</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="signup.php">Inscription</a>
                    </li>
                <?php endif; ?>
            </ul>

            <!-- Formulaire de recherche -->
            <form class="d-flex" action="search.php" method="GET">
                <input class="form-control me-2" type="text" name="q" placeholder="Rechercher un anime..." aria-label="Rechercher">
                <button class="btn btn-outline-light" type="submit">Rechercher</button>
            </form>
        </div>
    </div>
</nav>
