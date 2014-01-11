<?php

class QuizModel {

    public function getQuestions($quizId, $userId, $type) {
        $questions = NULL;
        $query = "SELECT q.`questionId`,q.question,q.option1,q.option2,q.option3,q.option4,q.option5,q.correctoption,q.solution,q.`level`
                  ,d.text,ua.answer, ua.`timeTaken`, ua.comment 
                    FROM content_question q LEFT JOIN content_questiondata d ON q.`dependsOn`=d.id
                    LEFT JOIN user_contentanswer ua 
                    ON q.`questionId`=ua.`quesId` AND ua.`userId` = '$userId' AND ua.`quizType` = '$type' AND ua.`relationId` = '$quizId'
                    where q.`relationId` = '$quizId' AND q.`type` = '$type' ORDER BY q.`dependsOn` , q.`questionId`";
        $result = mysql_query($query);
        $i = 0;
        while ($row = mysql_fetch_array($result)) {
            $questions[$i]['id'] = $row[0];
            $questions[$i]['question'] = $row[1];
            $questions[$i]['option1'] = $row[2];
            $questions[$i]['option2'] = $row[3];
            $questions[$i]['option3'] = $row[4];
            $questions[$i]['option4'] = $row[5];
            $questions[$i]['option5'] = $row[6];
            $questions[$i]['correctOption'] = $row[7];
            $questions[$i]['solution'] = $row[8];
            $questions[$i]['level'] = $row[9];
            $questions[$i]['text'] = $row[10];
            $questions[$i]['answer'] = $row[11];
            $questions[$i]['timeTaken'] = $row[12];
            $i++;
        }
        return $questions;
    }

    public function getDailyQuizQuestions($quizId, $userId) {
        $questions = NULL;
        $query = "SELECT q.`questionId`,q.question,q.option1,q.option2,q.option3,q.option4,q.option5,q.correctoption,q.solution,q.`level`
                  ,d.text,ua.answer, ua.`timeTaken`, ua.comment, t.topic, t.subject FROM content_question q LEFT JOIN content_questiondata d ON q.`dependsOn`=d.id
                  LEFT JOIN user_contentanswer ua ON q.`questionId`=ua.`quesId` AND ua.`userId` = '$userId' AND ua.`quizType` = '3' AND ua.`relationId` = '$quizId' ,
                  content_dailyQuizQuestion dq, content_topic t where dq.`questionId` = q.`questionId` AND dq.`quizId` = '$quizId' AND t.id = q.`topicId`";
        $result = mysql_query($query);
        $i = 0;
        while ($row = mysql_fetch_array($result)) {
            $questions[$i]['id'] = $row[0];
            $questions[$i]['question'] = $row[1];
            $questions[$i]['option1'] = $row[2];
            $questions[$i]['option2'] = $row[3];
            $questions[$i]['option3'] = $row[4];
            $questions[$i]['option4'] = $row[5];
            $questions[$i]['option5'] = $row[6];
            $questions[$i]['correctOption'] = $row[7];
            $questions[$i]['solution'] = $row[8];
            $questions[$i]['level'] = $row[9];
            $questions[$i]['text'] = $row[10];
            $questions[$i]['answer'] = $row[11];
            $questions[$i]['timeTaken'] = $row[12];
            $questions[$i]['topic'] = $row[14];
            $questions[$i]['subject'] = $row[15];
            $i++;
        }
        return $questions;
    }

