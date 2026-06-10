<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_etudiant = trim($_POST['id_etudiant']);
    $id_candidat = $_POST['id_candidat'];

    if (!empty($id_etudiant) && !empty($id_candidat)) {
        
        // 3) Vérifier si l'identifiant existe déjà dans la table des votes
        $checkStmt = $pdo->prepare("SELECT id FROM votes WHERE id_etudiant = ?");
        $checkStmt->execute([$id_etudiant]);
        
        if ($checkStmt->rowCount() > 0) {
            // L'étudiant a déjà voté -> Redirection avec erreur
            header("Location: index.php?msg=deja_vote");
            exit;
        } else {
            // L'étudiant n'a pas voté -> Enregistrement
            $insertStmt = $pdo->prepare("INSERT INTO votes (id_etudiant, id_candidat) VALUES (?, ?)");
            $insertStmt->execute([$id_etudiant, $id_candidat]);
            
            header("Location: index.php?msg=success");
            exit;
        }
    } else {
        header("Location: index.php?msg=invalide");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>