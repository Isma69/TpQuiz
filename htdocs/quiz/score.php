<?php
require_once '../process/config.php';
include '../header.php';

// Récupérer les 10 meilleurs scores avec les pseudos correspondants
$scoresStatement = $pdo->prepare('SELECT s.score, u.pseudo FROM score AS s JOIN users AS u ON s.user_id = u.id ORDER BY s.score DESC LIMIT 10');
$scoresStatement->execute();
$scores = $scoresStatement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Classement des scores</title>
  <style>
    
    body {
    background-image: url(https://wallpapercave.com/uwp/uwp593816.jpeg);
    background-size: 100vw 100vh;
    background-repeat: no-repeat;
    margin: 0;
    overflow: hidden;
    }

    table {
      width: 50%;
      margin: auto;
      margin-top: 500px; /* Ajustez cette valeur selon vos besoins */
      border-collapse: collapse;
    }
    
    th, td {
      color: white;
      font-size: 22px; /* Ajustez cette valeur selon vos besoins */
      padding: 10px;
      text-align: center;
      border: 1px solid #ccc;
    }

    h1 {
  color: white;
  font-weight: bold;
  text-align: center;
  margin-top: 20px;
  margin-bottom: 20px;
  font-size: 30px;
  text-decoration: underline;
  text-decoration-color: rgb(255, 200, 97);
  position: absolute; /* Position absolue */
  top: 40%; /* Déplacer le haut à 50% de la page */
  left: 50%; /* Déplacer la gauche à 50% de la page */
  transform: translate(-50%, -50%); /* Centrer horizontalement et verticalement */
}



  </style>
</head>

  <h1>Classement des scores</h1>
  <body>
  <table>
    <thead>
      <tr>
        <th>Position</th>
        <th>Pseudo</th>
        <th>Score</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $position = 1;
      foreach ($scores as $score) {
        echo '<tr>';
        echo '<td>' . $position . '</td>';
        echo '<td>' . $score['pseudo'] . '</td>';
        echo '<td>' . $score['score'] . '</td>';
        echo '</tr>';

        $position++;
      }
      ?>
    </tbody>
  </table>
</body>
</html>