<?php
require_once 'config.php';

function countCorrectAnswers($pdo, $answeredQuestionIds) {
    // Compteur pour les réponses correctes
    $correctCount = 0;

// Vérifier si la clé 'selectedAnswer' existe dans le tableau $_POST
if (isset($_POST['selectedAnswer'])) {
    // Parcourir les IDs des questions déjà répondues
    foreach ($answeredQuestionIds as $questionId) {
        // Récupérer les détails de la question
        $questionStatement = $pdo->prepare('SELECT * FROM questions WHERE id = ?');
        $questionStatement->execute([$questionId]);
        $questionData = $questionStatement->fetch();

        // Vérifier si la réponse sélectionnée est correcte
        if ($_POST['selectedAnswer'] === $questionData['goodAnswer']) {
            $correctCount++;
        }
    }
} else {
    // Gérer le cas où la clé 'selectedAnswer' n'est pas définie dans $_POST
    // Vous pouvez afficher un message d'erreur ou prendre une autre action appropriée
}

    return $correctCount;
}