    public function getCustomQuizQuestions($quizId, $userId) {
        $questions = NULL;
        $query = "SELECT q.`questionId`,q.question,q.option1,q.option2,q.option3,q.option4,q.option5,q.correctoption,q.solution,q.`level`
                  ,d.text,ua.answer, ua.`timeTaken`, ua.comment, t.topic, t.subject FROM content_question q LEFT JOIN content_questiondata d ON q.`dependsOn`=d.id
                  LEFT JOIN user_contentanswer ua ON q.`questionId`=ua.`quesId` AND ua.`userId` = '$userId' AND ua.`quizType` = '4' AND ua.`relationId` = '$quizId' ,
                  user_customquizquestion dq, content_topic t where dq.`questionId` = q.`questionId` AND dq.`quizId` = '$quizId' AND t.id = q.`topicId`";
        $result = mysql_query($query);
        $i = 0;
        while ($row = mysql_fetch_array($result)) {
            $questions[$i]['id'] = $row[0];
            $questions[$i]['question'] = $row[1];
            $questions[$i]['option1'] = $row[2];
            $questions[$i]['option2'] = $row[3];
            $questions[$i]['option3'] = $row[4];
            $questions[$i]['option4'] = $row[5];
            $questions[$i]['option5'] = $row[6];
            $questions[$i]['correctOption'] = $row[7];
            $questions[$i]['solution'] = $row[8];
            $questions[$i]['level'] = $row[9];
            $questions[$i]['text'] = $row[10];
            $questions[$i]['answer'] = $row[11];
            $questions[$i]['timeTaken'] = $row[12];
            $questions[$i]['topic'] = $row[14];
            $questions[$i]['subject'] = $row[15];
            $i++;
        }
        return $questions;
    }

    public function getQuestionAvgTime($quizId, $type) {
        $query = "SELECT AVG(ua.`timeTaken`),ua.`quesId` FROM user_contentanswer ua ,content_question q 
                  where ua.`quesId`=q.`questionId` AND q.`relationId`='$quizId' AND q.`type` = '$type' GROUP BY ua.`quesId`";
        $result = mysql_query($query);
        $time = NULL;
        while ($row = mysql_fetch_array($result)) {
            $time[$row[1]] = $row[0];
        }
        return $time;
    }

    public function getDailyQuizQuestionAvgTime($quizId) {
        $query = "SELECT AVG(ua.`timeTaken`),ua.`quesId` FROM user_contentanswer ua ,content_question q,  content_dailyQuizQuestion dq
                  where ua.`quesId`=q.`questionId` AND dq.`questionId` = q.`questionId` AND dq.`quizId` = '$quizId' GROUP BY ua.`quesId`";
        $result = mysql_query($query);
        $time = NULL;
        while ($row = mysql_fetch_array($result)) {
            $time[$row[1]] = $row[0];
        }
        return $time;
    }

    public function getCustomQuizQuestionAvgTime($quizId) {
        $query = "SELECT AVG(ua.`timeTaken`),ua.`quesId` FROM user_contentanswer ua ,content_question q,  user_customquizquestion dq
                  where ua.`quesId`=q.`questionId` AND dq.`questionId` = q.`questionId` AND dq.`quizId` = '$quizId' GROUP BY ua.`quesId`";
        $result = mysql_query($query);
        $time = NULL;
        while ($row = mysql_fetch_array($result)) {
            $time[$row[1]] = $row[0];
        }
        return $time;
    }

    public function getSubTopicQuizInfo($quizId) {
        $sql = "SELECT q.`subTopicId`, st.subtopic, t.topic ,  s.subject
                FROM content_subtopicquiz q,content_subtopic st,content_topic t, content_subjects s
                WHERE q.id = '$quizId' AND q.`subTopicId`=st.id AND st.`topicId`=t.id AND t.subject=s.id";
        $result = mysql_query($sql);
        $row = mysql_fetch_assoc($result);
        if ($row)
            return $row;
        else {
            return NULL;
        }
    }

    public function getReviewQuizInfo($quizId) {
        $sql = "SELECT q.`topicId`, t.topic ,  t.subject
                FROM content_reviewquiz q,content_topic t
                WHERE q.id = '$quizId' AND q.`topicId` = t.id";
        $result = mysql_query($sql);
        $row = mysql_fetch_assoc($result);
        if ($row)
            return $row;
        else {
            return NULL;
        }
    }

    public function getDailyQuizInfo($quizId) {
        $sql = "SELECT q.id,q.subject
                FROM content_dailyquiz q
                WHERE q.id = '$quizId'";
        $result = mysql_query($sql);
        $row = mysql_fetch_assoc($result);
        if ($row)
            return $row;
        else {
            return NULL;
        }
    }

