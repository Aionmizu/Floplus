/anime-sama-clone
    /pages                    # Pages principales (HTML/PHP)
        index.php             # Page d'accueil
        login.php             # Page de connexion
        signup.php            # Page d'inscription
        anime.php             # Page individuelle pour un anime
        dashboard.php         # Tableau de bord utilisateur
    /styles                   # Fichiers CSS
        style.css             # Styles principaux
        responsive.css        # Styles adaptatifs
        dark-mode.css         # Optionnel : Mode sombre
    /php                      # Scripts PHP
        /classes              # Classes PHP
            Database.php      # Connexion à la base de données
            User.php          # Gestion des utilisateurs
            Anime.php         # Gestion des animes
        /handlers             # Gestion des actions utilisateur
            register.php      # Script pour l'inscription
            login.php         # Script pour la connexion
            logout.php        # Script pour la déconnexion
    /js                       # Fichiers JavaScript
        app.js                # Scripts globaux (AJAX, etc.)
        search.js             # Recherche dynamique
        dark-mode.js          # Gestion du mode sombre
    /frameworks
        /bootstrap
            bootstrap.min.css
            bootstrap.min.js
        /swiper
            swiper-bundle.min.css
            swiper-bundle.min.js
        /vue
            vue.global.js
    /components               # Composants réutilisables
        navbar.php            # Barre de navigation
        footer.php            # Pied de page
    /assets                   # Ressources graphiques
        /images               # Images (miniatures, bannières, etc.)
        /fonts                # Polices personnalisées
    /sql                      # Fichiers SQL
        schema.sql            # Structure des tables
        seed.sql              # Données de base pour tests
    /docs                     # Documentation
        README.md             # Guide d'installation et d'utilisation
        INSTALL.md            # Instructions spécifiques au déploiement
    .env                      # Variables sensibles (API keys, DB credentials)
    .htaccess                 # Fichier Apache pour la réécriture d'URL
