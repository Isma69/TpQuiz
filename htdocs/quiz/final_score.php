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
    <link rel="stylesheet" href="../styles.css">
</head>

    <div class="score-container">
</br>
        <p><?php echo $user['pseudo']; ?> : <?php echo $score; ?>/100 points !</p>
    </div>
</body>
</html>