    public function checkReviewQuizUserStatus($quizId, $userId) {
        $num = mysql_num_rows(mysql_query("SELECT total FROM user_reviewquizresult WHERE quizid = '$quizId' AND userid='$userId'"));
        return $num;
    }

    public function checkDailyQuizUserStatus($quizId, $userId) {
        $num = mysql_num_rows(mysql_query("SELECT total FROM user_dailyquizresult WHERE quizid = '$quizId' AND userid='$userId' AND status !=0"));
        return $num;
    }

    public function checkCustomQuizUserStatus($quizId, $userId) {
        $num = mysql_num_rows(mysql_query("SELECT total FROM user_customquiz WHERE id = '$quizId' AND userid='$userId' AND status !=0"));
        return $num;
    }

    public function getReviewQuizResult($quizId, $userId) {
        $result = mysql_query("SELECT total,attempted,correct,`timeTaken` FROM user_reviewquizresult WHERE quizid='$quizId' AND userid='$userId' ");
        $row = mysql_fetch_array($result);
        $resultInfo['total'] = $row[0];
        $resultInfo['attempted'] = $row[1];
        $resultInfo['correct'] = $row[2];
        $resultInfo['time'] = $row[3];
        return $resultInfo;
    }

    public function getDailyQuizResult($quizId, $userId) {
        $result = mysql_query("SELECT total,attempted,correct,`timeTaken` FROM user_dailyquizresult WHERE quizid='$quizId' AND userid='$userId' ");
        $row = mysql_fetch_array($result);
        $resultInfo['total'] = $row[0];
        $resultInfo['attempted'] = $row[1];
        $resultInfo['correct'] = $row[2];
        $resultInfo['time'] = $row[3];
        return $resultInfo;
    }

    public function getCustomQuizResult($quizId, $userId) {
        $result = mysql_query("SELECT total,attempted,correct,`timeTaken` FROM user_customquiz WHERE id='$quizId' AND userid='$userId' ");
        $row = mysql_fetch_array($result);
        $resultInfo['total'] = $row[0];
        $resultInfo['attempted'] = $row[1];
        $resultInfo['correct'] = $row[2];
        $resultInfo['time'] = $row[3];
        return $resultInfo;
    }

    public function createSubTopicQuizActivity($userId, $subTopicId) {
        mysql_query("SET AUTOCOMMIT=0");
        mysql_query("START TRANSACTION");
        $result = mysql_query("INSERT INTO user_activity (`userId`,`type`,`relationId`) VALUES ('$userId','4','$subTopicId');");
        $affectedRows = mysql_affected_rows();
        if ($result && $affectedRows == 1) {
            mysql_query("COMMIT");
        } else {
            mysql_query("ROLLBACK");
        }
    }

    public function createReviewQuizActivity($userId, $topicId) {
        mysql_query("SET AUTOCOMMIT=0");
        mysql_query("START TRANSACTION");
        $result = mysql_query("INSERT INTO user_activity (`userId`,`type`,`relationId`) VALUES ('$userId','3','$topicId');");
        $affectedRows = mysql_affected_rows();
        if ($result && $affectedRows == 1) {
            mysql_query("COMMIT");
        } else {
            mysql_query("ROLLBACK");
        }
    }

    public function createDailyQuizActivity($userId, $subject) {
        mysql_query("SET AUTOCOMMIT=0");
        mysql_query("START TRANSACTION");
        $result = mysql_query("INSERT INTO user_activity (`userId`,`type`,`relationId`) VALUES ('$userId','2','$subject');");
        $affectedRows = mysql_affected_rows();
        if ($result && $affectedRows == 1) {
            mysql_query("COMMIT");
        } else {
            mysql_query("ROLLBACK");
        }
    }

