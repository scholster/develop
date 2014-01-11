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

if (!isset($_POST['practiceType']) || !($_POST['practiceType'] == 2)) {
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
} else {
    if (isset($_POST['subject'])) {
        $topic = $_POST['verbalTopics'];
        $subject = 3;
    } else {
        $topic = $_POST['quantTopics'];
        $subject = 1;
    }

    $noOfQuestion = $_POST['questions'];
    if (isset($_POST['mode'])) {
        $mode = 1;
    } else {
        $mode = 0;
    }

    $questions = $_POST['questions'];
    $time = $_POST['time'];

    if ($mode == 1) {
        $quizId = $quizModel->generateCustomQuiz($_SESSION['userId'], $topic, $noOfQuestion, $mode, $subject, $questions, $time);
        header("Location:/practice/custom/" . $quizId);
        exit();
    } else {
        $quizId = $quizModel->generateCustomQuiz($_SESSION['userId'], $topic, $noOfQuestion, $mode, $subject, $questions, $time);
        header("Location:/practice/custom/" . $quizId);
        exit();

//        $_SESSION['topicArray'] = $topic;
//        $_SESSION['customPractice'] = TRUE;
//        header("Location:/practice/4/".$questions."/".$time*60);
//        exit();
    }
}
?>