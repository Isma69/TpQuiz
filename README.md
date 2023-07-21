# TpQuiz


// Vérifier si toutes les questions ont été répondues
if (count($answeredQuestionIds) === 10) {
    // Calculer le score de l'utilisateur
    $correctCount = countCorrectAnswers($pdo, $answeredQuestionIds);
    $score = $correctCount * 10;

    // Insérer le score dans la table des scores
    $insertScoreStatement = $pdo->prepare('INSERT INTO score (user_id, score) VALUES (?, ?)');
    $insertScoreStatement->execute([$user['id'], $score]);

    // Rediriger vers la page du score final
    header('Location: final_score.php?id=' . $user['id']);
    exit();
}

<script>
// Fonction pour gérer la sélection de réponse par l'utilisateur
function handleAnswerSelection(selectedAnswer) {
  // Récupérer la bonne réponse et l'ID de la question
  var goodAnswer = document.getElementById('goodAnswer').value;
  var questionId = document.getElementById('questionId').value;

  // Vérifier si la réponse sélectionnée est correcte
  if (selectedAnswer === goodAnswer) {
    // Envoyer la requête AJAX pour mettre à jour le score
    fetch('../process/update_score.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: 'user_id=<?= $user['id'] ?>&question_id=' + questionId + '&score=10'
    })
    .then(function(response) {
      if (response.ok) {
        // Mettre à jour le numéro de question et recharger la page pour passer à la question suivante
        var progress = document.getElementById('progress');
        var currentQuestion = parseInt(progress.innerText.split('/')[0]);
        var totalQuestions = parseInt(progress.innerText.split('/')[1]);

        if (currentQuestion < totalQuestions) {
          window.location.reload();
        } else {
          // Rediriger vers la page du score final
          window.location.href = 'final_score.php?id=<?= $user['id'] ?>';
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

// Afficher la prochaine question
function displayNextQuestion() {
    clearInterval(timerId);
    var form = document.createElement("form");
    form.method = "post";
    form.action = "quiz.php?id=<?= $user['id'] ?>";
    var input = document.createElement("input");
    input.type = "hidden";
    input.name = "selectedAnswer";
    
    // Récupérer la réponse sélectionnée à partir du bouton
    var selectedButton = document.querySelector("#reponses button.selected");
    if (selectedButton) {
        input.value = selectedButton.value;
    } else {
        input.value = "0"; // Si aucune réponse n'est sélectionnée, la valeur est mise à 0
    }
    
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
}