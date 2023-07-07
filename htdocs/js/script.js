// Sélectionner tous les boutons de réponse
var buttons = document.querySelectorAll('button[id^="rep"]');

// Fonction pour désactiver les boutons de réponse
function disableButtons() {
    buttons.forEach(function (button) {
        button.disabled = true;
    });
}

// Fonction pour activer les boutons de réponse
function enableButtons() {
    buttons.forEach(function (button) {
        button.disabled = false;
    });
}

// Fonction pour passer à la question suivante
function goToNextQuestion() {
    disableButtons();

    // Mettre à jour la base de données avec l'ID de la question répondue
    var questionId = document.getElementById('questionId').value;
    updateAnsweredQuestions(questionId)
        .then(function() {
            // Passer à la question suivante après un délai
            setTimeout(function() {
                window.location.reload();
            }, 1000);
        })
        .catch(function(error) {
            console.log('Failed to update answered questions:', error);
            // Passer à la question suivante même en cas d'erreur
            setTimeout(function() {
                window.location.reload();
            },1000);
        });
}

// Fonction pour mettre à jour la base de données avec l'ID de la question répondue
function updateAnsweredQuestions(questionId) {
    return fetch('../process/update_answered_questions.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `userId=<?= $user['id'] ?>&questionId=${questionId}`
    })
    .then(response => {
        if (response.ok) {
            console.log('Answered questions updated successfully.');
        } else {
            console.log('Failed to update answered questions.');
        }
    })
    .catch(error => {
        console.log('Failed to update answered questions:', error);
    });
}

// Fonction pour gérer le clic sur un bouton de réponse
function handleAnswerButtonClick(event) {
    // Récupérer la valeur de la bonne réponse
    var goodAnswer = document.getElementById('goodAnswer').value;

    // Réinitialiser les couleurs des boutons
    buttons.forEach(function (btn) {
        btn.style.backgroundColor = '';
    });

    // Vérifier si la réponse choisie est correcte
    if (event.target.value === goodAnswer) {
        event.target.style.backgroundColor = 'green'; // Colorer en vert si la réponse est correcte
    } else {
        event.target.style.backgroundColor = 'red'; // Colorer en rouge si la réponse est incorrecte
    }

    // Mettre à jour la base de données avec l'ID de la question répondue
    var questionId = document.getElementById('questionId').value;
    updateAnsweredQuestions(questionId);

    // Désactiver les boutons après avoir cliqué sur l'une des réponses
    disableButtons();

    // Passer à la question suivante après un délai
    setTimeout(goToNextQuestion, 1000);
}

// Ajouter un écouteur d'événement à chaque bouton
buttons.forEach(function (button) {
    button.addEventListener('click', handleAnswerButtonClick);
});