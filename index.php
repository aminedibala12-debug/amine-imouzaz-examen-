<?php
require_once 'db.php';

// 2) Récupérer tous les candidats
$stmt = $pdo->query("SELECT * FROM candidats");
$candidats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Élection du Délégué - Accueil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Élection du Délégué de Promotion</h1>

        <?php
        if (isset($_GET['msg'])) {
            if ($_GET['msg'] === 'success') {
                echo "<div class='alert success'>Votre vote a été enregistré avec succès !</div>";
            } elseif ($_GET['msg'] === 'deja_vote') {
                echo "<div class='alert error'>Erreur : Vous avez déjà voté !</div>";
            } elseif ($_GET['msg'] === 'invalide') {
                echo "<div class='alert error'>Veuillez remplir tous les champs.</div>";
            }
        }
        ?>

        <div class="candidats-grid">
            <?php foreach ($candidats as $candidat): ?>
                <div class="carte">
                    <img src="<?= htmlspecialchars($candidat['photo']) ?>" alt="Photo de <?= htmlspecialchars($candidat['nom']) ?>">
                    <h3><?= htmlspecialchars($candidat['nom']) ?></h3>
                    <p><?= nl2br(htmlspecialchars($candidat['programme'])) ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="form-section">
            <h2>Voter</h2>
            <form action="vote.php" method="POST">
                <div class="form-group">
                    <label for="id_etudiant">Votre Identifiant Étudiant :</label>
                    <input type="text" id="id_etudiant" name="id_etudiant" required placeholder="Ex: ETU2026">
                </div>
                
                <div class="form-group">
                    <label for="id_candidat">Choisir un candidat :</label>
                    <select id="id_candidat" name="id_candidat" required>
                        <option value="">-- Sélectionnez votre candidat --</option>
                        <?php foreach ($candidats as $candidat): ?>
                            <option value="<?= $candidat['id'] ?>"><?= htmlspecialchars($candidat['nom']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn">Soumettre mon vote</button>
            </form>
        </div>

        <div class="links">
            <a href="resultats.php" class="btn btn-secondary">Voir les résultats du scrutin</a>
        </div>
    </div>
</body>
</html>