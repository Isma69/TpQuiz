<?php
require_once 'config.php';

    $userId = $_POST['user_id'];
    $questionId = $_POST['question_id'];
    $score = $_POST['score'];

    // Vérifier si l'utilisateur a déjà un enregistrement dans la table scores
    $scoreStatement = $pdo->prepare('SELECT * FROM score WHERE user_id = ?');
    $scoreStatement->execute([$userId]);
    $existingScore = $scoreStatement->fetch();

    if ($existingScore) {
        // Mettre à jour le score existant
        $updateStatement = $pdo->prepare('UPDATE score SET score = score + ? WHERE user_id = ?');
        $updateStatement->execute([$score, $userId]);
    } else {
        // Créer un nouvel enregistrement de score
        $insertStatement = $pdo->prepare('INSERT INTO score (user_id, score) VALUES (?, ?)');
        $insertStatement->execute([$userId, $score]);
    }

    // Mettre à jour le statut de la question dans la table answered_questions
    $updateStatusStatement = $pdo->prepare('UPDATE answered_questions SET status = 1 WHERE user_id = ? AND question_id = ?');
    $updateStatusStatement->execute([$userId, $questionId]);