    public function getNextQuizId($userId, $subject) {
        $query = "SELECT MAX(quizid) FROM user_dailyquizresult uqr,content_dailyquiz dq where uqr.quizid = dq.id AND dq.subject = '$subject'
                    AND uqr.userid = '$userId' AND uqr.status = '1'";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result);
        $quizId = $row[0];

        $query2 = "SELECT MIN(id) FROM content_dailyquiz WHERE subject = '$subject' AND id > '$quizId'";
        $result2 = mysql_query($query2);
        $row2 = mysql_fetch_array($result2);
        return $row2[0];
    }

    public function createDailyQuizUserEntry($userId, $quizId) {
        mysql_query("SET AUTOCOMMIT=0");
        mysql_query("START TRANSACTION");
        $result = mysql_query("INSERT INTO user_dailyquizresult (quizid,userid,total,attempted,correct,status,`timeTaken`) VALUES
                                ('$quizId','$userId','0','0','0','0','0')");
        $affectedRows = mysql_affected_rows();
        if ($result && $affectedRows == 1) {
            mysql_query("COMMIT");
        } else {
            mysql_query("ROLLBACK");
        }
    }

    public function generateCustomQuiz($userId, $topicArray, $noOfQuestion, $mode, $subject, $questions, $time) {
        $totalTopics = count($topicArray);
        if($totalTopics == 0){
            return FALSE;
        }
        $dataBlockFlag = 0;
        $mixBlock = 0;
        if (array_search(6, $topicArray) != NULL || $topicArray[0] == 6) {
            $dataBlockFlag++;
        }
        if (array_search(10, $topicArray) != NULL || $topicArray[0] == 10) {
            $dataBlockFlag++;
        }
        if (array_search(45, $topicArray) != NULL || $topicArray[0] == 45) {
            $dataBlockFlag++;
        }
        if (array_search(44, $topicArray) != NULL || $topicArray[0] == 44) {
            $mixBlock = 1;
        }



        $questionPerTopic = ceil($noOfQuestion / $totalTopics);
        $questionIds = NULL;
        mysql_query("SET AUTOCOMMIT=0");
        mysql_query("START TRANSACTION");
        $result = mysql_query("INSERT INTO user_customquiz (userId,subject,mode,questions,time) 
                                    VALUES ('$userId','$subject','$mode','$questions','$time')");
        if (mysql_affected_rows() == 1 && $result) {
            $quizId = mysql_insert_id();
            $i = 0;
            $totalQuestion = 0;
            if ($quizId > 0) {

                if ($totalTopics == 1 AND $dataBlockFlag == 1) {
                    $topic = $topicArray[0];
                    $blockIds = NULL;

                    $query = "SELECT `dependsOn`,count(`questionId`) as num FROM content_question q WHERE q.`dependsOn` != 0 AND 
                        q.`topicId` = '$topic' AND q.`questionId` NOT IN 
                            (SELECT `quesId` FROM user_contentanswer WHERE `userId` = '$userId')  GROUP BY `dependsOn` ORDER BY rand()";

                    $tq = 0;
                    $i = 0;
                    $result5 = mysql_query($query);
                    while ($row1 = mysql_fetch_assoc($result5)) {
                        $tq = $tq + $row1['num'];
                        $blockIds[$i++] = $row1['dependsOn'];
                        if ($tq >= ($noOfQuestion - 2)) {
                            break;
                        }
                    }

                    if (count($blockIds))
                        $blockImplode = implode(',', $blockIds);
                    else {
                        $blockImplode = 0;
                    }

                    $sql = "SELECT `questionId`,`dependsOn` FROM content_question WHERE `dependsOn` IN ($blockImplode)
                            ORDER BY `dependsOn`,`questionId`";

                    $result2 = mysql_query($sql);
                    while ($row = mysql_fetch_assoc($result2)) {
                        $questionId = $row['questionId'] . "." . $row['dependsOn'];
                        $result = mysql_query("INSERT INTO user_customquizquestion VALUES ('$quizId','$questionId')");
                        if ($result) {
                            $totalQuestion++;
                            $questionIds[$totalQuestion] = $questionId;
                        }
                    }
                } elseif ($totalTopics == 2 AND $dataBlockFlag == 2) {

                    if (count($topicArray)) {
                        $topicImplode = implode(',', $topicArray);
                    } else {
                        $topicImplode = 0;
                    }


                    $query = "SELECT `dependsOn`,count(`questionId`) as num FROM content_question q WHERE q.`dependsOn` != 0 AND 
                        q.`topicId` IN ($topicImplode) AND q.`questionId` NOT IN 
                            (SELECT `quesId` FROM user_contentanswer WHERE `userId` = '$userId')  GROUP BY `dependsOn` ORDER BY rand()";

                    $tq = 0;
                    $i = 0;
                    $result5 = mysql_query($query);
                    while ($row1 = mysql_fetch_assoc($result5)) {
                        $tq = $tq + $row1['num'];
                        $blockIds[$i++] = $row1['dependsOn'];
                        if ($tq >= ($noOfQuestion - 2)) {
                            break;
                        }
                    }

                    if (count($blockIds))
                        $blockImplode = implode(',', $blockIds);
                    else {
                        $blockImplode = 0;
                    }

                    $sql = "SELECT `questionId`,`dependsOn` FROM content_question WHERE `dependsOn` IN ($blockImplode)
                            ORDER BY `dependsOn`,`questionId`";

                    $result2 = mysql_query($sql);
                    while ($row = mysql_fetch_assoc($result2)) {
                        $questionId = $row['questionId'] . "." . $row['dependsOn'];
                        $result = mysql_query("INSERT INTO user_customquizquestion VALUES ('$quizId','$questionId')");
                        if ($result) {
                            $totalQuestion++;
                            $questionIds[$totalQuestion] = $questionId;
                        }
                    }
                } elseif ($dataBlockFlag > 0) {
                    $i = 0;
                    $blockIds = NULL;

                    if (array_search(6, $topicArray) != NULL || $topicArray[0] == 6) {
                        $query = "SELECT `dependsOn`,count(`questionId`) as num FROM content_question q WHERE q.`dependsOn` != 0 AND 
                        q.`topicId` = 6 AND q.`questionId` NOT IN 
                            (SELECT `quesId` FROM user_contentanswer WHERE `userId` = '$userId')  GROUP BY `dependsOn` ORDER BY rand() LIMIT 0,1";
                        $result5 = mysql_query($query);
                        while ($row1 = mysql_fetch_assoc($result5)) {
                            $blockIds[$i++] = $row1['dependsOn'];
                        }
                    }
                    if (array_search(10, $topicArray) != NULL || $topicArray[0] == 10) {
                        $query = "SELECT `dependsOn`,count(`questionId`) as num FROM content_question q WHERE q.`dependsOn` != 0 AND 
                        q.`topicId` = 10 AND q.`questionId` NOT IN 
                            (SELECT `quesId` FROM user_contentanswer WHERE `userId` = '$userId')  GROUP BY `dependsOn` ORDER BY rand() LIMIT 0,1";
                        $result5 = mysql_query($query);
                        while ($row1 = mysql_fetch_assoc($result5)) {
                            $blockIds[$i++] = $row1['dependsOn'];
                        }
                    }
                    if (array_search(45, $topicArray) != NULL || $topicArray[0] == 45) {
                        $query = "SELECT `dependsOn`,count(`questionId`) as num FROM content_question q WHERE q.`dependsOn` != 0 AND 
                        q.`topicId` = 45 AND q.`questionId` NOT IN 
                            (SELECT `quesId` FROM user_contentanswer WHERE `userId` = '$userId')  GROUP BY `dependsOn` ORDER BY rand() LIMIT 0,1";
                        $result5 = mysql_query($query);
                        while ($row1 = mysql_fetch_assoc($result5)) {
                            $blockIds[$i++] = $row1['dependsOn'];
                        }
                    }


                    if (count($blockIds))
                        $blockImplode = implode(',', $blockIds);
                    else {
                        $blockImplode = 0;
                    }

                    $sql = "SELECT `questionId`,`dependsOn` FROM content_question WHERE `dependsOn` IN ($blockImplode)
                            ORDER BY `dependsOn`,`questionId`";

                    $result2 = mysql_query($sql);
                    while ($row = mysql_fetch_assoc($result2)) {
                        $questionId = $row['questionId'] . "." . $row['dependsOn'];
                        $result = mysql_query("INSERT INTO user_customquizquestion VALUES ('$quizId','$questionId')");
                        if ($result) {
                            $totalQuestion++;
                            $questionIds[$totalQuestion] = $questionId;
                        }
                    }
                }


                if ($mixBlock == 1 && $totalTopics == 1) {
//                    echo "1111";
                    $topic = $topicArray[0];
                    $blockId = 0;
                    $query = "SELECT `dependsOn`,count(`questionId`) as num FROM content_question q WHERE q.`dependsOn` != 0 AND 
                        q.`topicId` = '$topic' AND q.`questionId` NOT IN 
                            (SELECT `quesId` FROM user_contentanswer WHERE `userId` = '$userId')  GROUP BY `dependsOn` ORDER BY rand() LIMIT 0,1";
                    $result5 = mysql_query($query);
                    while ($row1 = mysql_fetch_assoc($result5)) {
                        $blockId = $row1['dependsOn'];
                    }

                    $sql = "SELECT `questionId`,`dependsOn` FROM content_question WHERE `dependsOn` = '$blockId'
                            ORDER BY `dependsOn`,`questionId`";

                    $result2 = mysql_query($sql);

                    while ($row = mysql_fetch_assoc($result2)) {
                        $questionId = $row['questionId'] . "." . $row['dependsOn'];
                        $result = mysql_query("INSERT INTO user_customquizquestion VALUES ('$quizId','$questionId')");
                        if ($result) {
                            $totalQuestion++;
                            $questionIds[$totalQuestion] = $questionId;
                        }
                    }
                } elseif ($mixBlock == 1) {
                    if (rand(1, 10) % 2 == 1) {
                        $topic = $topicArray[0];
                        $blockId = 0;
                        $query = "SELECT `dependsOn`,count(`questionId`) as num FROM content_question q WHERE q.`dependsOn` != 0 AND 
                        q.`topicId` = '$topic' AND q.`questionId` NOT IN 
                            (SELECT `quesId` FROM user_contentanswer WHERE `userId` = '$userId')  GROUP BY `dependsOn` ORDER BY rand() LIMIT 0,1";
                        $result5 = mysql_query($query);
                        while ($row1 = mysql_fetch_assoc($result5)) {
                            $blockId = $row1['dependsOn'];
                        }

                        $sql = "SELECT `questionId`,`dependsOn` FROM content_question WHERE `dependsOn` = '$blockId'
                            ORDER BY `dependsOn`,`questionId`";

                        $result2 = mysql_query($sql);

                        while ($row = mysql_fetch_assoc($result2)) {
                            $questionId = $row['questionId'] . "." . $row['dependsOn'];
                            $result = mysql_query("INSERT INTO user_customquizquestion VALUES ('$quizId','$questionId')");
                            if ($result) {
                                $totalQuestion++;
                                $questionIds[$totalQuestion] = $questionId;
                            }
                        }

                        unset($topicArray[array_search($topic, $topicArray)]);
                    }
                }

                if (array_search(6, $topicArray) != NULL || (isset($topicArray[0]) && $topicArray[0] == 6)) {
                    unset($topicArray[array_search(6, $topicArray)]);
                }
                if (array_search(10, $topicArray) != NULL || (isset($topicArray[0]) && $topicArray[0] == 10)) {
                    unset($topicArray[array_search(10, $topicArray)]);
                }
                if (array_search(45, $topicArray) != NULL || (isset($topicArray[0]) && $topicArray[0] == 45)) {
                    unset($topicArray[array_search(45, $topicArray)]);
                }

                $topicArray = array_values($topicArray);
                $totalTopics = count($topicArray);
                $newNoofQuestions = $noOfQuestion - $totalQuestion;
                if ($totalTopics > 0)
                    $questionPerTopic = ceil($newNoofQuestions / $totalTopics);

                foreach ($topicArray as $value) {
                    $i++;
                    if ($i == $totalTopics) {
                        $questionPerTopic = $noOfQuestion - $totalQuestion;
                    }
                    $sql = "SELECT `questionId` FROM content_question WHERE `topicId` = '$value' AND `relationId` IS NULL 
                                AND `questionId` NOT IN (SELECT `quesId` FROM user_contentanswer WHERE `userId` = '$userId') AND `dependsOn` = 0
                                    ORDER BY RAND() LIMIT 0,$questionPerTopic;";
                    $result2 = mysql_query($sql);
                    while ($row = mysql_fetch_assoc($result2)) {
                        $questionId = $row['questionId'];
                        $result = mysql_query("INSERT INTO user_customquizquestion VALUES ('$quizId','$questionId')");
                        if ($result) {
                            $totalQuestion++;
                            $questionIds[$totalQuestion] = $questionId;
                        }
                    }
                }

                if ($totalQuestion < $noOfQuestion && $totalTopics != 0) {
                    $topicIds = implode(',', $topicArray);
                    $questionPerTopic = $noOfQuestion - $totalQuestion;
                    $sql = "SELECT `questionId` FROM content_question,user_contentanswer WHERE `topicId` IN ($topicIds) AND
                            `questionId` = `quesId` AND `userId` = '$userId' AND `isCorrect` = '0' AND `dependsOn` = 0
                                ORDER BY RAND() LIMIT 0,$questionPerTopic;";
                    $result2 = mysql_query($sql);
                    while ($row = mysql_fetch_assoc($result2)) {
                        $questionId = $row['questionId'];
                        $result = mysql_query("INSERT INTO user_customquizquestion VALUES ('$quizId','$questionId')");
                        if ($result) {
                            $totalQuestion++;
                            $questionIds[$totalQuestion] = $questionId;
                        }
                    }
                }

                if ($totalQuestion < $noOfQuestion && $totalTopics != 0) {
                    if (count($questionIds))
                        $questionImpode = implode(',', $questionIds);
                    else {
                        $questionImpode = 0;
                    }
                    $topicIds = implode(',', $topicArray);
                    $questionPerTopic = $noOfQuestion - $totalQuestion;
                    $sql = "SELECT `questionId` FROM content_question WHERE `questionId` NOT IN ($questionImpode) AND
                                `topicId` IN ($topicIds) AND `dependsOn` = 0
                                ORDER BY RAND() LIMIT 0,$questionPerTopic;";
                    $result2 = mysql_query($sql);
                    while ($row = mysql_fetch_assoc($result2)) {
                        $questionId = $row['questionId'];
                        $result = mysql_query("INSERT INTO user_customquizquestion VALUES ('$quizId','$questionId')");
                        if ($result) {
                            $totalQuestion++;
                        }
                    }
                }

//                echo "<br><br>Total:" . $totalQuestion;

                if (($noOfQuestion - 2) <= $totalQuestion) {
                    mysql_query("COMMIT");
//                    mysql_query("ROLLBACK");
                    return $quizId;
                } else {
                    mysql_query("ROLLBACK");
                    return FALSE;
                }
            } else {
                mysql_query("ROLLBACK");
                return FALSE;
            }
        } else {
            mysql_query("ROLLBACK");
            return FALSE;
        }
        return FALSE;
    }

    public function getCustomQuizInfo($userId, $quizId) {
        $sql = "SELECT mode,time FROM user_customquiz WHERE `id`='$quizId' AND `userId`='$userId'";
        $result = mysql_query($sql);
        if ($result) {
            if (mysql_num_rows($result) == 1) {
                $row = mysql_fetch_array($result);
                return $row;
            } else {
                return FALSE;
            }
        }
    }

}

?>