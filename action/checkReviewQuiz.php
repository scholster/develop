<?php

require_once '../Model/createDataBaseConnection.php';
require_once '../Model/LoginModel.php';
require_once '../Controller/LoginController.php';

$login = new LoginController();

if (!$login->loggedIn) {
    $_SESSION['naviageTo'] = $_SERVER[REQUEST_URI];
    include_once '../login.php';
    exit();
}

$userId = $_SESSION['userId'];
if (isset($_POST['quizId'])) {
    $quizId = $_POST['quizId'];
    if (isset($_SESSION['quiz' . $quizId])) {
        $time = time() - ($_SESSION['quiz' . $quizId]);
        unset($_SESSION['quiz' . $quizId]);
        $data = NULL;
        $query = "SELECT q.`questionId`,q.correctoption FROM content_question q where q.`relationId` = '$quizId'";
        $result = mysql_query($query);
        while ($row = mysql_fetch_assoc($result)) {
            $data[$row['questionId']]['correctoption'] = $row['correctoption'];
        }
        $attempted = 0;
        $correct = 0;
        $total = mysql_num_rows($result);

        mysql_query("SET AUTOCOMMIT=0");
        mysql_query("START TRANSACTION");

        $sql = "";

        for ($i = 1; $i <= $total; $i++) {
            if (isset($_POST['questionId' . $i]) && is_numeric($_POST['questionId' . $i])) {
                $questionId = $_POST['questionId' . $i];
                if (isset($_POST['quizQuesRadio' . $i]) && is_numeric($_POST['quizQuesRadio' . $i])) {
                    $attempted++;
                    $isCorrect = 0;
                    $answer = $_POST['quizQuesRadio' . $i];
                    $timeTaken = $_POST['questionTime' . $i];
                    if ($answer == $data[$questionId]['correctoption']) {
                        $correct++;
                        $isCorrect = 1;
                    }
                    if ($sql == "") {
                        $sql = "INSERT INTO user_contentanswer (`userId`,`quesId`,answer,`isCorrect`,`timeTaken`, `relationId`, `quizType`) 
                        VALUES ('$userId','$questionId','$answer','$isCorrect','$timeTaken', '$quizId', '2')";
                    } else {
                        $sql = $sql . ",('$userId','$questionId','$answer','$isCorrect','$timeTaken', '$quizId', '2')";
                    }
                }
            } else {
                break;
            }
        }

        $result2 = mysql_query($sql);
        
        if($sql==""){
            $result2 = TRUE;
        }

        $sql2 = "INSERT INTO user_reviewquizresult (quizid,userid,total,attempted,correct,`timeTaken`)
                VALUES ('$quizId','$userId','$total','$attempted','$correct','$time')";
        $result3 = mysql_query($sql2);

        if ($result2 && $result3) {
            mysql_query("COMMIT");
        } else {
            mysql_query("ROLLBACK");
        }
    }
} else {
    echo 'INVALID';
    exit();
}
header("Location:/practice/2/" . $quizId);
exit();
?>