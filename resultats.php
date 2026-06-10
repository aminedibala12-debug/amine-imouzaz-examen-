<?php
require_once 'db.php';

// 1) Récupérer le nombre total de votes exprimés dans l'élection
$totalStmt = $pdo->query("SELECT COUNT(*) FROM votes");
$total_votes_global = $totalStmt->fetchColumn();

// 2) Récupérer le nombre de votes par candidat (avec Jointure LEFT JOIN)
$sql = "
    SELECT c.nom, c.photo, COUNT(v.id) AS total_votes
    FROM candidats c
    LEFT JOIN votes v ON c.id = v.id_candidat
    GROUP BY c.id
    ORDER BY total_votes DESC
";
$stmt = $pdo->query($sql);
$resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats du vote</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Petits ajouts de style spécifiques pour les barres de progression */
        .stats-box {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
            display: inline-block;
        }
        .progress-bar-container {
            background-color: #e2e8f0;
            border-radius: 9999px;
            width: 100%;
            max-width: 200px;
            height: 10px;
            overflow: hidden;
            display: inline-block;
            vertical-align: middle;
            margin-right: 10px;
        }
        .progress-bar-fill {
            background-color: var(--primary-color);
            height: 100%;
            border-radius: 9999px;
            transition: width 0.5s ease;
        }
        .candidate-cell {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .candidate-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Résultats du vote en Temps Réel</h1>
        
        <div class="stats-box">
            <span>Total des votes exprimés : <strong><?= $total_votes_global ?></strong></span>
        </div>
        
        <table class="result-table">
            <thead>
                <tr>
                    <th>Candidat</th>
                    <th>Progression</th>
                    <th>Nombre de votes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultats as $row): 
                    // Calcul du pourcentage de chaque candidat (évite la division par zéro)
                    $pourcentage = $total_votes_global > 0 ? round(($row['total_votes'] / $total_votes_global) * 100) : 0;
                ?>
                    <tr>
                        <td>
                            <div class="candidate-cell">
                                <img src="<?= htmlspecialchars($row['photo']) ?>" class="candidate-avatar" alt="">
                                <span><?= htmlspecialchars($row['nom']) ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="progress-bar-container">
                                <div class="progress-bar-fill" style="width: <?= $pourcentage ?>%;"></div>
                            </div>
                            <span style="font-size: 0.9rem; color: var(--text-muted);"><?= $pourcentage ?>%</span>
                        </td>
                        <td><strong><?= $row['total_votes'] ?> vote(s)</strong></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="links">
            <a href="index.php" class="btn btn-secondary">← Retourner à la page de vote</a>
        </div>
    </div>
</body>
</html>