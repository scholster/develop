<?php

//header('Content-Type: application/json');
require_once '../Model/createDataBaseConnection.php';

echo 'Hi';

if (isset($_SESSION['userId']) && isset($_POST['topicId']) && isset($_SESSION['customPractice']) && $_SESSION['customPractice'] && isset($_SESSION['topicArray']) && count($_SESSION['topicArray']) > 0) {
    $topicId = $_POST['topicId'];
    $userId = $_SESSION['userId'];
    $query = "SELECT q.`questionId`,q.question,q.option1,q.option2,q.option3,q.option4,q.option5
                  ,d.text FROM content_question q LEFT JOIN content_questiondata d ON q.`dependsOn`=d.id WHERE `topicId` = '$topicId' AND
                `questionId` NOT IN (SELECT `quesId` FROM user_contentanswer WHERE `userId` = '$userId') ORDER BY rand() LIMIT 0,1";

    $result = mysql_query($query);
    if (mysql_num_rows($result) == 0) {
        $result = mysql_query("SELECT q.`questionId`,q.question,q.option1,q.option2,q.option3,q.option4,q.option5
                  ,d.text FROM content_question q LEFT JOIN content_questiondata d ON q.`dependsOn`=d.id WHERE `topicId` = '$topicId' ORDER BY rand() LIMIT 0,1");
        echo mysql_error();
    }

    $row = mysql_fetch_assoc($result);

    echo json_encode($row);
}
?>
