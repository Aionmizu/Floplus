-- Création de la table des utilisateurs
CREATE TABLE users (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       username VARCHAR(50) NOT NULL,
                       email VARCHAR(100) NOT NULL UNIQUE,
                       password_hash VARCHAR(255) NOT NULL,
                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Création de la table des animes
CREATE TABLE animes (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        title VARCHAR(100) NOT NULL,
                        description TEXT,
                        genres VARCHAR(100),
                        release_year INT,
                        thumbnail VARCHAR(255),
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Création de la table des favoris (relation entre utilisateurs et animes)
CREATE TABLE favorites (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           user_id INT,
                           anime_id INT,
                           created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                           FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                           FOREIGN KEY (anime_id) REFERENCES animes(id) ON DELETE CASCADE
);

ALTER TABLE animes
ADD COLUMN pepite BOOLEAN DEFAULT FALSE,
ADD COLUMN classique BOOLEAN DEFAULT FALSE;

-- Création de rôle admin--
ALTER TABLE users ADD COLUMN role ENUM('user', 'admin') DEFAULT 'user';
