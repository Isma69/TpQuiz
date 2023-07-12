// Boutons de réponse
let answerButtons = document.querySelectorAll('button[id^="rep"]');
answerButtons.forEach(function(button) {
    button.addEventListener("click", function() {
        selectedAnswer = this.value;
        answerButtons.forEach(function(btn) {
            if (btn === button) {
                btn.classList.add("selected");
            } else {
                btn.classList.add("disabled");
            }
        });
         setTimeout(displayNextQuestion, 1000);
    });
});

// Afficher la prochaine question
function displayNextQuestion() {
    clearInterval(timerId);
    let form = document.createElement("form");
    form.method = "post";
    form.action = "quiz.php?id=<?= $user['id'] ?>";
    let input = document.createElement("input");
    input.type = "hidden";
    input.name = "selectedAnswer";
    
    // Récupérer la réponse sélectionnée à partir du bouton
    let selectedButton = document.querySelector("#reponses button.selected");
    if (selectedButton) {
        input.value = selectedButton.value;
    } else {
        input.value = "0"; // Si aucune réponse n'est sélectionnée, la valeur est mise à 0
    }
    
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
}
