<?php
require_once '../process/config.php';

// Récupérer l'utilisateur à partir de l'ID
$userStatement = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$userStatement->execute([$_GET['id']]);
$user = $userStatement->fetch(PDO::FETCH_ASSOC);

// Récupérer le score de l'utilisateur
$scoreStatement = $pdo->prepare('SELECT score FROM score WHERE user_id = ?');
$scoreStatement->execute([$user['id']]);
$score = $scoreStatement->fetchColumn();

// Afficher le score final
echo "Score final de l'utilisateur " . $user['pseudo'] . ": " . $score;
