<?php
require_once '../Model/createDataBaseConnection.php';

require_once '../Model/LoginModel.php';
require_once '../Controller/LoginController.php';

require_once '../Model/UserDetailsModel.php';
require_once '../Controller/UserDetailsController.php';

require_once '../Model/QuizModel.php';
require_once '../Controller/QuizController.php';

require_once '../Controller/AnalyticsController.php';
require_once '../Model/AnalyticsModel.php';

require_once '../Util/functions.php';

$userObject = new UserDetailsController($_SESSION['userId']);
$userInfo = $userObject->info;

$login = new LoginController();

if (!$login->loggedIn) {
    $_SESSION['naviageTo'] = $_SERVER[REQUEST_URI];
    include_once '../login.php';
    exit();
}

$includeString = "";

if (isset($_GET['quizType']) && $_GET['quizType']==4) {
    include_once 'customPractice.php';
    exit();
}


if (isset($_GET['quizType']) && (($_GET['quizType'] > 0 && $_GET['quizType'] < 5) || $_GET['quizType'] == 'custom') && isset($_GET['quizId']) && is_numeric($_GET['quizId'])) {
    $quizType = $_GET['quizType'];
    if ($quizType == 1) {
        $includeString = 'subTopicQuizNew.php';
    } elseif ($quizType == 2) {
        $includeString = 'reviewQuizNew.php';
    } elseif ($quizType == 3) {
        $controller = new QuizController($_GET['quizId']);
        $includeString = 'dailyQuizNew.php';

        if (!$controller->getDailyQuizInfo()) {
            include_once '../notfound.html';
            exit();
        }

        $nextQuizId = $controller->getNextQuizId();
        if ($nextQuizId != NULL && $nextQuizId < $controller->quizId) {
            header("Location:/practice/3/" . $nextQuizId);
            exit();
        }
    } elseif ($quizType == 'custom') {
        $quizModel = new QuizModel ();
        $quizId = $_GET['quizId'];
        $quizInfo = $quizModel->getCustomQuizInfo($_SESSION['userId'], $quizId);
        if ($quizInfo[0] == 1) {
            $includeString = 'customQuiz.php';
        } elseif ($quizInfo[0] == 0) {
            $includeString = 'customPractice.php';
        } else {
            include_once '../notfound.html';
            exit();
        }
    } else {
        include_once '../notfound.html';
        exit();
    }
} else {
    $includeString = 'home.php';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include_once '../include/headInclude.php'; ?>
        <title>queskey | Quiz</title>
        <script type="text/javascript"
                src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
        </script>
    </head>
    <?php include $includeString; ?>
</html>