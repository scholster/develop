<?php

class AnalyticsModel {

    function getCommunityBasicAnalytics($subject) {
        $query = "SELECT COUNT(ua.id) as total, SUM(ua.`isCorrect`) as correct , SUM(ua.`timeTaken`) as totalTime
                FROM user_contentanswer ua, content_question q, content_topic t
                WHERE ua.`quesId`=q.`questionId` AND q.`topicId` = t.id AND t.subject = '$subject'";
        $result = mysql_query($query);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    function getCommunityBasicAnalyticsByCorrect($subject, $userId) {
        $query = "SELECT COUNT(ua.id) as total, SUM(ua.`isCorrect`) as correct , SUM(ua.`timeTaken`) as totalTime
                FROM user_contentanswer ua, content_question q, content_topic t
                WHERE ua.`quesId`=q.`questionId` AND ua.`quesId` IN 
                (SELECT `quesId` FROM user_contentanswer WHERE `userId` = '$userId' AND subject='$subject' AND `isCorrect` = '1') 
                AND q.`topicId` = t.id AND t.subject = '$subject'";
        $result = mysql_query($query);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    function getCommunityBasicAnalyticsByInCorrect($subject, $userId) {
        $query = "SELECT COUNT(ua.id) as total, SUM(ua.`isCorrect`) as correct , SUM(ua.`timeTaken`) as totalTime
                FROM user_contentanswer ua, content_question q, content_topic t
                WHERE ua.`quesId`=q.`questionId` AND ua.`quesId` IN 
                (SELECT `quesId` FROM user_contentanswer WHERE `userId` = '$userId' AND subject='$subject' AND `isCorrect` = '0') 
                AND q.`topicId` = t.id AND t.subject = '$subject' AND ua.`userId` != '$userId'";
        $result = mysql_query($query);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    function getBasicAnalytics($userId, $subject) {
        $query = "SELECT COUNT(ua.id) as total, SUM(ua.`isCorrect`) as correct , SUM(ua.`timeTaken`) as totalTime
                FROM user_contentanswer ua, content_question q, content_topic t
                WHERE `userId` = '$userId' AND ua.`quesId`=q.`questionId` AND q.`topicId` = t.id AND t.subject = '$subject'";
        $result = mysql_query($query);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    function getBasicAnalyticsByTime($userId, $subject) {
        $query = "SELECT COUNT(ua.id) as total, SUM(ua.`isCorrect`) as correct , SUM(ua.`timeTaken`) as totalTime
                FROM user_contentanswer ua, content_question q, content_topic t
                WHERE `userId` = '$userId' AND ua.`quesId`=q.`questionId` AND q.`topicId` = t.id AND t.subject = '$subject'
                AND `doneOn` BETWEEN DATE_SUB( NOW( ) , INTERVAL 1 WEEK ) AND NOW( )";
        $result = mysql_query($query);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    function getBasicAnalyticsByCorrect($userId, $subject) {
        $query = "SELECT COUNT(ua.id) as total, SUM(ua.`isCorrect`) as correct , SUM(ua.`timeTaken`) as totalTime
                FROM user_contentanswer ua, content_question q, content_topic t
                WHERE `userId` = '$userId' AND ua.`quesId`=q.`questionId` AND q.`topicId` = t.id AND t.subject = '$subject'
                AND ua.`isCorrect` = '1'";
        $result = mysql_query($query);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    function getBasicAnalyticsByInCorrect($userId, $subject) {
        $query = "SELECT COUNT(ua.id) as total, SUM(ua.`isCorrect`) as correct , SUM(ua.`timeTaken`) as totalTime
                FROM user_contentanswer ua, content_question q, content_topic t
                WHERE `userId` = '$userId' AND ua.`quesId`=q.`questionId` AND q.`topicId` = t.id AND t.subject = '$subject'
                AND ua.`isCorrect` = '0'";
        $result = mysql_query($query);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    function getTopicWiseAnalytics($userId, $subject) {
        $query = "SELECT COUNT(ua.id) as total, SUM(ua.`isCorrect`) as correct , SUM(ua.`timeTaken`) as totalTime, t.topic as topic, t.id as topicId
                FROM user_contentanswer ua, content_question q, content_topic t
                WHERE `userId` = '$userId' AND ua.`quesId`=q.`questionId` AND q.`topicId` = t.id AND t.subject = '$subject' GROUP BY t.id";
        $result = mysql_query($query);
        $analytics = NULL;
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $analytics[$i]['topicId'] = $row['topicId'];
            $analytics[$i]['topic'] = $row['topic'];
            $analytics[$i]['total'] = $row['total'];
            $analytics[$i]['correct'] = $row['correct'];
            $analytics[$i]['totalTime'] = $row['totalTime'];
            $i++;
        }
        return $analytics;
    }

    function getTopicWiseAnalyticsByCorrect($userId, $subject) {
        $query = "SELECT COUNT(ua.id) as total, SUM(ua.`isCorrect`) as correct , SUM(ua.`timeTaken`) as totalTime, t.topic as topic, t.id as topicId
                FROM user_contentanswer ua, content_question q, content_topic t
                WHERE `userId` = '$userId' AND ua.`quesId`=q.`questionId` AND q.`topicId` = t.id AND t.subject = '$subject'
                AND ua.`isCorrect` = '1' GROUP BY t.id";
        $result = mysql_query($query);
        $analytics = NULL;
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $analytics[$i]['topicId'] = $row['topicId'];
            $analytics[$i]['topic'] = $row['topic'];
            $analytics[$i]['total'] = $row['total'];
            $analytics[$i]['correct'] = $row['correct'];
            $analytics[$i]['totalTime'] = $row['totalTime'];
            $i++;
        }
        return $analytics;
    }
    
    function getTopicWiseAnalyticsByInCorrect($userId, $subject) {
        $query = "SELECT COUNT(ua.id) as total, SUM(ua.`isCorrect`) as correct , SUM(ua.`timeTaken`) as totalTime, t.topic as topic, t.id as topicId
                FROM user_contentanswer ua, content_question q, content_topic t
                WHERE `userId` = '$userId' AND ua.`quesId`=q.`questionId` AND q.`topicId` = t.id AND t.subject = '$subject'
                AND ua.`isCorrect` = '0' GROUP BY t.id";
        $result = mysql_query($query);
        $analytics = NULL;
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $analytics[$i]['topicId'] = $row['topicId'];
            $analytics[$i]['topic'] = $row['topic'];
            $analytics[$i]['total'] = $row['total'];
            $analytics[$i]['correct'] = $row['correct'];
            $analytics[$i]['totalTime'] = $row['totalTime'];
            $i++;
        }
        return $analytics;
    }

    function getTopicWiseCommunityAnalytics($subject) {
        $query = "SELECT COUNT(ua.id) as total, SUM(ua.`isCorrect`) as correct , SUM(ua.`timeTaken`) as totalTime, t.topic as topic, t.id as topicId
                FROM user_contentanswer ua, content_question q, content_topic t
                WHERE ua.`quesId`=q.`questionId` AND q.`topicId` = t.id AND t.subject = '$subject' GROUP BY t.id";
        $result = mysql_query($query);
        $analytics = NULL;
        while ($row = mysql_fetch_assoc($result)) {
            $topicId = $row['topicId'];
            $analytics[$topicId]['total'] = $row['total'];
            $analytics[$topicId]['correct'] = $row['correct'];
            $analytics[$topicId]['totalTime'] = $row['totalTime'];
        }

        return $analytics;
    }

    function getTopicWiseCommunityAnalyticsByCorrect($subject,$userId) {
        $query = "SELECT COUNT(ua.id) as total, SUM(ua.`isCorrect`) as correct , SUM(ua.`timeTaken`) as totalTime, t.topic as topic, t.id as topicId
                FROM user_contentanswer ua, content_question q, content_topic t
                WHERE ua.`quesId`=q.`questionId` AND q.`topicId` = t.id AND t.subject = '$subject' AND ua.`quesId` IN 
                (SELECT `quesId` FROM user_contentanswer WHERE `userId` = '$userId' AND subject='$subject' AND `isCorrect` = '1')
                 GROUP BY t.id";
        $result = mysql_query($query);
        $analytics = NULL;
        while ($row = mysql_fetch_assoc($result)) {
            $topicId = $row['topicId'];
            $analytics[$topicId]['total'] = $row['total'];
            $analytics[$topicId]['correct'] = $row['correct'];
            $analytics[$topicId]['totalTime'] = $row['totalTime'];
        }

        return $analytics;
    }
    
    function getTopicWiseCommunityAnalyticsByInCorrect($subject,$userId) {
        $query = "SELECT COUNT(ua.id) as total, SUM(ua.`isCorrect`) as correct , SUM(ua.`timeTaken`) as totalTime, t.topic as topic, t.id as topicId
                FROM user_contentanswer ua, content_question q, content_topic t
                WHERE ua.`quesId`=q.`questionId` AND q.`topicId` = t.id AND t.subject = '$subject' AND ua.`quesId` IN 
                (SELECT `quesId` FROM user_contentanswer WHERE `userId` = '$userId' AND subject='$subject' AND ua.`userId` != '$userId' AND `isCorrect` = '0')
                 GROUP BY t.id";
        $result = mysql_query($query);
        $analytics = NULL;
        while ($row = mysql_fetch_assoc($result)) {
            $topicId = $row['topicId'];
            $analytics[$topicId]['total'] = $row['total'];
            $analytics[$topicId]['correct'] = $row['correct'];
            $analytics[$topicId]['totalTime'] = $row['totalTime'];
        }

        return $analytics;
    }

}

?>