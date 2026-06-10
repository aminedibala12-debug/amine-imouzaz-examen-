-- 1) Création de la base de données
CREATE DATABASE vote_electronique_db;
USE vote_electronique_db;

-- 2) Création des tables
CREATE TABLE candidats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    photo VARCHAR(255) NOT NULL,
    programme TEXT NOT NULL
);

CREATE TABLE votes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_etudiant VARCHAR(20) NOT NULL UNIQUE, -- Le UNIQUE garantit un seul vote au niveau SQL
    id_candidat INT NOT NULL,
    date_vote DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_candidat) REFERENCES candidats(id) ON DELETE CASCADE
);

-- 3) Insertion de trois (3) candidats de test
INSERT INTO candidats (nom, photo, programme) VALUES
('Ahmed Alami', 'https://via.placeholder.com/150/007bff/ffffff?text=Ahmed', 'Amélioration du Wi-Fi et des espaces de travail.'),
('Sara Benali', 'https://via.placeholder.com/150/28a745/ffffff?text=Sara', 'Organisation de tournois e-sport et sorties culturelles.'),
('Youssef Tazi', 'https://via.placeholder.com/150/dc3545/ffffff?text=Youssef', 'Création d\'un club de robotique et tutorat entre étudiants.');