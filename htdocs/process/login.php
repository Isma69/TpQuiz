<?php

require_once "config.php";

    $username = $_POST['pseudo'];

    // Requête SELECT pour vérifier si l'utilisateur existe
    $selectStmt = $pdo->prepare("SELECT * FROM users WHERE pseudo = :pseudo");
    $selectStmt->bindValue(':pseudo', $username);
    $selectStmt->execute();

    $user = $selectStmt->fetch();

    if ($user) {
        // Utilisateur existant, rediriger vers la page du menu
        header('Location: /quiz/quiz.php?id=' . $user['id']);
        exit();
    } else {
       // Insérer un nouvel utilisateur
    $insertStmt = $pdo->prepare("INSERT INTO users (pseudo) VALUES (:pseudo)");
    $insertStmt->bindValue(':pseudo', $username);
    $insertStmt->execute();

        // Rediriger vers la page d'accueil avec un message de succès
        header('Location: /index.php?message=Votre compte a bien été créé. Veuillez vous connecter.');
        exit();
    }