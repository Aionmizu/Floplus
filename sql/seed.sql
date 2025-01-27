INSERT INTO users (username, email, password_hash) VALUES
                                                       ('JohnDoe', 'john@example.com', 'hashed_password_1'),
                                                       ('JaneDoe', 'jane@example.com', 'hashed_password_2'),
                                                       ('OtakuFan', 'otaku@example.com', 'hashed_password_3'),
                                                       ('AnimeLover', 'lover@example.com', 'hashed_password_4'),
                                                       ('NarutoFan', 'naruto@example.com', 'hashed_password_5');

-- Ajouter des animes avec classique et pépite
INSERT INTO animes (title, description, genres, release_year, thumbnail, classique, pepite) VALUES
                                                                                                ('Attack on Titan', 'Anime de guerre et de mystère.', 'Action, Aventure', 2013, 'aot.jpg', FALSE, TRUE),
                                                                                                ('Demon Slayer', 'Un jeune garçon lutte contre les démons.', 'Action, Fantastique', 2019, 'demonslayer.jpg', FALSE, TRUE),
                                                                                                ('One Piece', 'Luffy et son équipage cherchent le trésor ultime.', 'Action, Aventure, Comédie', 1999, 'onepiece.jpg', TRUE, TRUE),
                                                                                                ('Naruto', 'Un ninja rêve de devenir Hokage.', 'Action, Aventure', 2002, 'naruto.jpg', TRUE, TRUE),
                                                                                                ('Death Note', 'Un cahier qui tue quiconque y est nommé.', 'Thriller, Mystère', 2006, 'deathnote.jpg', TRUE, TRUE),
                                                                                                ('Dragon Ball Z', 'Les aventures de Goku et de ses amis.', 'Action, Arts martiaux', 1989, 'dbz.jpg', TRUE, FALSE),
                                                                                                ('Jujutsu Kaisen', 'Un étudiant affronte des malédictions.', 'Action, Fantastique', 2020, 'jujutsu.jpg', FALSE, TRUE),
                                                                                                ('My Hero Academia', 'Des étudiants s’entraînent pour devenir des héros.', 'Action, Comédie', 2016, 'mha.jpg', FALSE, TRUE),
                                                                                                ('Sword Art Online', 'Des joueurs piégés dans un MMORPG mortel.', 'Action, Fantastique', 2012, 'sao.jpg', FALSE, FALSE),
                                                                                                ('Fullmetal Alchemist: Brotherhood', 'Deux frères cherchent la pierre philosophale.', 'Action, Drame, Fantastique', 2009, 'fma.jpg', TRUE, TRUE),
                                                                                                ('Bleach', 'Un lycéen devient un shinigami.', 'Action, Aventure', 2004, 'bleach.jpg', TRUE, TRUE),
                                                                                                ('Hunter x Hunter', 'Un garçon devient un chasseur professionnel.', 'Action, Aventure', 1999, 'hxh.jpg', TRUE, TRUE),
                                                                                                ('Tokyo Ghoul', 'Un jeune homme devient un mi-humain mi-ghoul.', 'Horreur, Thriller', 2014, 'tokyoghoul.jpg', FALSE, TRUE),
                                                                                                ('Re:Zero', 'Un garçon revit encore et encore après sa mort.', 'Fantastique, Drame', 2016, 'rezero.jpg', FALSE, TRUE),
                                                                                                ('Black Clover', 'Deux orphelins rêvent de devenir empereur-mage.', 'Action, Fantastique', 2017, 'blackclover.jpg', FALSE, FALSE);

--Update les roles de l'utilisateur
UPDATE users SET role = 'user' WHERE email IN (
                                               'john@example.com',
                                               'jane@example.com',
                                               'otaku@example.com',
                                               'lover@example.com',
                                               'naruto@example.com'
    );

UPDATE users SET role = 'admin' WHERE email = 'admin@admin';

--
DELETE FROM users
WHERE role <> 'admin';
