<?php
require_once '../process/config.php';
include '../header.php';

// Récupérer l'utilisateur à partir de l'ID
$userStatement = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$userStatement->execute([$_GET['id']]);
$user = $userStatement->fetch(PDO::FETCH_ASSOC);

// Récupérer le score de l'utilisateur
$scoreStatement = $pdo->prepare('SELECT score FROM score WHERE user_id = ?');
$scoreStatement->execute([$user['id']]);
$score = $scoreStatement->fetchColumn();

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Score final</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            margin-top: 200px;
            padding: 20px;
            background-color: #f2f2f2;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
        }
        
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        
        p {
            margin-bottom: 10px;
        }
        a {
            color : red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Score final</h1>
        <p>Score final de l'utilisateur <?php echo $user['pseudo']; ?> : <?php echo $score; ?></p>
    </div>
    <a href="index.php">Retour à l'accueil</a>
</body>
</html>


