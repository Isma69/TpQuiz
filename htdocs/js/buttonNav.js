// Timer
var timerElement = document.getElementById("timer");
var timeLeft = 10;
var timerId = setInterval(countdown, 1000);

function countdown() {
    if (timeLeft === 0) {
        clearInterval(timerId);
        // Code à exécuter lorsque le temps est écoulé
        console.log("Temps écoulé !");
        displayNextQuestion();
    } else {
        timerElement.textContent = timeLeft;
        timeLeft--;
    }
}

// Réponse sélectionnée
var selectedAnswer = null;

// Boutons de réponse
var answerButtons = document.querySelectorAll('button[id^="rep"]');
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
    }
    
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
}