<link rel="stylesheet" href="../styles.css">

<?php
require_once '../process/config.php';
require_once '../process/functions.php';
include '../header.php';

// Récupérer l'utilisateur à partir de l'ID
$userStatement = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$userStatement->execute([$_GET['id']]);
$user = $userStatement->fetch(PDO::FETCH_ASSOC);

// Récupérer les ID des questions déjà répondues par l'utilisateur
$answeredQuestionIdsStatement = $pdo->prepare('SELECT question_id FROM answered_questions WHERE user_id = ?');
$answeredQuestionIdsStatement->execute([$user['id']]);
$answeredQuestionIds = $answeredQuestionIdsStatement->fetchAll(PDO::FETCH_COLUMN);

// Récupérer le nombre total de questions dans la base de données
$countQuestionStatement = $pdo->query('SELECT COUNT(*) AS totalQuestion FROM questions');
$totalQuestion = $countQuestionStatement->fetch()['totalQuestion'];

// Générer un ID de question aléatoire qui n'a pas été répondu par l'utilisateur
$unansweredQuestionIds = array_diff(range(1, $totalQuestion), $answeredQuestionIds);
$idQuestion = array_rand($unansweredQuestionIds);

// Vérifier si la question correspondante existe dans la table 'questions'
$questionExistsStatement = $pdo->prepare('SELECT COUNT(*) FROM questions WHERE id = ?');
$questionExistsStatement->execute([$idQuestion]);
$questionExists = $questionExistsStatement->fetchColumn();

if ($questionExists) {
  // La question existe, procéder à l'insertion dans la table 'answered_questions'
  // Vérifier si la paire utilisateur-question existe déjà
  $existingAnswerStatement = $pdo->prepare('SELECT COUNT(*) FROM answered_questions WHERE user_id = ? AND question_id = ?');
  if (!empty($user['id'])) {
    $existingAnswerStatement->execute([$user['id'], $idQuestion]);
  }

  $existingAnswerCount = $existingAnswerStatement->fetchColumn();

  if ($existingAnswerCount == 0) {
    // Insérer la paire utilisateur-question dans la table answered_questions
    $insertStatement = $pdo->prepare('INSERT INTO answered_questions (user_id, question_id) VALUES (?, ?)');
    if (!empty($user['id'])) {
      $insertStatement->execute([$user['id'], $idQuestion]);
    }
  }

  // Récupérer les détails de la question à afficher
  $questionStatement = $pdo->prepare('SELECT * FROM questions WHERE id = ?');
  $questionStatement->execute([$idQuestion]);
  $questionData = $questionStatement->fetch();
} else {
  // La question n'existe pas, gérer cette situation en conséquence
}

if (isset($questionData)) { // Vérifier si $questionData est définie avant de l'utiliser
  // Créer un tableau avec les options de réponse
  $options = [$questionData['option1'], $questionData['option2'], $questionData['option3'], $questionData['option4']];

  // Supprimer la bonne réponse des options
  $goodAnswerIndex = array_search($questionData['goodAnswer'], $options);
  unset($options[$goodAnswerIndex]);

  // Mélanger le tableau pour rendre la position des options aléatoire
  shuffle($options);

  // Insérer la bonne réponse à une position aléatoire dans le tableau
  $randomIndex = rand(0, count($options));
  array_splice($options, $randomIndex, 0, $questionData['goodAnswer']);
}
?>

<section class="container" id="questionreponse">
  <div class="question col-lg-12 col-md-12 col-sm-12 mt-5">
    <h3><?= $questionData['title'] ?></h3>
  </div>


      <div class="container" id="reponses">
        <div class="">
          <button id="rep1" value="<?= $options[0] ?>" class="col1 btn btn" onclick="handleAnswerSelection(this.value)"><?= $options[0] ?></button>
          <button id="rep2" value="<?= $options[1] ?>" class="col2 btn btn" onclick="handleAnswerSelection(this.value)"><?= $options[1] ?></button>
        </div>
        <div class="">
          <button id="rep3" value="<?= $options[2] ?>" class="col3 btn btn" onclick="handleAnswerSelection(this.value)"><?= $options[2] ?></button>
          <button id="rep4" value="<?= $options[3] ?>" class="col4 btn btn" onclick="handleAnswerSelection(this.value)"><?= $options[3] ?></button>
        </div>
      </div>


  <input type="hidden" value="<?= $questionData['goodAnswer'] ?>" id="goodAnswer">
  <input type="hidden" value="<?= $questionData['id'] ?>" id="questionId">
  <div class="timerCount">

<div id="timer">15</div>

<div id="progress"><?= count($answeredQuestionIds) + 1 ?>/10</div>

</div>

</section>
<script>
    let userId = JSON.stringify(<?= $user['id'];?>);
  // Fonction pour gérer la sélection de réponse par l'utilisateur
  function handleAnswerSelection(selectedAnswer) {
    // Récupérer la bonne réponse et l'ID de la question
    let goodAnswer = document.getElementById('goodAnswer').value;
    let questionId = document.getElementById('questionId').value;
    // Vérifier si la réponse sélectionnée est correcte
    if (selectedAnswer === goodAnswer) {
      // Envoyer la requête AJAX pour mettre à jour le score
      fetch('../process/update_score.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `user_id=${userId}&question_id=` + questionId + '&score=10'
        })
        .then(function(response) {
          if (response.ok) {
            // Mettre à jour le numéro de question et recharger la page pour passer à la question suivante
            let progress = document.getElementById('progress');
            let currentQuestion = parseInt(progress.innerText.split('/')[0]);
            let totalQuestions = parseInt(progress.innerText.split('/')[1]);
            let maxQuestions = 10;
            if (currentQuestion < totalQuestions || currentQuestion > maxQuestions) {
              window.location.reload();
            } else {
              // Rediriger vers la page du score final
              window.location.href = `final_score.php?id=${userId}`;
            }
          } else {
            console.error('Erreur lors de la mise à jour du score:', response.status);
          }
        })
        .catch(function(error) {
          console.error('Erreur lors de la mise à jour du score:', error);
        });
    } else {
      // La réponse sélectionnée est incorrecte, recharger la page pour passer à la question suivante
       window.location.reload();
    }
  }
</script>
<script src="../js/questions.js"></script>
<script src="../js/buttonNav.js"></script>
<script src="../js/timer.js"></script>
<?php
include '../footer.php';
?>
