// Fonction pour passer à la question suivante
function goToNextQuestion() {
    disableButtons();

    // Mettre à jour la base de données avec l'ID de la question répondue
    let questionId = document.getElementById('questionId').value;
    updateAnsweredQuestions(questionId)
        .then(function() {
            // Passer à la question suivante après un délai
            setTimeout(function() {
                 window.location.reload();
            }, 1500);
        })
        .catch(function(error) {
            console.log('Failed to update answered questions:', error);
            // Passer à la question suivante même en cas d'erreur
            setTimeout(function() {
                 window.location.reload();
            },1000);
        });
}

// Timer
let timerElement = document.getElementById("timer");
let timeLeft = 15;
let timerId = setInterval(countdown, 1000);

function countdown() {
  if (timeLeft === 0) {
    clearInterval(timerId);
    // Passer à la question suivante après un délai
    setTimeout(goToNextQuestion, 1000);
  } else {
    timerElement.textContent = timeLeft;
    timeLeft--;
  }
}