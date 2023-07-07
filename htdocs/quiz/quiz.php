<head>
<link rel="stylesheet" type="text/css" href="../styles.css">
</head>

<?php
require_once '../process/config.php';
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
do {
    $idQuestion = rand(1, $totalQuestion);
} while (in_array($idQuestion, $answeredQuestionIds));

// Insérer la paire utilisateur-question dans la table answered_questions
$insertStatement = $pdo->prepare('INSERT INTO answered_questions (user_id, question_id) VALUES (?, ?)');
$insertStatement->execute([$user['id'], $idQuestion]);

// Récupérer les détails de la question à afficher
$questionStatement = $pdo->prepare('SELECT * FROM questions WHERE id = ?');
$questionStatement->execute([$idQuestion]);
$questionData = $questionStatement->fetch();

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
?>

<section id="questionreponse">
    <div>
        <div>
            <h3><?= $questionData['title'] ?></h3>
        </div>
    </div>
</section>

<section id="reponses">
    <div>
        <div>
            <button id="rep1" value="<?= $options[0] ?>"><?= $options[0] ?></button>
            <button id="rep2" value="<?= $options[1] ?>"><?= $options[1] ?></button>
            <button id="rep3" value="<?= $options[2] ?>"><?= $options[2] ?></button>
            <button id="rep4" value="<?= $options[3] ?>"><?= $options[3] ?></button>
        </div>
    </div>

    <input type="hidden" value="<?= $questionData['goodAnswer'] ?>" id="goodAnswer">
    <input type="hidden" value="<?= $questionData['id'] ?>" id="questionId">

    <div>
        <div>
            <div id="timer">20</div>
        </div>
    </div>

    <div>
        <div>
            <div id="progress"><?= count($answeredQuestionIds) + 1 ?>/20</div>
        </div>
    </div>
</section>



<script src="../script.js"></script>
<script>
    // Timer
    var timerElement = document.getElementById("timer");
    var timeLeft = 20;
    var timerId = setInterval(countdown, 1000);

    function countdown() {
        if (timeLeft === 0) {
            clearInterval(timerId);
            // Code à exécuter lorsque le temps est écoulé
            console.log("Temps écoulé !");
        } else {
            timerElement.textContent = timeLeft;
            timeLeft--;
        }
    }
</script>

<script src ="../script.js" ></script>