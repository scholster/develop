<?php

header('Content-Type: application/json');
require_once '../Model/createDataBaseConnection.php';

require_once '../Util/functions.php';
$isCorrect = 0;
if (isset($_SESSION['email']) && isset($_POST['quesId']) && isset($_POST['answer']) && isset($_POST['time'])) {

    $quesId = $_POST['quesId'];
    $query = "SELECT correctoption,solution,`relationId` FROM content_question WHERE `questionId` = '$quesId' AND `type`='1'";
    $result = mysql_query($query);
    $row = mysql_fetch_assoc($result);
    if ($row['correctoption'] == $_POST['answer']) {
        $isCorrect = 1;
    }

    mysql_query("SET AUTOCOMMIT=0");
    mysql_query("START TRANSACTION");

    $answer = $_POST['answer'];
    $userId = $_SESSION['userId'];
    $time = $_POST['time'];
    $relationId = $row['relationId'];
    $query2 = "INSERT INTO user_contentanswer (`userId`,`quesId`,answer,`isCorrect`,`timeTaken`,`quizType`,`relationId`)
                VALUES ('$userId','$quesId','$answer','$isCorrect','$time','1','$relationId')";
    $result2 = mysql_query($query2);

    $affectedRows = mysql_affected_rows();
    
    $query3 = "SELECT AVG(`timeTaken`) FROM user_contentanswer WHERE `quesId`='$quesId'";
    $avgResult = mysql_fetch_array(mysql_query($query3));
    $avg = $avgResult[0];
    

    $data = array(
        'data' => 'valid',
        'iscorrect' => quizIsCorrectToString($isCorrect),
        'answer' => quizNumbertoLetters($answer),
        'correctAnswer' => quizNumbertoLetters($row['correctoption']),
        'solution' => $row['solution'],
        'average' => secondsToString($avg),
        'time' =>  secondsToString($time)
    );
    
    
    if ($result2 && $affectedRows == 1) {
        mysql_query("COMMIT");
        echo json_encode($data);
        exit();
    } else {
        mysql_query("ROLLBACK");
        echo json_encode(array('data' => 'invalid'));
        exit();
    }
}
echo json_encode(array('data' => 'invalid'));
exit();
?>