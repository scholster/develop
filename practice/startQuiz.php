<?php

require_once '../Model/createDataBaseConnection.php';

require_once '../Model/LoginModel.php';
require_once '../Controller/LoginController.php';

require_once '../Model/QuizModel.php';

$login = new LoginController();
$quizModel = new QuizModel();

if (!$login->loggedIn) {
    $_SESSION['naviageTo'] = $_SERVER[REQUEST_URI];
    include_once '../login.php';
    exit();
}

if (isset($_REQUEST['subject'])) {
    $subject = $_REQUEST['subject'];
    $quizId = $quizModel->getNextQuizId($_SESSION['userId'], $subject);
    if ($quizId) {
        header("Location: /practice/3/" . $quizId);
        exit();
    } else {
        $_SESSION['dailyQuizMessage'] = TRUE;
        header("Location: /practice/");
        exit();
    }
} else {
    header("Location:/practice");
    exit();
}
?>