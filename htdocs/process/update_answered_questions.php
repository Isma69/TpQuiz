<?php
require_once 'config.php';

// Récupérer les valeurs du formulaire
$userId = $_POST['userId'];
$questionId = $_POST['questionId']; // tableau des IDs des questions répondues
if (isset($_POST['questionId']) && isset($_POST['userId'])) {
    // Insérer les relations dans la table answered_questions
    $insertStatement = $pdo->prepare('INSERT INTO answered_questions (user_id, question_id) VALUES (?, ?)');
    $insertStatement->execute([$userId, $questionId]);
}

?>