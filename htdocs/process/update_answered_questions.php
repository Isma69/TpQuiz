<?php
require_once 'config.php';

// Récupérer les valeurs du formulaire
$userId = $_POST['userId'];
$questionIds = $_POST['questionIds']; // tableau des IDs des questions répondues

// Supprimer les espaces vides et convertir en tableau
$questionIds = array_filter(array_map('trim', explode(',', $questionIds)));

// Insérer les relations dans la table answered_questions
$insertStatement = $pdo->prepare('INSERT INTO answered_questions (user_id, question_id) VALUES (?, ?)');
foreach ($questionIds as $questionId) {
    $insertStatement->execute([$userId, $questionId]);
}

?>

