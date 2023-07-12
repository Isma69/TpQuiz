// Timer
let timerElement = document.getElementById("timer");
let timeLeft = 20;
let timerId = setInterval(countdown, 1000);

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