<?php
define('DB_DSN', 'mysql:host=127.0.0.1;dbname=TpQuiz;charset=utf8');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

$pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>