<?php

$user = 'root';
$pass = '';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=TpQuiz', $user, $pass);
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}