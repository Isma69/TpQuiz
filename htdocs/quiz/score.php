<?php
require_once '../process/config.php';

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
    table {
      width: 50%;
      margin: auto;
      border-collapse: collapse;
    }
    
    th, td {
      padding: 10px;
      text-align: center;
      border: 1px solid #ccc;
    }
  </style>
</head>
<body>
  <h1>Classement des scores</h1>

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